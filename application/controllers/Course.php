<?php

class Course extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                
                $this->load->model('course_block_positions_model');
                $this->load->model('courses_model');
                
                $this->load->library('permissions');
                
                $this->load->helper('url');
        }
        
        public function index($courseID)
        {
        	if(!$this->courses_model->exists($courseID))
        	{
        		$this->load->view("errors/html/error_404.php", array('heading' => "Errore", 'message' => "Corso inesistente."));
        		return;
        	}
        	
			$this->load->view('courses/course');
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
        	 
        	$courseID = $this->input->post('courseID');
        	if($courseID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Il corso è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
        		return;
        	}
        	 
        	$blockPositions = $this->input->post('blockPositions');
        	if($blockPositions == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Le posizioni dei blocchi sono obbligatorie.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("blockPositions")));
        		return;
        	}
        	
        	$data = $this->course_block_positions_model->get($userID, $courseID);
        	if($data == null) $this->course_block_positions_model->add($userID, $courseID, $blockPositions);
        	else $this->course_block_positions_model->update($userID, $courseID, $blockPositions);
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
        	 
        	$courseID = $this->input->post('courseID');
        	if($courseID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Il corso è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
        		return;
        	}

        	$block_positions = $this->course_block_positions_model->get($userID, $courseID);
        	if(count($block_positions) == 0)
        	{
        		echo json_encode(array("error" => true, "description" => "Nessuna posizione memorizzata per questo utente.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}
        	
        	echo json_encode(array("error" => false, "blockPositions" => $block_positions['block_positions']));
        }
        
        public function init_block_positions()
        {
        	$this->course_block_positions_model->init();
        }
}
?>