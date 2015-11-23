<?php
class Lessons extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('lessons_model');
                $this->load->model('payment_model');
                $this->load->model('register_model');
                
                $this->load->model('notifications_model');
                $this->load->model('experience_events_model');
                $this->load->model('achievements_and_rewards_model');
                $this->load->model('user_achievements_rewards_model');
                
                $this->load->library('experience');
                
                $this->load->helper('url');
        }
        
        public function index()
        {
            $data['title'] = 'Lezioni reSeed';
            $this->load->view('lessons/lessons', $data);
        }
        
        public function init()
        {
            $this->lessons_model->init();
        }
        
        public function add()
        {
            $startingDate = $this->input->post('startingDate');
            if($startingDate == false) $startingDate = null;
            
            $endingDate = $this->input->post('endingDate');
            if($endingDate == false) $endingDate = null;
            
            $courseId = $this->input->post('courseID');
            if($courseId == false) $courseId = null;
            
            $note = $this->input->post('note');
            if($note == false) $note = null;
            
            $lessonId = $this->add_private($startingDate, $endingDate, $courseId, $note);
            
            $subscriptions = $this->payment_model->get_subscribers($courseId);
            
            foreach($subscriptions as $subscriber)
            {
                $this->register_model->add($lessonId, $subscriber['UserID'], false, urldecode(null));
            }
        }
        
        /*
        Date format: YYYY-MM-DD HH:MI:SS
        */
        public function add_private($startingDate, $endingDate, $courseId, $note = null)
        {
            // Temporal check
            if($startingDate >= $endingDate) show_error('La data di inizio non può essere posteriore alla data di fine. Per favore, controlla le date di inizio e fine della tua lezione.');
            
            // Check that the course does exist
            // if(!in_array($courseId, $this->payment_model->get_courses())) {
            //     print_r($this->payment_model->get_courses());
            //     // show_error('Non esiste nessun corso con codice ' . $courseId . ". Per favore specifica un corso esistente.");
            //     return;
            // }
                
            return $this->lessons_model->add($startingDate, $endingDate, $courseId, $note);
        }
        
        public function update()
        {
            $lessonId = $this->input->post('lessonID');
            if($lessonId == false) $lessonId = null;
            
            $startingDate = $this->input->post('startingDate');
            if($startingDate == false) $startingDate = null;
            
            $endingDate = $this->input->post('endingDate');
            if($endingDate == false) $endingDate = null;
            
            $courseId = $this->input->post('courseID');
            if($courseId == false) $courseId = null;
            
            $note = $this->input->post('lessonNote');
            if($note == false) $note = null;
            
            $this->lessons_model->update($lessonId, $startingDate, $endingDate, $courseId, $lessonNote);
        }
        
        public function update_batch()
        {
            // lessonNote (solo nel caso in cui sia cambiato)
            // lessonID (fisso)
            // e un array chiamato studentsChanges in cui ogni cella contiene lo userID e uno o entrambi attendance e note
            // $this->lessons_model->update($data->lessonID, urldecode($startingDate), urldecode($endingDate), $courseId, urldecode($note));
            // $attendances = array();
            
            // print_r($this->input->post());
            
            $lessonId = $this->input->post('lessonID');
            if($lessonId == false) $lessonId = null;
            
            $startingDate = $this->input->post('startingDate');
            if($startingDate == false) $startingDate = null;
            
            $endingDate = $this->input->post('endingDate');
            if($endingDate == false) $endingDate = null;
            
            $courseId = $this->input->post('courseID');
            if($courseId == false) $courseId = $this->lessons_model->get(null, null, null, $lessonId, false)[0]['courseID'];
            
            $lessonNote = $this->input->post('lessonNote');
            if($lessonNote == false) $lessonNote = null;
            
            $this->db->trans_start();
            
            $notifications = array();
            
            // Update the single lesson
            $this->lessons_model->update($lessonId, $startingDate, $endingDate, $courseId, $lessonNote);
            
            $usersData = array();
            $allChanges = $this->input->post('studentsChanges');
            if($allChanges != false)
            {
                foreach ($allChanges as $studentChanges)
                {
                    $userData = array();
                    
                    $userData['lessonID'] = $lessonId;
                    $userData['attendanceID'] = $studentChanges['attendanceID'];
                    $userData['userID'] = $studentChanges['userID'];
                    
                    if(array_key_exists('attendance', $studentChanges)) $userData['attendance'] = $studentChanges['attendance'];
                    if(array_key_exists('note', $studentChanges)) $userData['note'] = $studentChanges['note'];
                    
                    $usersData[] = $userData;
                }
                
                // Update the users' attendances
                $this->register_model->update_batch($usersData);
            }
            
            foreach ($allChanges as $studentChanges)
            {
            	if(!array_key_exists('attendance', $studentChanges)) continue;
            	
            	$attendance = $studentChanges['attendance'];
            	$userID = $studentChanges['userID'];
            	
            	$attendance_notifications = $this->assign_attendance_exp($userID, $courseId, $attendance);
            	foreach ($attendance_notifications as $attendance_notification)
            		$notifications[] = $attendance_notification;
            }
            
            $this->db->trans_complete();
            
            echo json_encode($notifications);
        }
        
        private function assign_attendance_exp($userID, $courseID, $attendance)
        {
        	$notifications = array();
        	
        	// Update the exp to account for the attendance at this lesson
        	$attendanceExp = 400;
        	if($attendance == false) $attendanceExp *= -1;
        	$notifications[] = $this->experience->add_exp_to_user($userID, $attendanceExp, $courseID, null);
        	
        	// Get all the information of the lessons of this course
        	$lessons = $this->register_model->get_lessons($courseID, $userID);
        	
        	// Calculate the ratio of the lessons attended so far
        	$attendance_ratio = 0;
        	foreach ($lessons as $lesson)
        	{
        		if($lesson['attendance'])
        		{
        			$attendance_ratio += 1;
        		}
        	}
        	if(count($lessons) > 0) $attendance_ratio /= count($lessons);
        	
        	// Get all the achievements and reward obtained by the user
        	$all_achievements_and_rewards = array();
        	foreach ($this->achievements_and_rewards_model->get() as $achievement_or_reward)
        	{
        		$all_achievements_and_rewards[$achievement_or_reward['AchievementRewardID']] = $achievement_or_reward; 
        	}
        	
//         	print("ALL:");
//         	print_r($all_achievements_and_rewards);
        	
        	// Check if it is the case to assign achievements regarding the % of the total lessons
        	if($attendance_ratio >= 0.8)
        	{
        		$achievements_and_rewards_db = $this->user_achievements_rewards_model->get_achievements_and_rewards($userID);
        		$achievements_and_rewards = array();
        		foreach ($achievements_and_rewards_db as $achievement_or_reward)
        		{
        			$achievements_and_rewards[] = $achievement_or_reward['AchievementOrRewardID'];
        		}
        		
//         		print("USER:");
//         		print_r($achievements_and_rewards);
        		
//         		print_r(array_keys($achievements_and_rewards));
//         		print("EXISTS:");
// 				print(array_key_exists($achievement_or_rewardID, $achievements_and_rewards));
        		
        		$achievement_or_rewardID = 'ACHV_80_PERCENT';

        		// If the user has not taken this achievement already
        		if(!in_array($achievement_or_rewardID, $achievements_and_rewards))
        		{
        			print("ADDING AN ACHIEVEMENT TO USER " . $userID);       			
        			
        			$eighty_percent_achievement = $all_achievements_and_rewards[$achievement_or_rewardID];
        	
        			$publishingTimestamp = date("Y-m-d H:i:s");
        			$notifications[] = array("error" => false, "description" => "Hai ottenuto " . $achievement_or_rewardID . ": " . $eighty_percent_achievement['Description'], "errorCode" => "ACHIEVEMENT_EVENT");
        			$this->experience_events_model->add($userID, "ACHIEVEMENT", $achievement_or_rewardID, $publishingTimestamp, null, $courseID);
        			$this->notifications_model->add("Hai ottenuto " . $achievement_or_rewardID . ": " . $eighty_percent_achievement['Description'], $publishingTimestamp, array($userID), true, $courseID);
        			$this->user_achievements_rewards_model->add($userID, $achievement_or_rewardID);
        		}
        		 
        		if($attendance_ratio >= 1.0)
        		{
        			$achievement_or_rewardID = 'ACHV_100_PERCENT';
        	
        			// If the user has not taken this achievement already
        			if(!in_array($achievement_or_rewardID, $achievements_and_rewards))
        			{
        				$eighty_percent_achievement = $all_achievements_and_rewards[$achievement_or_rewardID];
        				 
        				$publishingTimestamp = date("Y-m-d H:i:s");
        				$notifications[] = array("error" => false, "description" => "Hai ottenuto " . $achievement_or_rewardID . ": " . $eighty_percent_achievement['Description'], "errorCode" => "ACHIEVEMENT_EVENT");
        				$this->experience_events_model->add($userID, "ACHIEVEMENT", $achievement_or_rewardID, $publishingTimestamp, null, $courseID);
        				$this->notifications_model->add("Hai ottenuto " . $achievement_or_rewardID . ": " . $eighty_percent_achievement['Description'], $publishingTimestamp, array($userID), true, $courseID);
        				$this->user_achievements_rewards_model->add($userID, $achievement_or_rewardID);
        			}
        		}
        	}
        	
        	return $notifications;
        }
        
        public function get()
        {
            $lessonId = $this->input->post('lessonID');
            if($lessonId == false) $lessonId = null;
            
            $start_time = $this->input->post('startingDate');
            if($start_time == false) $start_time = null;
            
            $end_time = $this->input->post('endingDate');
            if($end_time == false) $end_time = null;
            
            $courseId = $this->input->post('courseID');
            if($courseId == false) $courseId = null;
            
            $lessons = $this->lessons_model->get($start_time, $end_time, $courseId, $lessonId);
            $register = $this->register_model->get($lessonId);
            
            // Creating list of subscribers
            $subscription = $this->payment_model->get_subscribers_names();
            
            $subscribers = array();
            foreach($subscription as $member){
                
                if(!array_key_exists($member['CourseID'], $subscribers)) $subscribers[$member['CourseID']] = array();
                $subscribers[$member['CourseID']][$member['userID']] = array('name' => $member['name'], 'surname' => $member['surname']);
            }
            
            // print_r($subscribers);
            
            // Creating array of objects of lessons
            
            $db = array();
            
            foreach($lessons as $row){
                $db[$row['lessonID']] = $row;
                $db[$row['lessonID']]['lessonID'] = (int)$db[$row['lessonID']]['lessonID'];
                $db[$row['lessonID']]['originalLessonNote'] = $row['lessonNote'];
                $db[$row['lessonID']]['studentList'] = array();
            }
            
            // Populating studentLists
            
            foreach($register as $row){
                if(array_key_exists($row['lessonID'],$db)){
                    $newStudent = $row;
                    $newStudent['name'] = $subscribers[$db[$row['lessonID']]['courseID']][$row['userID']]['name'];
                    $newStudent['surname'] = $subscribers[$db[$row['lessonID']]['courseID']][$row['userID']]['surname'];
                    $newStudent['attendance'] = (int)$newStudent['attendance'];
                    $newStudent['attendanceID'] = (int)$newStudent['attendanceID'];
                    unset($newStudent['lessonID']);
                    $newStudent['originalNote'] = $newStudent['note'];
                    $newStudent['originalAttendance'] = $newStudent['attendance'];
                    
                    array_push($db[$row['lessonID']]['studentList'],$newStudent);
                }
            }
            
            echo json_encode($db);
        }
        
        public function get_courses()
        {
            $result = $this->lessons_model->get_courses();
            
            $courses = array();
            foreach($result as $course)
            {
                array_push($courses, $course['courseID']);
            }
            
            echo json_encode($courses);
            return;
        }
        
        public function delete()
        {
            $lessonId = $this->input->post('lessonID');
            if($lessonId == false) $lessonId = null;
            
            $this->lessons_model->delete($lessonId);
        }
        
        // public function get_lessons($courseId = null, $start_time = null, $end_time = null, $lessonId = null)
        // {
        //     echo json_encode($this->lessons_model->get($start_time, $end_time, $courseId, $lessonId));
        // }
        
        public function get_lessons_by_course()
        {
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;
            
            $start_time = $this->input->post('startingDate');
            if($start_time == false) $start_time = null;
            
            $end_time = $this->input->post('endingDate');
            if($end_time == false) $end_time = null;
            
            $result = $this->lessons_model->get($start_time, $end_time, $courseID);
            
            $map = array();
            foreach($result as $db_lesson)
            {
                $lesson = array();
                
                $lessonCourseID = $db_lesson['courseID'];
                
                if(!array_key_exists($lessonCourseID, $map))
                    $map[$lessonCourseID] = array();
                
                foreach($db_lesson as $key => $value)
                {
                    if(strcmp($key, 'courseID') == 0) continue;
                    $lesson[$key] = $value;
                }
                
                array_push($map[$lessonCourseID], $lesson);
            }
            echo json_encode($map);
        }
}
?>