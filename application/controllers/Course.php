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
        	$activityID = $this->input->post('activityID');
        	if($courseID == false && $activityID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare il codice di un corso o attività.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
        		return;
        	}
        	
        	$categoryID = $courseID;
        	if($categoryID == false) $categoryID = $activityID;
        	
        	$panelID = $this->input->post('panelID');
        	if($courseID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare un ID pannello.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("panelID")));
        		return;
        	}
        	 
        	$panel_measures = $this->input->post('measures');
        	if($panel_measures == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Le informazioni sul singolo blocco sono obbligatorie.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("measures")));
        		return;
        	}
        	
        	$data = $this->course_block_positions_model->get($userID, $categoryID, $panelID);
        	if($data == null) $this->course_block_positions_model->add($userID, $categoryID, $panelID, $panel_measures);
        	else $this->course_block_positions_model->update($userID, $categoryID, $panelID, $panel_measures);
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
        	$activityID = $this->input->post('activityID');
        	if($courseID == false && $activityID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare il codice di un corso o attività.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
        		return;
        	}
        	
        	$categoryID = $courseID;
        	if($categoryID == false) $categoryID = $activityID;

        	$block_infos = $this->course_block_positions_model->get($userID, $categoryID);
        	if(count($block_infos) == 0)
        	{
        		echo json_encode(array("error" => true, "description" => "Nessuna posizione memorizzata per questo utente.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}
        	
//         	$info = array();
//         	foreach ($block_infos as $block_info)
//         	{
//         		$info[$block_info['panelID']] = $block_info['panel_measure'];
//         	}
        	
        	echo json_encode(array("error" => false, "panelMeasures" => $block_infos));
        }
        
        public function init_block_positions()
        {
        	$this->course_block_positions_model->init();
        }
}
?>