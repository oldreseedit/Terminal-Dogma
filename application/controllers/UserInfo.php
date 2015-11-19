<?php
class UserInfo extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('userinfo_model');
                $this->load->helper('url');
        }
        
        public function init()
        {
            $this->userinfo_model->init();
        }
        
        // public function add()
        // {
        //     $userID = $this->input->post('userID');
        //     if($userID == false) $userID = null;
            
        //     $mail = $this->input->post('email');
        //     if($mail == false) $mail = null;
            
        //     $registration_timestamp = $this->input->post('registrationTimestamp');
        //     if($registration_timestamp == false) $registration_timestamp = null;
            
        //     $this->userinfo_model->add($userID, $mail, $registration_timestamp);
        // }
        
        // public function delete()
        // {
        //     $userID = $this->input->post('userID');
        //     if($userID == false) $userID = null;
            
        //     echo json_encode($this->userinfo_model->delete($userID));
        // }
        
        // public function update()
        // {
        //     $post_array = $this->input->post();
        //     // foreach($post_array as $key => $value) {
        //     //     $data[] = 
        //     // }
            
        //     $this->userinfo_model->update($post_array);
        // }
}
?>