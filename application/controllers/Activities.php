<?php

class Activities extends CI_Controller {

	public function __construct()
    {
            parent::__construct();
            $this->load->helper('url');
            
            $this->load->model('activities_model');
            $this->load->model('activity_block_positions_model');
    }
    
    public function init()
    {
    	$this->activities_model->init();
    	$this->activity_block_positions_model->init();
    }

	public function index()
	{
		$this->load->view('activities/activities');
	}
	
	public function exists()
	{
		$activityID = $this->input->post('activityID');
		if($activityID == false)
		{
			echo json_encode(array("error" => true, "description" => "Specificare un codice attività.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("activityID")));
			return;
		}

		return count($this->activities_model->get($activityID)) > 0;
	}
	
	public function get()
	{
		$activityID = $this->input->post('activityID');
		if($activityID == false)
		{
			echo json_encode(array("error" => true, "description" => "Specificare un codice attività.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("activityID")));
			return;
		}	
		echo json_encode($this->activities_model->get($activityID));
	}
	
	public function add()
	{
		$activityID = $this->input->post('activityID');
		if($activityID == false)
		{
			echo json_encode(array("error" => true, "description" => "Specificare un codice attività.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("activityID")));
			return;
		}
		
		$name = $this->input->post('name');
		if($name == false) $name = null;
		
		$description = $this->input->post('description');
		if($description == false) $description = null;
		
		$otj_description = $this->input->post('otj_description');
		if($otj_description == false) $otj_description = null;
		
		$who = $this->input->post('who');
		if($who == false) $who = null;
		
		$prices = $this->input->post('prices');
		if($prices == false) $prices = null;
		
		$icon = $this->input->post('icon');
		if($icon == false) $icon = null;
		
		$this->activities_model->add($name, $description, $otj, $who, $prices, $iconURI);
		
		echo json_encode(array("error" => false, "description" => "Attività aggiunta con successo."));
		return;
	}
	
	public function update()
	{
		$activityID = $this->input->post('activityID');
		if($activityID == false)
		{
			echo json_encode(array("error" => true, "description" => "Specificare un codice attività.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("activityID")));
			return;
		}
		
		$name = $this->input->post('name');
		if($name == false) $name = null;
	
		$description = $this->input->post('description');
		if($description == false) $description = null;
	
		$otj_description = $this->input->post('otj_description');
		if($otj_description == false) $otj_description = null;
	
		$who = $this->input->post('who');
		if($who == false) $who = null;
	
		$prices = $this->input->post('prices');
		if($prices == false) $prices = null;
	
		$icon = $this->input->post('icon');
		if($icon == false) $icon = null;
	
		$this->activities_model->update($activityID, $name, $description, $otj, $who, $prices, $iconURI);
	
		echo json_encode(array("error" => false, "description" => "Attività modificata con successo."));
		return;
	}
}
