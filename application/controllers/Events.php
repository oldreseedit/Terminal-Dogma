<?php
class Events extends CI_Controller {

        const TOP_N_EVENTS = 10;
        
        public function __construct()
        {
                parent::__construct();
                $this->load->model('events_model');
                $this->load->model('preferences_model');
                $this->load->model('userinfo_model');
        }
        
        public function init()
        {
            $this->events_model->init();
        }
        
        public function add()
        {
            $title = $this->input->post('title');
            if($title == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare il titolo dell'evento.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("title")));
                return;
            }
            
            $description = $this->input->post('description');
            if($description == false)
            {
            	echo json_encode(array("error" => true, "description" => "Specificare la descrizione dell'evento.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("description")));
            	return;
            }
            
            $place = $this->input->post('place');
            if($place == false)
            {
            	echo json_encode(array("error" => true, "description" => "Specificare il luogo dell'evento.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("place")));
            	return;
            }
            
            $startingDate = $this->input->post('startingDate');
            if($startingDate == false)
            {
            	echo json_encode(array("error" => true, "description" => "Specificare l'ora di inizio dell'evento.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("startingDate")));
            	return;
            }
            
            $endingDate = $this->input->post('endingDate');
            if($endingDate == false)
            {
            	echo json_encode(array("error" => true, "description" => "Specificare l'ora di fine dell'evento.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("endingDate")));
            	return;
            }
            
            $publishing_timestamp = date("Y-m-d H:i:s");
            
            $this->db->trans_start();
            
            // Get all the users
           	$users_info = $this->userinfo_model->get_all();
           	foreach($users_info as $user_info)
           	{
           		$userID = $user_info['userID'];
           		
           		// Setup sending email permission
           		$email = null;
           		// Get the email of the target user
           		$rights = $this->preferences_model->get($userID);
           		// If he agreed to receive emails, send him an email with the notification
           		if($rights && $rights['events']) $email = $user_info['email'];
           		if($email) $this->mailer->send_mail($email, "Novità sugli eventi organizzati da reSeed", $title . ": " . $description);
           	}
            
            // Store the event itself
            $this->events_model->add($title, $description, $place, $startingDate, $endingDate, $publishing_timestamp);
            
            $this->db->trans_complete();
            
            echo json_encode(array("error" => false, "description" => "Evento memorizzato con successo."));
        }
        
        public function delete()
        {
            $eventID = $this->input->post('eventID');
            if($eventID == false) $eventID = null;
            
            $this->events_model->delete($eventID);
        }
        
        public function get()
        {
            $eventID = $this->input->post('eventID');
            if($eventID == false) $eventID = null;
            
            echo json_encode($this->events_model->get($eventID));
            return;
        }
        
        public function get_latest_events()
        {
            $top = $this->input->post('top');
            if($top == false) $top = self::TOP_N_EVENTS;
            
            echo json_encode($this->events_model->get_latest_events($top));
            return;
        }
}
?>