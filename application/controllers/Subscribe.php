<?php
class Subscribe extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url');
                
                $this->load->model('user_model');
                $this->load->model('user_info_model');
        }
        
        public function init()
        {
            $this->user_model->init();
            $this->user_info_model->init();
        }
        
        // public function add()
        // {
        //     $userID = $this->input->post('userID');
        //     if($userID == false) $userID = null;
            
        //     $password = $this->input->post('password');
        //     if($password == false) $password = null;
            
        //     $accept = $this->input->post('accept');
        //     if(!isset($_POST['accept'])) $accept = false;
        //     if($accept)
        //     {
        //         // Add the pair user/password in the User table
        //         $this->user_model->add($userID, $password);
                
        //         $mail = $this->input->post('mail');
        //         if(!isset($_POST['mail'])) $mail = null;
                
        //         // Get the registration date
        //         $registration_timestamp = date("Y-m-d H:i:s");
                
        //         // Add the entry in the user_info table
        //         $this->user_info_model->add($userID, $mail, $registration_timestamp);
        //     }
        // }
        
        // public function delete()
        // {
        //     $userID = $this->input->post('userID');
        //     if($userID == false) $userID = null;
            
        //     $this->user_model->delete($userID, $password);
        //     $this->user_info_model->delete($userID);
        // }
}
?>