<?php
class Payment_interface extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('payment_model');
                $this->load->helper('url');
        }
        
        public function init()
        {
            $this->payment_model->init();
        }
        
        // public function add_user($userID, $courseID, $paymentChoice, $rate)
        // {
        //     $paymentDate = date("Y-m-d H:i:s");

        //     // Store the user's ID and password
        //     $this->payment_model->add($userID, array($courseID), $paymentChoice, $rate, $paymentDate);
        // }
        
        public function add()
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
                echo json_encode(array("error" => true, "description" => "Specificare un corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
                return;
            }
            
            $paymentChoice = $this->input->post('paymentChoice');
            if($paymentChoice == false)
            {
                echo json_encode(array("error" => true, "description" => "Il tipo di pagamento è obbligatorio (contanti, virtuale, etc.).", "errorCode" => "MANDATORY_FIELD", "parameters" => array("paymentChoice")));
                return;
            }
            
            $rate = $this->input->post('rate');
            if($rate == false)
            {
                echo json_encode(array("error" => true, "description" => "La durata del pagamento (rata mensile, bimensile, one-shot) è obbligatoria.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("rate")));
                return;
            }
                        
            $paymentDate = date("Y-m-d H:i:s");
                                    
            // Store the user's ID and password
            $this->payment_model->add($userID, $courseID, $paymentChoice, $rate, $paymentDate);
        }
               
        public function get_payment()
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
                echo json_encode(array("error" => true, "description" => "Specificare un corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
                return;
            }
            
            $db_result = $this->payment_model->get_payment($userID, $courseID);
            $result = array();

            foreach($db_result as $payment)
                $result[$payment['courseID']] = $payment['paymentDate'];
            
            echo json_encode($result);
        }
        
        public function get_courses()
        {
            $userID = $this->input->post('username');
            if($userID == false) $userID = null;
            
            $result = $this->payment_model->get_courses($userID);
            
            $courses = array();
            foreach($result as $course)
            {
                $courses[] = $course['CourseID'];
            }
            echo json_encode($courses);
        }
        
        public function get_subscribers()
        {
            $requestedCourseID = $this->input->post('courseID');
            if($requestedCourseID == false) $requestedCourseID = null;
            
            $result = $this->payment_model->get_subscribers($requestedCourseID);
            
            $subscriptions = array();
            foreach($result as $subscription)
            {
                $courseID = $subscription['CourseID'];
                
                if(!array_key_exists($courseID, $subscriptions))
                    $subscriptions[$courseID] = array();
                
                array_push($subscriptions[$courseID], $subscription['UserID']);
            }
            
            echo json_encode($subscriptions);
        }
        
        public function get_subscribers_names()
        {
            $requestedCourseID = $this->input->post('courseID');
            if($requestedCourseID == false) $requestedCourseID = null;
            
            $result = $this->payment_model->get_subscribers_names($requestedCourseID);

            $subscriptions = array();
            foreach($result as $subscription)
            {
                $courseID = $subscription['CourseID'];
                
                if(!array_key_exists($courseID, $subscriptions))
                    $subscriptions[$courseID] = array();
                
                array_push($subscriptions[$courseID], array('Name' => $subscription['name'], 'Surname' => $subscription['surname'], 'username' => $subscription['userID']));
            }
            
            echo json_encode($subscriptions);
        }
}
?>