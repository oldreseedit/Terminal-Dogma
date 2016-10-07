<?php

class Seedon extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('seedon_model');
	}
	
	public function init()
	{
		$this->seedon_model->init();
	}
	
	public function assign_random_seedon()
	{
		$userID = $this->input->post('username');
		if($userID == false)
		{
			echo json_encode(array("error" => true, "description" => "Specificare un nome utente.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
			return;
		}
		
		$description = $this->input->post('description');
		if($description == false) $description = null;
		
		$tag = $this->input->post('tag');
		if($tag == false) $tag = null;
		
		$startingDate = $this->input->post('startingDate');
		if($startingDate == false) $startingDate = null;
		
		$endingDate = $this->input->post('endingDate');
		if($endingDate == false) $endingDate = null;
		
		$randomSeedon = $this->randomString();
		
		$this->seedon_model->save($userID, $randomSeedon, $description, $startingDate, $endingDate, $tag);
		
		echo json_encode(array("error" => false, "description" => "Seedon generato correttamente. Codice seedon: " . $randomSeedon));
	}
	
	public function get()
	{
		$userID = $this->input->post('username');
		if($userID == false)
		{
			echo json_encode(array("error" => true, "description" => "Specificare un nome utente.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
			return;
		}
		
		echo json_encode($this->seedon_model->get($userID));
	}
	
	public function get_seedon_by_name()
	{
		$seedon = $this->input->post('seedon');
		
		if($seedon == false)
		{
			echo json_encode(array("error" => true, "description" => "Specificare un seedon.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("seedon")));
			return;
		}
		
		$found_seedon = $this->seedon_model->get_seedon_by_name($seedon);
		if(count($found_seedon) == 0)
		{
			echo json_encode(array("error" => true, "description" => "Specificare un seedon valido.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("seedon")));
			return;
		}
		else
		{
			echo json_encode(array("error" => false, "description" => "Seedon applicato correttamente.", "seedon" => $found_seedon));
			return;
		}
	}
	
	public function get_seedon_not_used()
	{
		$userID = $this->input->post('username');
		if($userID == false)
		{
			echo json_encode(array("error" => true, "description" => "Specificare un nome utente.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
			return;
		}
	
		echo json_encode($this->seedon_model->get_seedon_not_used($userID));
	}
	
	private function randomString($length = 32) {
		$str = "";
		$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}
}

?>