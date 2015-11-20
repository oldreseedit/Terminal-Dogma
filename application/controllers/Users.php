<?php

// require_once(APPPATH . 'libraries\Achievement10.php');
// print(APPPATH . 'libraries\Achievement10.php');
// require_once(APPPATH.'libraries/Achievement10.php');

class Users extends CI_Controller {

        const COOKIE_DAYS = 90;
        
        public function __construct()
        {
                parent::__construct();
                
                $this->load->model('users_model');
                $this->load->model('userinfo_model');
                $this->load->model('notifications_model');
                
                $this->load->model('experience_events_model');
                $this->load->model('achievements_and_rewards_model');
                $this->load->model('user_achievements_rewards_model');
                
                $this->load->helper('url');
                $this->load->helper('email');
                
//                 $this->load->library('achievement10');
        }
        
        public function add()
        {
            $userID = $this->input->post('username');
            if($userID == false)
            {
                echo json_encode(array("error" => true, "description" => "Il nome utente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
                return;
            }
            
            if($this->users_model->exists($userID))
            {
                echo json_encode(array("error" => true, "description" => "Nome utente già esistente.", "errorCode" => "USERNAME_TAKEN", "parameters" => array("username")));
                return;
            }
            
            $password = $this->input->post('password');
            if($password == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare una password.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("password")));
                return;
            }
            
            if(strlen($password) <= 0)
            {
                echo json_encode(array("error" => true, "description" => "La password risulta vuota.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("password")));
                return;
            }
            
            if(strlen($password) < 8)
            {
                echo json_encode(array("error" => true, "description" => "La password dev'essere composta da almeno 8 caratteri.", "errorCode" => "SHORT_FIELD", "parameters" => array("password")));
                return;
            }

            $mail = $this->input->post('mail');
            if($mail == false)
            {
                echo json_encode(array("error" => true, "description" => "Indirizzo e-mail obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("mail")));
                return;
            }
            
            $name = $this->input->post('name');
            if($name == false)
            {
                echo json_encode(array("error" => true, "description" => "Il nome è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("name")));
                return;
            }
            
            $surname = $this->input->post('surname');
            if($surname == false)
            {
                echo json_encode(array("error" => true, "description" => "Il cognome è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("surname")));
                return;
            }
            
            $registration_timestamp = date("Y-m-d H:i:s");
            
            // TODO: transaction
            
            // Store the user's ID and password
            $this->users_model->add($userID, $password);
            
            // Store the user's additional information
            $this->userinfo_model->add($userID, $mail, $name, $surname, $registration_timestamp);
            
            $this->login();
        }
        
        public function add_private($userID, $password, $mail, $name, $surname)
        {
            $registration_timestamp = date("Y-m-d H:i:s");
         
            // TODO: transaction
            
            $this->users_model->add($userID, $password);
            if($this->addExtraInfo($userID, $mail, $name, $surname, $registration_timestamp) == -1)
                echo json_encode(array("error" => true, "description" => "Errore durante l'aggiunta dell'utente.", "errorCode" => "GENERIC_ERROR"));
        }
        
        private function addExtraInfo($userID, $mail, $name, $surname, $registration_timestamp)
        {
            // Check email
            if(!valid_email($mail)) return -1;
            
            $this->userinfo_model->add($userID, $mail, $name, $surname, $registration_timestamp);
        }
        
        public function match()
        {
            $userID = $this->input->post('username');
            if($userID == false) $userID = null;
            
            $password = $this->input->post('password');
            if($password == false) $password = null;
            
            echo json_encode($this->users_model->match($userID, $password));
        }
        
        public function match_private($userID, $password)
        {
            echo json_encode($this->users_model->match($userID, $password));
        }
        
        public function delete()
        {
            $userID = $this->input->post('username');
            if($userID == false) $userID = null;
            
            $this->users_model->delete($userID);
            $this->userinfo_model->delete($userID);
        }
        
        public function delete_private($userID)
        {
            $this->users_model->delete($userID);
            $this->userinfo_model->delete($userID);
        }
        
        public function exists()
        {
            $userID = $this->input->post('username');
            if($userID == false) $userID = null;
            
            echo json_encode($this->users_model->exists($userID));
        }
        
        public function exists_private($userID)
        {
            echo json_encode($this->users_model->exists($userID));
        }
        
        public function get()
        {
            $userID = $this->input->post('username');
            if($userID == false) $userID = null;
            
            echo json_encode($this->userinfo_model->get($userID));
        }
        
        public function get_all()
        {
            echo json_encode($this->userinfo_model->get_all());
        }
        
        public function login()
        {
            $userID = $this->input->post('username');
            if($userID == false)
            {
                echo json_encode(array("error" => true, "description" => "Lo username è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
                return;
            }
            
            $password = $this->input->post('password');
            if($password == false)
            {
                echo json_encode(array("error" => true, "description" => "La password è obbligatoria.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("password")));
                return;
            }
            
            if(!$this->users_model->match($userID, $password))
            {
                echo json_encode(array("error" => true, "description" => "Il nome utente o la password non sono corretti.", "errorCode" => "LOGIN_ERROR", "parameters" => array("username", "password")));
                return;
            }
            
            $token = password_hash($userID.$password, PASSWORD_BCRYPT);
            $this->users_model->addToken($userID, $token);
            
            echo json_encode(array("error" => false, "description" => "Il login è stato effettuato correttamente.", "username" => $userID, "token" => $token, "expire" => time()+86400*self::COOKIE_DAYS));
        }
        
        // public function isLoggedIn()
        // {
        //     $userID = $this->input->post('username');
        //     if($userID == false)
        //     {
        //         echo json_encode(array("error" => true, "description" => "Lo username è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        //         return;
        //     }
            
        //     $token = $this->input->post('token');
        //     if($token == false)
        //     {
        //         echo json_encode(array("error" => true, "description" => "Il token è obbligatoria.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("token")));
        //         return;
        //     }
            
        //     if(!$this->users_model->isLoggedIn($userID, $token))
        //     {
        //         echo json_encode(array("error" => true, "description" => "Il nome utente o il token non sono corretti.", "errorCode" => "LOGIN_ERROR", "parameters" => array("username", "token")));
        //         return;
        //     }
            
        //     echo json_encode(array("error" => false, "description" => "L'utente ha eseguito l'accesso correttamente."));
        // }
        
        public function logout()
        {
            if(!isset($_COOKIE["username"]))
            {
                echo json_encode(array("error" => true, "description" => "Lo username è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
                return;
            }
            
            if(!isset($_COOKIE["token"]))
            {
                echo json_encode(array("error" => true, "description" => "Il token è obbligatoria.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("token")));
                return;
            }
            
            if(!$this->users_model->match($_COOKIE["username"], $_COOKIE["token"]))
            {
                echo json_encode(array("error" => true, "description" => "Il nome utente o il token non sono corretti.", "errorCode" => "LOGOUT_ERROR", "parameters" => array("username", "token")));
                return;
            }
            
            echo json_encode(array("error" => false, "description" => "Il logout è stato effettuato correttamente."));
        }
        
		public function init_exp_events()
		{
			$this->experience_events_model->init();
		}
		
		public function delete_exp_events()
		{
			$this->experience_events_model->drop();
		}
		
        public function add_exp()
        {
            $userID = $this->input->post('username');
            if($userID == false)
            {
                echo json_encode(array("error" => true, "description" => "Lo username è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
                return;
            }
            
            $exp = $this->input->post('exp');
            if($exp == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare punti esperienza.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("exp")));
                return;
            }
            
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;
            
            $description = $this->input->post('description');
            if($description == false) $description = null;
			
			$publishingTimestamp = date("Y-m-d H:i:s");

            // Get the user's exp information            
            $exp_info = $this->userinfo_model->get_exp_info($userID);
            
            $level = $exp_info['level'];
            $currentExperience = $exp_info['currentExp'];
            $newExperience = $currentExperience + $exp;
            $newLevel = $this->calculateNewLevel($level, $newExperience);
            
            $notifications = array();
            
			$this->db->trans_start();
			
            // Update the information on the database
            $this->userinfo_model->update_exp_info($userID, $currentExperience, $newExperience, $newLevel);
            
            // Add the notification in the experience events table and notify this to the GUI
            array_push($notifications, array("error" => false, "description" => "Sono stati assegnati " . $exp . " punti esperienza.", "errorCode" => "EXPERIENCE_UPDATE_EVENT"));
            $this->experience_events_model->add($userID, "EXP_POINTS", $exp, $publishingTimestamp, $description, $courseID);
            $this->notifications_model->add("Ti sono stati assegnati " . $exp . " punti esperienza.", $publishingTimestamp, array($userID), true, $courseID);
            
            $achievements_and_rewards_db = $this->user_achievements_rewards_model->get_achievements_and_rewards($userID);
            $achievements_and_rewards = array();
            foreach ($achievements_and_rewards_db as $achievement_or_reward)
            	$achievements_and_rewards[] = $achievement_or_reward['AchievementOrRewardID'];

            if($newLevel != $level)
            {
            	$event = $newLevel > $level ? "LEVEL_UP" : "LEVEL_DOWN";
            	
                // Add the level-up notification in the experience events table and notify this to the GUI
                array_push($notifications, array("error" => false, "description" => "Level " . ($newLevel > $level ? "up" : "down") ."!", "errorCode" => "LEVEL_UPDATE_EVENT"));
                $this->experience_events_model->add($userID, $event, $newLevel, $publishingTimestamp, null, $courseID);
                $this->notifications_model->add("Hai fatto level-".($newLevel > $level ? "up" : "down")."! Nuovo livello raggiunto: " . $newLevel, $publishingTimestamp, array($userID), true, $courseID);
                
                // Assign new achievements and rewards
                if($newLevel > $level)
                {
                	// Assign the reward corresponding to this level (if any)
                	$all_achievements_and_rewards = $this->achievements_and_rewards_model->get();
                	foreach ($all_achievements_and_rewards as $achievement_or_reward)
                	{
                		if($achievement_or_reward['Level'] != null && $achievement_or_reward['Level'] <= $newLevel)
                		{
                			$achievement_or_rewardID = $achievement_or_reward['AchievementRewardID'];
                			
                			// If the user hasn't already obtained that achievement/reward
                			if(in_array($achievement_or_rewardID, $achievements_and_rewards)) continue;
                			
                			$type = $achievement_or_reward['Type'];
                			
                			array_push($notifications, array("error" => false, "description" => "Hai ottenuto " . $achievement_or_rewardID . ": " . $achievement_or_reward['Description'], "errorCode" => $type . "_EVENT"));
							$this->experience_events_model->add($userID, "REWARD", $achievement_or_rewardID, $publishingTimestamp, null, $courseID);
							$this->notifications_model->add("Hai ottenuto " . $achievement_or_rewardID . ": " . $achievement_or_reward['Description'], $publishingTimestamp, array($userID), true, $courseID);
							$this->user_achievements_rewards_model->add($userID, $achievement_or_rewardID);
                		}
                	}
                }
            }
            
			$this->db->trans_complete();
            
            echo json_encode($notifications);
            return;
        }
        
        public function calculateNewLevel($level, $newExperience)
        {
			// exp(n) = 875n + 125n^2
			// 750 + 250n (parziale, essendo al livello n-1)
			$a = 125;
			$b = 875;
			
            return floor((-$b + sqrt(pow($b, 2) + 4*$a*$newExperience))/(2*$a));
        }
}
?>
