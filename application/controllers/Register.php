<?php
class Register extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                
                $this->load->model('register_model');
                $this->load->model('lessons_model');
                
                $this->load->model('users_model');
                $this->load->model('admins_model');

                $this->load->helper('url');
        }

        public function index()
        {
        	$userID = $_COOKIE['username'];
        	$token = $_COOKIE['token'];
        	if(!$this->users_model->isLoggedIn($userID, $token))
        	{
        		echo json_encode(array("error" => true, "description" => "Non risulti essere iscritto a reSeed. Iscriviti!", "errorCode" => "ILLEGAL_ACCESS", "parameters" => array("username", "password")));
        		return;
        	}
        	 
        	$can_see = $this->admins_model->is_admin($userID);
        	 
        	if(!$can_see)
        	{
        		echo json_encode(array("error" => true, "description" => "Non sei autorizzato ad accedere al registro.", "errorCode" => "ILLEGAL_ACCESS", "parameters" => array("username")));
        		return;
        	}
        	
            $data['title'] = 'Registro reSeed';
            $this->load->view('register/register', $data);
        }
        
        /*
            Creates the Register table. If the table already exists, this call has no effect.
            The table is initialized with the following information:
            - userID: the ID of the user
            - date: the lesson date
            - present (optional, default: false): a boolean for keeping track the presence or absence of the student
            - note (optional, default: null): a note for tracking information about the student
        */
        public function init()
        {
            $this->register_model->init();
        }
        
        /*
            Adds a new entry in the register (userID, date, present (optional, default: false, note (optional, default:null).
        */
        public function add($lessonId, $userId, $attendance = false, $note = null)
        {
            if($attendance === "true") $attendance = true;
            else $attendance = false;
            
            $this->register_model->add($lessonId, $userId, $attendance, urldecode($note));
        }
        
        public function delete($attendanceID)
        {
            $this->register_model->delete($attendanceID);
        }
        
        public function delete_lesson($lessonID)
        {
            $this->register_model->delete($lessonID);
        }
        
        /*
            Retrieves entries of the register.
            The query can involve a user ID (optional, default: null (i.e., information about all the users is returned))
            and a date (optional, default: null (i.e., information about all the dates is returned).
            Examples:
            A call such as get() retrieves the whole register.
            A call such as get(userID) retrieves the information of a given user.
            A call such as get(userID, date) retrieves the information of a given user on a given date.
            To retrieve all the information on a given date, use get_date(date).
        */
        public function get()
        {
            $lessonId = $this->input->post('lessonID');
            if($lessonId == false) $lessonId = null;
            
            $userId = $this->input->post('userID');
            if($userId == false) $userId = null;
            
            $result = $this->register_model->get($lessonId, $userId);
            
            echo json_encode($result);
        }
        
        public function get_lessons()
        {
        	$courseID = $this->input->post('courseID');
        	if($courseID == false) $courseID = null;
        
        	$userId = $this->input->post('userID');
        	if($userId == false) $userId = null;
        
        	$result = $this->register_model->get_lessons($courseID, $userId);
        
        	echo json_encode($result);
        }
        
        public function add_user_to_course($userID, $courseId)
        {
            $lessons = $this->lessons_model->get(null, null, $courseId, null);
            foreach($lessons as $lessonId)
            {
                $this->register_model->add($lessonId['lessonID'], $userID, false, null);
            }
        }
}
?>