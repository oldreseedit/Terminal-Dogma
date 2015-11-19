<?php
class Admins extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('admins_model');
                $this->load->helper('url');
        }
        
        public function init()
        {
            $this->admins_model->init();
        }
        
        public function list_admins()
        {
            print_r($this->admins_model->get_admins());
        }
        
        public function add()
        {
            $userID = $this->input->post('userID');
            if($userID) add_private(urldecode($userID));
        }
        
        public function add_private($userID)
        {
            $this->admins_model->add_admin(urldecode($userID));
        }
        
        public function is_admin()
        {
            $userID = $this->input->post('username');
            if(!$userID)
            {
                echo json_encode(array("error" => true, "description" => "Specificare un nome utente.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
                return;
            }
            
            echo json_encode($this->admins_model->is_admin($userID));
        }
        
        public function set()
        {
            $userID = $this->input->post('userID');
            if($userID == false) $userID = null;

            $isAdmin = $this->input->post('isAdmin');
            if(!isset($_POST['isAdmin'])) $isAdmin = true;
            
            set_private($userID, $isAdmin);
        }
        
        public function set_private($userID, $isAdmin = true)
        {
            $this->admins_model->set_admin(urldecode($userID), $isAdmin);
        }
}
?>