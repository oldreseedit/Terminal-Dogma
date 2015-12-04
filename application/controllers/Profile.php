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
		$userID = null;
		$token = null;
		if(isset($_COOKIE['username'])) $userID = $_COOKIE['username'];
		if(isset($_COOKIE['token'])) $token = $_COOKIE['token'];
		if(!$this->users_model->isLoggedIn($userID, $token))
		{
			echo json_encode(array("error" => true, "description" => "Non risulti essere iscritto a reSeed. Iscriviti!", "errorCode" => "ILLEGAL_ACCESS", "parameters" => array("username", "password")));
			return;
		}
		
		$can_see = $this->admins_model->is_admin($userID) || strcmp($userID, $profileName) == 0;
		
		if(!$can_see)
		{
			echo json_encode(array("error" => true, "description" => "Non sei autorizzato a visitare questo profilo.", "errorCode" => "ILLEGAL_ACCESS", "parameters" => array("username")));
			return;
		}
		
		$this->load->view('profile/profile');
	}
	
	public function update_block_positions()
	{
		$userID = $this->input->post('username');
		if($userID == false)
		{
			echo json_encode(array("error" => true, "description" => "Il nome utente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
			return;
		}
			
		$blockPositions = $this->input->post('blockPositions');
		if($blockPositions == false)
		{
			echo json_encode(array("error" => true, "description" => "Le posizioni dei blocchi sono obbligatorie.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("blockPositions")));
			return;
		}
			
		$data = $this->profile_block_positions_model->get($userID);
		if($data == null) $this->profile_block_positions_model->add($userID, $blockPositions);
		else $this->profile_block_positions_model->update($userID, $blockPositions);
	}
	
	public function load_block_positions()
	{
		$userID = $this->input->post('username');
		if($userID == false)
		{
			echo json_encode(array("error" => true, "description" => "Il nome utente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
			return;
		}
	
		$block_positions = $this->profile_block_positions_model->get($userID);
		if(count($block_positions) > 0) echo json_encode($block_positions['block_positions']);
	}
	
	public function init_block_positions()
	{
		$this->profile_block_positions_model->init();
	}
}

?>