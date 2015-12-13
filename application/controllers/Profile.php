<?php

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('admins_model');
		
		$this->load->model('profile_block_positions_model');
		
		$this->load->helper('url');
	}

	public function index($profileName)
	{
		if(!$this->users_model->exists($profileName))
		{
			$this->load->view("errors/html/error_404.php", array('heading' => "Errore", 'message' => "Utente inesistente."));
			return;
		}
		
		$userID = null;
		$token = null;
		if(isset($_COOKIE['username'])) $userID = $_COOKIE['username'];
		if(isset($_COOKIE['token'])) $token = $_COOKIE['token'];
		if(!$this->users_model->isLoggedIn($userID, $token))
		{
			echo json_encode(array("error" => true, "description" => "Non risulti essere iscritto a reSeed. Iscriviti!", "errorCode" => "ILLEGAL_ACCESS", "parameters" => array("username", "password")));
			return;
		}
		
// 		$can_see = $this->admins_model->is_admin($userID) || strcmp($userID, $profileName) == 0;
		
// 		if(!$can_see)
// 		{
// 			echo json_encode(array("error" => true, "description" => "Non sei autorizzato a visitare questo profilo.", "errorCode" => "ILLEGAL_ACCESS", "parameters" => array("username")));
// 			return;
// 		}
		
		$this->load->view('profile/profile');
	}
	
		public function update_block_positions()
        {
        	if(!$this->permissions->canSee())
        	{
        		echo json_encode(array("error" => true, "description" => "Non si dispone dei diritti necessari a salvare la posizione dei blocchi"));
        		return;
        	}
        	 
        	$userID = $this->input->post('username');
        	if($userID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Il nome utente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}
        	 
        	$panelID = $this->input->post('panelID');
        	if($courseID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare un ID pannello.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("panelID")));
        		return;
        	}
        	 
        	$panel_measures = $this->input->post('measures');
        	if($panel_measures == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Le informazioni sul singolo blocco sono obbligatorie.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("measures")));
        		return;
        	}
        	
        	$data = $this->profile_block_positions_model->get($userID, $panelID);
        	if($data == null) $this->profile_block_positions_model->add($userID, $panelID, $panel_measures);
        	else $this->profile_block_positions_model->update($userID, $panelID, $panel_measures);
        }
        
        public function load_block_positions()
        {
        	$userID = $this->input->post('username');
        	if($userID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Il nome utente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}
        	 
        	$panel_measures = $this->profile_block_positions_model->get($userID);
        	if(count($panel_measures) == 0)
        	{
        		echo json_encode(array("error" => true, "description" => "Nessuna posizione memorizzata per questo utente.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}
        	
//         	$info = array();
//         	foreach ($panel_measures as $panel_measure)
//         	{
//         		$info[$panel_measure['panelID']] = $panel_measure['panel_measure'];
//         	}
        	
        	echo json_encode(array("error" => false, "panelMeasures" => $panel_measures));
        }
        
        public function init_block_positions()
        {
        	$this->profile_block_positions_model->init();
        }
}

?>