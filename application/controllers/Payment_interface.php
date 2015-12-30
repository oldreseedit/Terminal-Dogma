<?php
class Payment_interface extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                
                $this->load->model('payment_model');
                
                $this->load->helper('url');
                
                $this->load->library('time');
                
                $this->load->model('notifications_model');
                $this->load->model('experience_events_model');
                $this->load->model('achievements_and_rewards_model');
                $this->load->model('user_achievements_rewards_model');
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
            
            $courseIDs = $this->input->post('courseID');
            if($courseIDs == false)
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

            $this->db->trans_start();
            
            // How many courses so far has the user subscribed to?
            $subscribed_courses = count($this->payment_model->get_courses($userID));
            
            // Store the payment fact
            $this->payment_model->add($userID, $courseIDs, $paymentChoice, $rate, $paymentDate);
            
            // Get all the achievements
            $all_achievements_and_rewards = array();
            foreach ($this->achievements_and_rewards_model->get("ACHIEVEMENT") as $achievement)
            {
            	$all_achievements[$achievement['achievementRewardID']] = $achievement;
            }
            
            // Get current achievements
            $achievements_obtained_db = $this->user_achievements_rewards_model->get_achievements_and_rewards_obtained($userID, "ACHIEVEMENT");
            $obtained_achievements = array();
            foreach ($achievements_obtained_db as $achievement_obtained_db)
            {
            	$obtained_achievements[$achievement_obtained_db['achievementRewardID']] = $achievement_obtained_db;
            }
            
            $notifications = array();
            
			$new_subscribing_courses = 1;
			foreach($courseIDs as $courseID)
			{
				$course_count = $subscribed_courses + $new_subscribing_courses;
				$achievement_ID = "SUBSCRIBED_TO_" . $course_count . "_COURSE" . ($course_count == 1 ? "" : "S");
				
				// If such an achievement does not exist (yet)
				if(!array_key_exists($achievement_ID, $all_achievements)) continue;
				
				// Get the prototype of this achievement
				$achievement = $all_achievements[$achievement_ID];
				
				// Get the description
				$description = $achievement['description'];
				
				$publishingTimestamp = $this->time->get_timestamp();
				$notifications[] = array("error" => false, "description" => "Hai ottenuto " . $achievement_ID . ": " . $description, "errorCode" => "ACHIEVEMENT_EVENT");
				$this->experience_events_model->add($userID, "ACHIEVEMENT", $achievement_ID, $publishingTimestamp, null, $courseID);
				$this->notifications_model->add("Hai ottenuto " . $achievement_ID . ": " . $description, $publishingTimestamp, array($userID), true, $courseID);
				$this->user_achievements_rewards_model->add($userID, $achievement_ID, $publishingTimestamp, $courseID);
				
				$new_subscribing_courses++;
			}
			
			// Assign special achievement (2 at once, three at once, and so on)
			for($i=2; $i <= count($courseIDs); $i++)
			{
				$achievement_ID = $i . "_COURSES_AT_ONCE";
				
				// If such an achievement does not exist (yet)
				if(!array_key_exists($achievement_ID, $all_achievements)) continue;
				
				// Check if the user already has it
				if(array_key_exists($achievement_ID, $obtained_achievements)) continue;
				
				// Get the prototype of this achievement
				$achievement = $all_achievements[$achievement_ID];
				
				// Get the description
				$description = $achievement['description'];
				
				// Assign it
				$publishingTimestamp = $this->time->get_timestamp();
				$notifications[] = array("error" => false, "description" => "Hai ottenuto " . $achievement_ID . ": " . $description, "errorCode" => "ACHIEVEMENT_EVENT");
				$this->experience_events_model->add($userID, "ACHIEVEMENT", $achievement_ID, $publishingTimestamp, null, null);
				$this->notifications_model->add("Hai ottenuto " . $achievement_ID . ": " . $description, $publishingTimestamp, array($userID), true, null);
				$this->user_achievements_rewards_model->add($userID, $achievement_ID, $publishingTimestamp, null);
			}
			
            $this->db->trans_complete();
            
            echo json_encode($notifications);
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
            if($userID == false)
            {
            	echo json_encode(array("error" => true, "description" => "Il nome utente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
            	return;
            }
            
            $result = $this->payment_model->get_courses($userID);
            
            $courses = array();
            foreach($result as $course)
            {
                $courses[] = $course['courseID'];
            }
            echo json_encode($courses);
        }
        
        public function get_courses_with_info()
        {
        	$userID = $this->input->post('username');
        	if($userID == false) $userID = null;
//         	$userID = "Titto";
        
        	$result = $this->payment_model->get_courses_with_info($userID);
        
        	$courses = array();
        	foreach($result as $course)
        	{
        		// $courses[] = array('courseID' => $course['courseID'], 'courseName' => $course['name']);
        		$courses[] = $course;
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
                $courseID = $subscription['courseID'];
                
                if(!array_key_exists($courseID, $subscriptions))
                    $subscriptions[$courseID] = array();
                
                array_push($subscriptions[$courseID], $subscription['userID']);
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
                $courseID = $subscription['courseID'];
                
                if(!array_key_exists($courseID, $subscriptions))
                    $subscriptions[$courseID] = array();
                
                array_push($subscriptions[$courseID], array('Name' => $subscription['name'], 'Surname' => $subscription['surname'], 'username' => $subscription['userID']));
            }
            
            echo json_encode($subscriptions);
        }
}
?>