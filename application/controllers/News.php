<?php
class News extends CI_Controller {

        const TOP_N_EVENTS = 10;
        
        public function __construct()
        {
                parent::__construct();
                $this->load->model('news_model');
                $this->load->model('preferences_model');
                $this->load->model('userinfo_model');
        }
        
        public function init()
        {
            $this->news_model->init();
        }
        
        public function add()
        {
            $title = $this->input->post('title');
            if($title == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare il titolo della news.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("title")));
                return;
            }
            
            $description = $this->input->post('description');
            if($description == false)
            {
            	echo json_encode(array("error" => true, "description" => "Specificare la descrizione della news.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("description")));
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
           		if($rights && $rights['news']) $email = $user_info['email'];
           		if($email) $this->mailer->send_mail($email, "Novità su reSeed", $title . ": " . $description);
           	}
            
            // Store the news itself
            $this->news_model->add($title, $description, $publishing_timestamp);
            
            $this->db->trans_complete();
            
            echo json_encode(array("error" => false, "description" => "News memorizzata con successo."));
        }
        
        public function delete()
        {
            $newsID = $this->input->post('newsID');
            if($newsID == false) $newsID = null;
            
            $this->news_model->delete($newsID);
        }
        
        public function get()
        {
            $newsID = $this->input->post('newsID');
            if($newsID == false) $newsID = null;
            
            echo json_encode($this->news_model->get($newsID));
            return;
        }
        
        public function get_latest_news()
        {
            $top = $this->input->post('top');
            if($top == false) $top = self::TOP_N_NEWS;
            
            echo json_encode($this->news_model->get_latest_news($top));
            return;
        }
        
//         public function get_latest_user_notifications()
//         {
//             $username = $this->input->post('username');
//             if($username == false) $username = null;
            
//             $courseID = $this->input->post('courseID');
//             if($courseID == false) $courseID = null;

//             $result = array();
//             $db_result = $this->user_notifications_model->get_latest_user_notifications($username);
//             foreach($db_result as $userNotification)
//             {
//                 $filteredUserNotification = array();
                
//                 foreach($userNotification as $key => $value)
//                 {
//                     if(strcmp($key, "username") == 0) continue;
//                     $filteredUserNotification[$key] = $value;
//                 }
                
//                 array_push($result, $filteredUserNotification);
//             }
            
//             echo json_encode($result);
//             return;
//         }
}
?>