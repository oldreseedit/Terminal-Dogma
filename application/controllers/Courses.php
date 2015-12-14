<?php
class Courses extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url');
                $this->load->model('courses_model');
        }
        
        public function index()
        {
            $this->load->view('courses/courses');
        }
        
        public function init()
        {
        	$this->courses_model->init();
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
//             $courseID = "java";
            
            if($courseID == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare un corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
                return;
            }
            
            echo json_encode($this->courses_model->get($courseID));
        }
}
?>