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
			echo json_encode(array("error" => true, "description" => "Specificare un corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("activityID")));
			return;
		}

		return count($this->activities_model->get($activityID)) > 0;
	}
	
	public function get()
	{
		$activityID = $this->input->post('activityID');
		if($activityID == false)
		{
			echo json_encode(array("error" => true, "description" => "Specificare un corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("activityID")));
			return;
		}	
		echo json_encode($this->activities_model->get($activityID));
	}
}
