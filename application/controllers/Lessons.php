<?php
class Lessons extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('lessons_model');
                $this->load->model('payment_model');
                $this->load->model('register_model');
                
                $this->load->model('userinfo_model');
                
                $this->load->model('notifications_model');
                $this->load->model('preferences_model');
                $this->load->model('experience_events_model');
                $this->load->model('achievements_and_rewards_model');
                $this->load->model('user_achievements_rewards_model');
                
                $this->load->library('experience');
                $this->load->library('time');
                $this->load->library('mailer');
                
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
            
            $this->db->trans_start();
            
            $lessonId = $this->add_private($startingDate, $endingDate, $courseId, $note);
            
            $subscriptions = $this->payment_model->get_subscribers($courseId);
            
            foreach($subscriptions as $subscriber)
            {
                $this->register_model->add($lessonId, $subscriber['userID'], false, urldecode(null));
            }
            
            $this->db->trans_complete();
        }
        
        /*
        Date format: YYYY-MM-DD HH:MI:SS
        */
        private function add_private($startingDate, $endingDate, $courseId, $note = null)
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
            
            if($startingDate || $endingDate)
            {
            	// Setup sending email permission
            	$email = null;
            	// Get the email of the target user
            	$rights = $this->preferences_model->get($userID);
            	// If he agreed to receive emails, send him an email with the notification
            	if($rights && $rights['info']) $email = $this->userinfo_model->get($userID)['email'];
            	if($email) $this->mailer->send_mail($email, "Novità sui corsi che frequenti a reSeed", "Una lezione di " . $courseId . " ha subìto cambiamenti d'orario. Nuovo orario: " . $startingDate . " - " . $endingDate);
            }
        }
        
        public function update_batch()
        {
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
            
            if($startingDate || $endingDate)
            {
            	// Setup sending email permission
            	$email = null;
            	// Get the email of the target user
            	$rights = $this->preferences_model->get($userID);
            	// If he agreed to receive emails, send him an email with the notification
            	if($rights && $rights['info']) $email = $this->userinfo_model->get($userID)['email'];
            	if($email) $this->mailer->send_mail($email, "Novità sui corsi che frequenti a reSeed", "Una lezione di " . $courseId . " ha subìto cambiamenti d'orario. Nuovo orario: " . $startingDate . " - " . $endingDate);
            }
            
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
        	// Setup sending email permission
        	$email = null;
        	// Get the email of the target user
        	$rights = $this->preferences_model->get($userID);
        	// If he agreed to receive emails, send him an email with the notification
        	if($rights && $rights['exp']) $email = $this->userinfo_model->get($userID)['email'];
        	
        	$notifications = array();
        	
        	// Update the exp to account for the attendance at this lesson
        	$attendanceExp = 400;
        	if($attendance == false) $attendanceExp *= -1;
        	foreach($this->experience->add_exp_to_user($userID, $attendanceExp, $courseID, null) as $notification)
        		$notifications[] = $notification;
        	
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
        	
        	// Get all the achievements and rewards
        	$all_achievements_and_rewards = array();
        	foreach ($this->achievements_and_rewards_model->get() as $achievement_or_reward)
        	{
        		$all_achievements_and_rewards[$achievement_or_reward['achievementRewardID']] = $achievement_or_reward; 
        	}

        	// Check if it is the case to assign achievements regarding the % of the total lessons
        	$achievements_and_rewards_db = $this->user_achievements_rewards_model->get_achievements_and_rewards($userID);
        	$obtained_rewards_and_achievements = array();
        	foreach ($achievements_and_rewards_db as $achievement_or_reward)
        	{
        		$obtained_rewards_and_achievements[$achievement_or_reward['achievementOrRewardID']] = $achievement_or_reward;
        	}
        	
        	$arID = 'ACHV_80_PERCENT';
        	$has_it = array_key_exists($arID, $obtained_rewards_and_achievements);
        	if($attendance_ratio >= 0.8)
        	{
        		// If the user has not taken this achievement already
        		if(!$has_it)
        		{
        			$eighty_percent_achievement_prototype = $all_achievements_and_rewards[$arID];
        	
        			$publishingTimestamp = $this->time->get_timestamp();
        			$notifications[] = array("error" => false, "description" => "Hai ottenuto " . $arID . ": " . $eighty_percent_achievement_prototype['description'], "errorCode" => "ACHIEVEMENT_EVENT");
        			$this->experience_events_model->add($userID, "ACHIEVEMENT", $arID, $publishingTimestamp, null, $courseID);
        			$this->notifications_model->add("Hai ottenuto " . $arID . ": " . $eighty_percent_achievement_prototype['description'], $publishingTimestamp, array($userID), true, $courseID);
        			$this->user_achievements_rewards_model->add($userID, $arID, $publishingTimestamp, $courseID);
        			if($email) $this->mailer->send_mail($email, "Novità sui tuoi reward o achievement a reSeed", "Hai ottenuto " . $arID . ": " . $eighty_percent_achievement_prototype['description']);
        		}
        	}
        	else
        	{
        		// Remove it, if present
        		if($has_it)
        		{
        			$eighty_percent_achievement = $obtained_rewards_and_achievements[$arID];
        	
        			if(strcmp($eighty_percent_achievement['courseID'], $courseID) == 0)
        			{
        				$publishingTimestamp = $this->time->get_timestamp();
        				$notifications[] = array("error" => false, "description" => "E' stato tolto " . $arID, "errorCode" => "ACHIEVEMENT_EVENT");
        				$this->experience_events_model->add($userID, "ACHIEVEMENT_LOST", $arID, $publishingTimestamp, null, $courseID);
        				$this->notifications_model->add("Hai perso " . $arID, $publishingTimestamp, array($userID), true, $courseID);
        				$this->user_achievements_rewards_model->delete($userID, $arID);
        				if($email) $this->mailer->send_mail($email, "Novità sui tuoi reward o achievement a reSeed", "Hai perso " . $arID);
        			}
        		}
        	}
        	
        	$arID = 'ACHV_100_PERCENT';
        	$has_it = array_key_exists($arID, $obtained_rewards_and_achievements);
        	if($attendance_ratio >= 1.0)
        	{
        		// If the user has not taken this achievement already
        		if(!$has_it)
        		{
        			$one_hundred_percent_achievement_prototype = $all_achievements_and_rewards[$arID];
        	
        			$publishingTimestamp = $this->time->get_timestamp();
        			$notifications[] = array("error" => false, "description" => "Hai ottenuto " . $arID . ": " . $one_hundred_percent_achievement_prototype['description'], "errorCode" => "ACHIEVEMENT_EVENT");
        			$this->experience_events_model->add($userID, "ACHIEVEMENT", $arID, $publishingTimestamp, null, $courseID);
        			$this->notifications_model->add("Hai ottenuto " . $arID . ": " . $one_hundred_percent_achievement_prototype['description'], $publishingTimestamp, array($userID), true, $courseID);
        			$this->user_achievements_rewards_model->add($userID, $arID, $publishingTimestamp, $courseID);
        			if($email) $this->mailer->send_mail($email, "Novità sui tuoi reward o achievement a reSeed", "Hai ottenuto " . $arID . ": " . $one_hundred_percent_achievement_prototype['description']);
        		}
        	}
        	else
        	{
        		// Remove it, if present
        		if($has_it)
        		{
        			$one_hundred_percent_achievement = $obtained_rewards_and_achievements[$arID];
        	
        			if(strcmp($one_hundred_percent_achievement['courseID'], $courseID) == 0)
        			{
        				$publishingTimestamp = $this->time->get_timestamp();
        				$notifications[] = array("error" => false, "description" => "E' stato tolto " . $arID, "errorCode" => "ACHIEVEMENT_EVENT");
        				$this->experience_events_model->add($userID, "ACHIEVEMENT_LOST", $arID, $publishingTimestamp, null, $courseID);
        				$this->notifications_model->add("Hai perso " . $arID, $publishingTimestamp, array($userID), true, $courseID);
        				$this->user_achievements_rewards_model->delete($userID, $arID);
        				if($email) $this->mailer->send_mail($email, "Novità sui tuoi reward o achievement a reSeed", "Hai perso " . $arID);
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
//         	$start_time = null; $end_time = null; $lessonId = null;
// 			$courseId = "mobileApp";
            
            // Creating list of subscribers
            $subscription = $this->payment_model->get_subscribers_names();
//             print("PAYMENT:"); print_r($subscription);
            
            $subscribers = array();
            foreach($subscription as $member){
                
                if(!array_key_exists($member['courseID'], $subscribers)) $subscribers[$member['courseID']] = array();
                $course = $member['courseID'];
                $userID = $member['userID'];
                $subscribers[$course][$userID] = array('name' => $member['name'], 'surname' => $member['surname']);
            }
//             print("SUBSCRIBERS"); print_r($subscribers);
            
            // Creating array of objects of lessons
            $db = array();
            
            $lessons = $this->lessons_model->get($start_time, $end_time, $courseId, $lessonId);
            foreach($lessons as $row){
                $db[$row['lessonID']] = $row;
                $db[$row['lessonID']]['lessonID'] = (int)$db[$row['lessonID']]['lessonID'];
                $db[$row['lessonID']]['originalLessonNote'] = $row['lessonNote'];
                $db[$row['lessonID']]['studentList'] = array();
            }
//             print("DB1"); print_r($db);
            
            // Populating studentLists
            $register = $this->register_model->get($lessonId);
//             print("REGISTER"); print_r($register);
            foreach($register as $row){
            	$lessonID = $row['lessonID'];
            	
                if(!array_key_exists($lessonID,$db)) continue;
                	
                	$course = $db[$lessonID]['courseID'];
                	
                	// Check that this user has been inserted in the lessons
                	if(!array_key_exists($course, $subscribers)) continue;

                    $newStudent = $row;
                    
                    $userID = $row['userID'];
                    $newStudent['name'] = $subscribers[$course][$userID]['name'];
                    $newStudent['surname'] = $subscribers[$course][$userID]['surname'];
                    $newStudent['attendance'] = (int)$newStudent['attendance'];
                    $newStudent['attendanceID'] = (int)$newStudent['attendanceID'];
                    unset($newStudent['lessonID']);
                    $newStudent['originalNote'] = $newStudent['note'];
                    $newStudent['originalAttendance'] = $newStudent['attendance'];
                    
                    $db[$lessonID]['studentList'][] = $newStudent;
            }
//             print("DB2"); print_r($db);
            
            echo json_encode($db);
        }
        
        public function get_courses()
        {
            $result = $this->lessons_model->get_courses();
            
            $courses = array();
            foreach($result as $course)
            {
                $courses[] = $course['courseID'];
            }
            
            echo json_encode($courses);
            return;
        }
        
        public function delete()
        {
            $lessonId = $this->input->post('lessonID');
            if($lessonId == false) $lessonId = null;
            
            $this->db->trans_start();
            
            $this->lessons_model->delete($lessonId);
            $this->register_model->delete_lesson($lessonId);
            
            $this->db->trans_complete();
        }
        
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