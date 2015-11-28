<?php

class Course extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('users_model');
                $this->load->model('admins_model');
                $this->load->model('payment_model');
                $this->load->model('course_block_positions_model');
                
                $this->load->helper('url');
        }
        
        public function index($courseID)
        {
                $userID = $_COOKIE['username'];
                $token = $_COOKIE['token'];
                if(!$this->users_model->isLoggedIn($userID, $token))
                {
                        echo json_encode(array("error" => true, "description" => "Non risulti essere iscritto a reSeed. Iscriviti!", "errorCode" => "ILLEGAL_ACCESS", "parameters" => array("username", "password")));
                        return;
                }
                
                $users = array();
                foreach($this->payment_model->get_subscribers_names($courseID) as $subscription)
                {
                        array_push($users, $subscription['userID']);
                }
                
                $can_see = $this->admins_model->is_admin($userID) || in_array($userID, $users);
                
                if(!$can_see && !in_array($userID, $users))
                {
                        echo json_encode(array("error" => true, "description" => "Non risulti essere iscritto a questo corso.", "errorCode" => "ILLEGAL_ACCESS", "parameters" => array("username")));
                        return;
                }
                else if(!$can_see && !$this->admins_model->is_admin($userID))
                {
                        echo json_encode(array("error" => true, "description" => "Non disponi dei diritti sufficienti per visualizzare le informazioni di questo corso.", "errorCode" => "ILLEGAL_ACCESS", "parameters" => array("username")));
                        return;
                }
        
                $this->load->view('courses/course');
        }
        
        public function save_block_positions()
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
        	
        	$blockPositions = $this->input->post('blockPositions');
        	if($blockPositions == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Le posizioni dei blocchi sono obbligatorie.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("blockPositions")));
        		return;
        	}
        	
        	$this->course_block_positions_model->update($userID, $courseID, $blockPositions);
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
        	
        	$block_positions = $this->course_block_positions_model->get($userID, $courseID);
        	if(count($block_positions) == 1) echo json_encode($block_positions[0]['block_positions']);
        }
}
?>