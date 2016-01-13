<?php
class Notification_rights extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('notification_rights_model');
                $this->load->helper('url');
        }
        
        public function init()
        {
            $this->notification_rights_model->init();
        }
        
        public function set()
        {
            $userID = $this->input->post('userID');
            if($userID == false)
            {
            	echo json_encode(array("error" => true, "description" => "Il nome utente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
            	return;
            }

            $data = array();
            
            if(isset($_POST['exp'])) $data['exp'] = $this->input->post('exp');
            if(isset($_POST['info'])) $data['info'] = $this->input->post('info');
            if(isset($_POST['news'])) $data['news'] = $this->input->post('news');
            if(isset($_POST['events'])) $data['events'] = $this->input->post('events');
            
            if(!empty($data)) $this->notification_rights_model->set($userID, $data);
        }
        
        public function get()
        {
        	$userID = $this->input->post('userID');
        	if($userID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Il nome utente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}
        	
        	echo json_encode($this->notification_rights_model->get($userID));
        }
}
?>