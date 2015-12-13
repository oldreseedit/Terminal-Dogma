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
        	
        	$panelID = $this->input->post('panelID');
        	if($courseID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare un ID pannello.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("panelID")));
        		return;
        	}
        	 
        	$panel_measures = $this->input->post('panelMeasures');
        	if($panel_measures == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Le informazioni sul singolo blocco sono obbligatorie.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("panelMeasures")));
        		return;
        	}
        	
        	$data = $this->course_block_positions_model->get($userID, $courseID, $panelID);
        	if($data == null) $this->course_block_positions_model->add($userID, $courseID, $panelID, $panel_measures);
        	else $this->course_block_positions_model->update($userID, $courseID, $panelID, $panel_measures);
        }
        
        public function load_block_positions()
        {
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

        	$block_infos = $this->course_block_positions_model->get($userID, $courseID);
        	if(count($block_info) == 0)
        	{
        		echo json_encode(array("error" => true, "description" => "Nessuna posizione memorizzata per questo utente.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}
        	
        	$info = array();
        	foreach ($block_infos as $block_info)
        	{
        		$info[$block_info['panelID']] = $block_info['panel_measure'];
        	}
        	
        	echo json_encode(array("error" => false, "panelMeasures" => $info));
        }
        
        public function init_block_positions()
        {
        	$this->course_block_positions_model->init();
        }
}
?>