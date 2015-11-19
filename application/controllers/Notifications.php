<?php

// TODO: nella add: gestire corso che non esiste, utente che non esiste

class Notifications extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('notifications_model');
                $this->load->model('payment_model');
                $this->load->helper('url');
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
            if(!isset($_POST['seen'])) $private = false;
            
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;
            
            $publishing_timestamp = date("Y-m-d H:i:s");
            
            $users = array();
            foreach($this->payment_model->get_subscribers_names($courseID) as $subscription)
            {
                array_push($users, $subscription['userID']);
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
            
            $publishing_timestamp = date("Y-m-d H:i:s");
            
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
            
            $seen = $this->input->post('seen');
            if(!isset($_POST['seen'])) $seen = null;
            
            $text = $this->input->post('text');
            if($text == false) $text = null;
            
            $private = $this->input->post('private');
            if(!isset($_POST['seen'])) $private = false;
            
            $this->notifications_model->update($notificationID, $text, $seen, $private, $courseID);
            
            echo json_encode(array("error" => false, "description" => "Notifica modificata con successo."));
            return;
        }
        
        // public function get_latest_news()
        // {
        //     $top = $this->input->post('top');
        //     if($top == false) $top = self::TOP_N_NEWS;
            
        //     echo json_encode($this->news_model->get_latest_news($top));
        //     return;
        // }
        
        public function get()
        {
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;

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