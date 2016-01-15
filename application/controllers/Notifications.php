<?php

// TODO: nella add: gestire corso che non esiste, utente che non esiste

class Notifications extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('notifications_model');
                $this->load->model('payment_model');
                $this->load->helper('url');
                
                $this->load->model('notification_rights_model');
                $this->load->model('userinfo_model');
                
                $this->load->library('time');
        }
        
        public function init()
        {
            $this->notifications_model->init();
        }
        
        public function add()
        {
            $text = $this->input->post('text');
            if($text == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare il testo della news o notifica.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("text")));
                return;
            }
            
            $private = $this->input->post('private');
            if(!isset($_POST['private'])) $private = false;
            
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;
            
            $publishing_timestamp = $this->time->get_timestamp();
            
            $users = array();
            foreach($this->payment_model->get_subscribers_names($courseID) as $subscription)
            {
                $users[] = $subscription['userID'];
            }
            
            if(!$users)
            {
            	echo json_encode(array("error" => true, "description" => "Non esistono utenti iscritti a questo corso. Non sono state perciò generate alcune notifiche.", "errorCode" => "MANDATORY_FIELD", "parameters" => array()));
            	return;
            }
            
            foreach($users as $userID)
            {
            	// Setup sending email permission
            	$email = null;
            	// Get the email of the target user
            	$rights = $this->CI->notification_rights_model->get($userID);
            	// If he agreed to receive emails, send him an email with the notification
            	if($rights && $rights['info']) $email = $this->CI->userinfo_model->get($userID)['email'];
            	if($email) $this->CI->mailer->send_mail($email, "Novità sui corsi che frequenti a reSeed", "Il corso " . $courseId . " ha un nuovo avviso: " . $text);
            }
            
            // Store the notification
            $this->notifications_model->add($text, $publishing_timestamp, $users, $private, $courseID);
            
            echo json_encode(array("error" => false, "description" => "Notifica memorizzata con successo."));
            return;
        }
        
        public function add_to_user()
        {
            $text = $this->input->post('text');
            if($text == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare il testo della news o notifica.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("text")));
                return;
            }
            
            $private = $this->input->post('private');
            if(!isset($_POST['seen'])) $private = false;
            
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;
            
            $publishing_timestamp = $this->time->get_timestamp();
            
            $users = $this->input->post('users');
            if($users == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare il testo della news o notifica.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("users")));
                return;
            }
            
            // CHECK: count su una variabile che cosa torna?
            if(count($users) == 1)
            {
                $users = array();
                array_push($users, $this->input->post('users'));
            }
            
            // Store the notification
            $this->notifications_model->add($text, $publishing_timestamp, $users, $private, $courseID);
            
            echo json_encode(array("error" => false, "description" => "Notifica memorizzata con successo."));
            return;
        }
        
        public function delete()
        {
            $notificationID = $this->input->post('notificationID');
            if($notificationID == false)
            {
                echo json_encode(array("error" => true, "description" => "Errore durante l'eliminazione della notifica. Specificare una notifica.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("notificationID")));
                return;
            }
            
            $this->notifications_model->delete($notificationID);
            
            echo json_encode(array("error" => false, "description" => "Notifica eliminata con successo."));
            return;
        }
        
        public function update()
        {
            $notificationID = $this->input->post('notificationID');
            if($notificationID == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare una notifica.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("notificationID")));
                return;
            }
            
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;
            
            $seen = false;
            if(isset($_POST['seen'])) $seen = $this->input->post('seen') === "true";
            
            $text = $this->input->post('text');
            if($text == false) $text = null;
            
            $private = $this->input->post('private');
            if(!isset($_POST['seen'])) $private = false;
            
            $this->notifications_model->update($notificationID, $text, $seen, $private, $courseID);
            
            echo json_encode(array("error" => false, "description" => "Notifica modificata con successo."));
            return;
        }

		public function update_seen()
		{
			$notificationIDs = $this->input->post('notificationIDs');
			if($notificationIDs == false)
			{
				echo json_encode(array("error" => true, "description" => "Specificare almeno una notifica.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("notificationIDs")));
				return;
			}
			
			$data = array();
			foreach ($notificationIDs as $notificationID)
			{
				$notificationData = array();
		
				$notificationData['notificationID'] = $notificationID;
				$notificationData['seen'] = true;
		
				$data[] = $notificationData;
			}
		
			// Update the users' attendances
			$this->notifications_model->update_batch($data);
		}
        
        public function get()
        {
            $courseID = $this->input->post('courseID');
            if($courseID == false)
            {
            	echo json_encode(array("error" => true, "description" => "Specificare un corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
            	return;
            }

            echo json_encode($this->notifications_model->get_notifications($courseID));
            return;
        }
        
        public function get_user_notifications()
        {
            $username = $this->input->post('username');
            if($username == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare un utente.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
                return;
            }
            
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;

            $result = array();
            $db_result = $this->notifications_model->get_user_notifications($username, $courseID);
            foreach($db_result as $userNotification)
            {
                $filteredUserNotification = array();
                
                foreach($userNotification as $key => $value)
                {
                    if(strcmp($key, "username") == 0) continue;
                    $filteredUserNotification[$key] = $value;
                }
                
                array_push($result, $filteredUserNotification);
            }
            
            echo json_encode($result);
            return;
        }
        
        public function get_unseen_user_notifications()
        {
            $username = $this->input->post('username');
            if($username == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare un utente.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
                return;
            }
            
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;

            $result = array();
            $db_result = $this->notifications_model->get_unseen_user_notifications($username, $courseID);
            foreach($db_result as $userNotification)
            {
                $filteredUserNotification = array();
                
                foreach($userNotification as $key => $value)
                {
                    if(strcmp($key, "username") == 0) continue;
                    $filteredUserNotification[$key] = $value;
                }
                
                array_push($result, $filteredUserNotification);
            }
            
            echo json_encode($result);
            return;
        }
}
?>