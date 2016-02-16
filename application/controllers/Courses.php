<?php
class Courses extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url');
                $this->load->model('courses_model');
                $this->load->model('course_graph_model');
                $this->load->model('payment_model');
        }
        
        public function init()
        {
        	$this->courses_model->init();
        	$this->course_graph_model->init();
        }
        
        public function exists()
        {
        	$courseID = $this->input->post('courseID');
        	if($courseID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare un corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
        		return;
        	}
        	
        	return count($this->courses_model->get($courseID)) > 0;
        }
        
        public function get()
        {
            $courseID = $this->input->post('courseID');
            if($courseID == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare un corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
                return;
            }
            
            $data = $this->courses_model->get($courseID);
            $data['next'] = $this->get_next($courseID);
            
            echo json_encode($data);
        }
        
        public function get_all()
        {
        	$data = $this->courses_model->get_all();
        	foreach($data as $course)
        	{
        		$course['next'] = $this->get_next($course['courseID']);
        	}
        	
        	// Filtering
        	// If the user is logged in
        	if(isset($_COOKIE["username"]))
        	{
        		$userID = $_COOKIE["username"];
        		
        		$courseIDs = $this->payment_model->get_courses_with_info($userID);
        		
        		foreach($data as $key => $course)
        		{
        			foreach($courseIDs as $courseID)
        			{
        				if($courseID['subject'] === $course['subject'] && $courseID['courseID'] !== $course['courseID'])
        				{
        					unset($data[$key]);
        					
//         					print("<br/>Ho trovato che " . $course['courseID'] . " è da buttare, perché l'utente " . $userID . " è già iscritto a un corso della stessa materia: " . $courseID['courseID'] . " (materia:".$courseID['subject'].") Dimensione corsi: " . count($data));
        				}
        			}
        		}
        		
        		$data = array_values($data);
        	}
        	else
        	{
        		// Take the most recent courses for each subject
        	}
        
        	echo json_encode($data);
        }
        
        public function get_all_courseIDs()
        {
        	$data = array();
        	foreach($this->courses_model->get_all() as $course)
        	{
        		$data[] = $course['courseID'];
        	}
        
        	echo json_encode($data);
        }
        
        public function add_next()
        {
        	$courseID = $this->input->post('courseID');
        	if($courseID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare un corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
        		return;
        	}
        	
        	$nextCourseID = $this->input->post('nextCourseID');
        	if($nextCourseID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare il prossimo corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("nextCourseID")));
        		return;
        	}
        
        	echo json_encode($this->course_graph_model->add($courseID, $nextCourseID));
        }
        
        public function get_next($courseID)
        {
        	$data = array();
        	
        	foreach($this->course_graph_model->get($courseID) as $next)
        	{
        		$data[] = $this->courses_model->get($next['nextCourseID']);
        	}
        	
        	return $data;
        }
}
?>