<?php
class Preferences extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('preferences_model');
                $this->load->helper('url');
                $this->load->model('userinfo_model');
        }
        
        public function index()
        {
        	$this->load->view('preferences/preferences');
        }
        
        public function init()
        {
        	$this->db->trans_start();
        	
            $this->preferences_model->init();
            
            foreach($this->userinfo_model->get_all() as $user)
            {
            	$user_notification_rights = $this->preferences_model->get($user['userID']);
            	if(!$user_notification_rights) $this->preferences_model->add($user['userID'], 0, 0, 0, 0);
            }
            
            $this->db->trans_complete();
        }
        
        public function add()
        {
        	$userID = $this->input->post('userID');
        	if($userID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Il nome utente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}
        
        	$data = array();
        
        	$exp = $this->input->post('exp');
        	if($exp == false)
        	{
        		echo json_encode(array("error" => true, "description" => "E' obbligatorio specificare i permessi per la pubblicazione degli exp.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("exp")));
        		return;
        	}
        	
        	$info = $this->input->post('info');
        	if($info == false)
        	{
        		echo json_encode(array("error" => true, "description" => "E' obbligatorio specificare i permessi per la pubblicazione delle info.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("info")));
        		return;
        	}
        	
        	$news = $this->input->post('news');
        	if($news == false)
        	{
        		echo json_encode(array("error" => true, "description" => "E' obbligatorio specificare i permessi per la pubblicazione delle news.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("news")));
        		return;
        	}
        	
        	$events = $this->input->post('events');
        	if($events == false)
        	{
        		echo json_encode(array("error" => true, "description" => "E' obbligatorio specificare i permessi per la pubblicazione degli eventi.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("events")));
        		return;
        	}
        	
        	$this->preferences_model->add($userID, $exp, $info, $news, $events);
        }
        
        public function update()
        {
            $userID = $this->input->post('userID');
            if($userID == false)
            {
            	echo json_encode(array("error" => true, "description" => "Il nome utente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
            	return;
            }

            $notifications = array();
            
            $data = array();
            
            if(isset($_POST['exp'])) $data['exp'] = $this->input->post('exp') === 'true' ? 1 : 0;
            if(isset($_POST['info'])) $data['info'] = $this->input->post('info') === 'true' ? 1 : 0;
            if(isset($_POST['news'])) $data['news'] = $this->input->post('news') === 'true' ? 1 : 0;
            if(isset($_POST['events'])) $data['events'] = $this->input->post('events') === 'true' ? 1 : 0;
            
            if(!empty($data))
            {
            	$this->preferences_model->update($userID, $data);
            	$notifications[] = array("error" => false, "description" => "Preferenze utente modificate correttamente.");
            }
            else
            {
            	$notifications[] = array("error" => true, "description" => "Non hai modificato alcuna preferenza.");
            }
            
            echo json_encode($notifications);
        }
        
        public function get()
        {
        	$userID = $this->input->post('userID');
        	if($userID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Il nome utente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}
        	
        	echo json_encode($this->preferences_model->get($userID));
        }
}
?>