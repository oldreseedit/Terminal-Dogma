<?php
class News extends CI_Controller {

        const TOP_N_NEWS = 10;
        
        public function __construct()
        {
                parent::__construct();
                $this->load->model('news_model');
                $this->load->model('user_notifications_model');
                $this->load->helper('url');
        }
        
        public function init()
        {
            $this->news_model->init();
        }
        
        public function add()
        {
            $text = $this->input->post('text');
            if($text == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare il testo della news o notifica.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("text")));
                return;
            }
            
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;
            
            $publishing_timestamp = date("Y-m-d H:i:s");
            
            // $users = $this->input->post('users');
            // if($users == false) $users = null;
            
            // // CHECK: count su una variabile che cosa torna?
            // if(count($users) == 1)
            // {
            //     $users = array();
            //     array_push($users, $this->input->post('users'));
            // }
            
            // TODO: transaction
            
            // Store the news itself
            $newsID = $this->news_model->add($text, $publishing_timestamp, $courseID);
            
            // Associate the news to each user
            // if($users != null) $this->user_notifications_model->add($newsID, $users);
            
            echo json_encode(array("error" => false, "description" => "News memorizzata con successo."));
            return;
        }
        
        public function delete()
        {
            $newsID = $this->input->post('newsID');
            if($newsID == false) $newsID = null;
            
            $this->news_model->delete($newsID);
            // $this->user_notifications_model->delete($newsID);
        }
        
        public function get()
        {
            $newsID = $this->input->post('newsID');
            if($newsID == false) $newsID = null;
            
            echo json_encode($this->news_model->get($newsID));
            return;
        }
        
        // public function get_news_status()
        // {
        //     $newsID = $this->input->post('newsID');
        //     if($newsID == false) $newsID = null;
            
        //     $data = $this->user_notifications_model->get($newsID);
            
        //     $result = array();
        //     foreach($data as $userData)
        //     {
        //         $result[$userData['username']] = $userData['seen'];
        //     }
            
        //     echo json_encode($result);
        //     return;
        // }
        
        public function get_latest_news()
        {
            $top = $this->input->post('top');
            if($top == false) $top = self::TOP_N_NEWS;
            
            echo json_encode($this->news_model->get_latest_news($top));
            return;
        }
        
        public function get_latest_user_notifications()
        {
            $username = $this->input->post('username');
            if($username == false) $username = null;
            
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;

            $result = array();
            $db_result = $this->user_notifications_model->get_latest_user_notifications($username);
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