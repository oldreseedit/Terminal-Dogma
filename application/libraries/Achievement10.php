<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once "Achievement.php";

class Achievement10 extends Achievement
{
// 	public function __construct()
// 	{
// 		parent::__construct();
	
// // 		$this->load->model('userinfo_model');
// 	}
	
	public function applies($userID)
	{
		echo "UserID: " . $userID;
	}
}
?>