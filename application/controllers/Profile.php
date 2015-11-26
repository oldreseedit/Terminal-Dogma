<?php

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('admins_model');
		
		$this->load->helper('url');
	}
        
	public function index($profileName)
	{
		$userID = $_COOKIE['username'];
		$token = $_COOKIE['token'];
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
}

?>