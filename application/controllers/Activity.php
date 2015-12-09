<?php

class Activity extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('activity_block_positions_model');

                $this->load->library('permissions');
                
                $this->load->helper('url');
        }
        
        public function index($activityID)
        {
                $this->load->view('activities/activity');
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
        	 
        	$activityID = $this->input->post('activityID');
        	if($activityID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Il servizio è obbligatorio..", "errorCode" => "MANDATORY_FIELD", "parameters" => array("activityID")));
        		return;
        	}
        	 
        	$blockPositions = $this->input->post('blockPositions');
        	if($blockPositions == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Le posizioni dei blocchi sono obbligatorie.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("blockPositions")));
        		return;
        	}
        	
        	$data = $this->activity_block_positions_model->get($userID, $activityID);
        	if($data == null) $this->activity_block_positions_model->add($userID, $activityID, $blockPositions);
        	else $this->activity_block_positions_model->update($userID, $activityID, $blockPositions);
        }
        
        public function load_block_positions()
        {
//         	if(!$this->canSee())
//         	{
//         		echo json_encode(array());
//         		return;
//         	}
        	
        	$userID = $this->input->post('username');
        	if($userID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Il nome utente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}
        	 
        	$activityID = $this->input->post('activityID');
        	if($activityID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Il servizio è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("activityID")));
        		return;
        	}

        	$block_positions = $this->activity_block_positions_model->get($userID, $activityID);
        	if(count($block_positions) > 0) echo json_encode($block_positions['block_positions']);
        }
        
        public function init_block_positions()
        {
        	$this->activity_block_positions_model->init();
        }
}
?>