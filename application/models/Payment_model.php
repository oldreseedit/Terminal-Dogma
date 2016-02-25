<?php
class Payment_model extends CI_Model
{
        const table_name = "payment";
        
        public function __construct()
        {
                $this->load->database();
                $this->load->model('userinfo_model');
                $this->load->model('courses_model');
                
                $this->load->model('notifications_model');
                $this->load->model('experience_events_model');
                $this->load->model('achievements_and_rewards_model');
                $this->load->model('user_achievements_rewards_model');
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'userID' => array('type' => 'VARCHAR', 'constraint' => 30),			
                        'courseID' => array('type' => 'VARCHAR', 'constraint' => 30),
                		'course' => array('type' => 'TINYINT'),
                		'simulation' => array('type' => 'TINYINT'),
                		'coursePaymentID' => array('type' => 'VARCHAR', 'constraint' => 2048),
                		'simulationPaymentID' => array('type' => 'VARCHAR', 'constraint' => 2048),
                );
                
                $this->dbforge->add_key('userID', TRUE);
                $this->dbforge->add_key('courseID', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
//         public function add($userID, $courseIDs, $paymentChoice, $rate, $paymentDate)
//         {
//                 $data = array();
                
//                 foreach($courseIDs as $course)
//                         array_push($data,
//                                 array(
//                                    'userID' => $userID,
//                                    'courseID' => $course,
//                                    'paymentChoice' => $paymentChoice,
//                                    'rate' => $rate,
//                                    'paymentDate' => $paymentDate
//                                 ));
                
//                 $this->db->insert_batch(self::table_name, $data);
//         }

		public function add($userID, $courseID)
        {
                $data = array(
							'userID' => $userID,
                            'courseID' => $courseID,
				);

                $this->db->insert(self::table_name, $data);
        }
        
        public function update_course_payment($userID, $courseID, $coursePaymentID)
        {
        	$data = array('coursePaymentID' => $coursePaymentID);
        
        	$this->db->where('userID', $userID);
        	$this->db->where('courseID', $courseID);
        
        	$this->db->update(self::table_name, $data);
        }
        
        public function update_simulation_payment($userID, $courseID, $simulationPaymentID)
        {
        	$data = array('simulationPaymentID' => $simulationPaymentID);
        	 
        	$this->db->where('userID', $userID);
        	$this->db->where('courseID', $courseID);
        	 
        	$this->db->update(self::table_name, $data);
        }
        
        public function update_simulation($userID, $courseID, $simulationPaymentID)
        {
        	$data = array('simulation' => true, 'simulationPaymentID' => $simulationPaymentID);
        	
        	$this->db->where('userID', $userID);
        	$this->db->where('courseID', $courseID);
        	
        	$this->db->update(self::table_name, $data);
        }
        
        public function update_course($userID, $courseIDs, $coursePaymentID)
        {
        	$this->db->trans_start();
        	
        	// How many courses so far has the user subscribed to?
        	$subscribed_courses = count($this->get_courses($userID));
        	
			foreach($courseIDs as $course)
			{
				$this->db->where(array('userID' => $userID, 'courseID' => $course));
				$this->db->update(self::table_name, array('course' => true, 'coursePaymentID' => $coursePaymentID));
			}
			
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
        	
//         	print_r($obtained_achievements);
        	
//         	$notifications = array();
        	
        	$new_subscribing_courses = 1;
        	foreach($courseIDs as $courseID)
        	{
        		$course_count = $subscribed_courses + $new_subscribing_courses;
        		$achievement_ID = "SUBSCRIBED_TO_" . $course_count . "_COURSE" . ($course_count == 1 ? "" : "S");
        	
        		// If such an achievement does not exist (yet)
        		if(!array_key_exists($achievement_ID, $all_achievements)) continue;
        	
        		// Check if the user already has it
        		if(array_key_exists($achievement_ID, $obtained_achievements)) continue;
        		
        		// Get the prototype of this achievement
        		$achievement = $all_achievements[$achievement_ID];
        	
        		// Get the description
        		$description = $achievement['description'];
        	
        		$publishingTimestamp = $this->time->get_timestamp();
//         		$notifications[] = array("error" => false, "description" => "Hai ottenuto " . $achievement_ID . ": " . $description, "errorCode" => "ACHIEVEMENT_EVENT");
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
//         		$notifications[] = array("error" => false, "description" => "Hai ottenuto " . $achievement_ID . ": " . $description, "errorCode" => "ACHIEVEMENT_EVENT");
        		$this->experience_events_model->add($userID, "ACHIEVEMENT", $achievement_ID, $publishingTimestamp, null, null);
        		$this->notifications_model->add("Hai ottenuto " . $achievement_ID . ": " . $description, $publishingTimestamp, array($userID), true, null);
        		$this->user_achievements_rewards_model->add($userID, $achievement_ID, $publishingTimestamp, null);
        	}
        		
        	$this->db->trans_complete();
        	
//         	return $notifications;
        }
        
        public function get_course_payment($paymentID)
        {
                return $this->db->
                		where('coursePaymentID', $paymentID)->
                		get(self::table_name)->
                		result_array();
        }
        
        public function get_simulation_payment($paymentID)
        {
        	return $this->db->
        			where('simulationPaymentID', $paymentID)->
        			get(self::table_name)->
        			result_array();
        }
        
        public function get_payment($userID, $courseID)
        {
        	return $this->db->
        			where(array('userID' => $userID, 'courseID' => $courseID))->
        			get(self::table_name)->
        			row_array();
        	
//                 $var = "";
//                 for($i=0; $i<count($courseID); $i++)
//                 {
//                         if($i > 0) $var .= ' OR ';
//                         $var .= 'courseID = "' . $courseID[$i] . '"';
//                 }
                
//                 return $this->db->where('userID = ' . '"' . $userID . '"' . ' AND (' . $var . ')')->
//                 		get(self::table_name)->
//                 		result_array();
        }
        
        public function get_courses($userID = null)
        {
                $courses = array();
                
                $this->db->distinct();
                // $query = $this->db->select('courseID');
                $query = $this->db->from(self::table_name);
                
                if($userID != null) $this->db->where(array('userID' => $userID));
                
                return $this->db->get()->result_array();
        }
        
        public function get_courses_with_info($userID = null)
        {
        	$courses = array();
        
        	$this->db->distinct();
        	$query = $this->db->select(self::table_name . '.courseID, name, subject, icon, startingDate, price, duration');
        	$query = $this->db->from(self::table_name);
        
        	if($userID != null) $this->db->where(array('userID' => $userID, 'course' => true));
        
        	return $this->db->
        	join(Courses_model::table_name, Courses_model::table_name . "." . "courseID" . " = " . self::table_name . "." . "courseID")->
        	get()->result_array();
        }
        
        public function get_subscribers($courseID = null)
        {
                $courses = array();
                
                $this->db->distinct();
                $query = $this->db->select('courseID, userID');
                $query = $this->db->from(self::table_name);
                
                if($courseID != null) $this->db->where(array('userID' => $userID, 'course' => true));
                
                return $this->db->get()->result_array();
        }
        
        public function get_subscribers_names($courseID = null)
        {
                $courses = array();
                
                $user_info_table = Userinfo_model::table_name;
                
                $this->db->distinct();
                $query = $this->db->select('courseID, '.$user_info_table.'.userID, '.$user_info_table.'.name, '.$user_info_table.'.surname');
                $query = $this->db->from(self::table_name);
                $this->db->join($user_info_table, $user_info_table . '.userID = ' . self::table_name . '.userID');
                
                if($courseID != null) $this->db->where(array('course' => true));
                
                return $this->db->get()->result_array();
        }
}
?>