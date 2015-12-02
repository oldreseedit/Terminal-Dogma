<?php
class Permissions
{
	public function __construct()
	{
		$this->CI = & get_instance ();
		
		$this->CI->load->model( 'payment_model' );
		$this->CI->load->model( 'users_model' );
		$this->CI->load->model( 'admins_model' );
	}
	
	public function canSee()
	{
		$userID = null;
		$token = null;
		if(isset($_COOKIE['username'])) $userID = $_COOKIE['username'];
		if(isset($_COOKIE['token'])) $token = $_COOKIE['token'];
		if (! $this->CI->users_model->isLoggedIn ( $userID, $token ))
		{
			// echo json_encode(array("error" => true, "description" => "Non risulti essere iscritto a reSeed. Iscriviti!", "errorCode" => "ILLEGAL_ACCESS", "parameters" => array("username", "password")));
			return false;
		}
		
		$courseID = $this->CI->input->post('courseID');
		$users = array ();
		if($courseID != false)
		{
			foreach ( $this->CI->payment_model->get_subscribers_names ( $courseID ) as $subscription )
			{
				$users[] = $subscription['userID'];
			}
		}
		
		$can_see =  false;
		if($this->CI->admins_model->is_admin($userID)) $can_see = true;
		if($courseID != false && in_array($userID, $users)) $can_see = true;
		
		if (!$can_see)
		{
			if (! in_array ( $userID, $users ))
			{
				// echo json_encode(array("error" => true, "description" => "Non risulti essere iscritto a questo corso.", "errorCode" => "ILLEGAL_ACCESS", "parameters" => array("username")));
				return false;
			}
			else if (! $this->CI->admins_model->is_admin ( $userID ))
			{
				// echo json_encode(array("error" => true, "description" => "Non disponi dei diritti sufficienti per visualizzare le informazioni di questo corso.", "errorCode" => "ILLEGAL_ACCESS", "parameters" => array("username")));
				return false;
			}
		}
		
		return true;
	}
}

?>