<?php
class Teachers extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url');
                
                $this->load->model('course_teachers_model');
        }
        
        public function init()
        {
        	$this->teachers_model->init();
        	$this->course_teachers_model->init();
        }
        
        public function get()
        {
            $courseID = $this->input->post('courseID');
            if($courseID == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare un corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
                return;
            }

            // Get the teacher(s) for this course
            $teachers = $this->course_teachers_model->get($courseID);
            
            echo json_encode($teachers[0]);
        }
}
?>