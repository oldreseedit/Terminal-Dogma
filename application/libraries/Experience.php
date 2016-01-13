<?php

class Experience
{
	const a = 125;
	const b = 875;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		
		$this->CI->load->model('userinfo_model');
		$this->CI->load->model('notifications_model');
	
		$this->CI->load->model('experience_events_model');
		$this->CI->load->model('achievements_and_rewards_model');
		$this->CI->load->model('user_achievements_rewards_model');
		$this->CI->load->model('notification_rights_model');
		
		$this->CI->load->library('time');
		$this->CI->load->library('mailer');
	}
	
	public function add_exp_to_user($userID, $exp, $courseID = null, $description = null)
	{
		$user_logged_in = $_COOKIE["username"];
		
		// Get the user's exp information
		$exp_info = $this->CI->userinfo_model->get_exp_info($userID);
		 
		$level = $exp_info['level'];
		$currentExperience = $exp_info['currentExp'];
		$newExperience = $currentExperience + $exp;
		if($newExperience < 0) $newExperience = 0;
		$newLevel = $this->calculateNewLevel($level, $newExperience);
		 
		$notifications = array();
		 
		$this->CI->db->trans_start();
	
		// Update the information on the database
		$this->CI->userinfo_model->update_exp_info($userID, $currentExperience, $newExperience, $newLevel);
		 
		// Add the notification in the experience events table and notify this to the GUI
		$publishingTimestamp = $this->CI->time->get_timestamp();
		if(strcmp($user_logged_in, $userID) === 0) $notifications[] = array("error" => false, "description" => "Ti sono stati assegnati " . $exp . " punti esperienza" . $description, "errorCode" => "EXPERIENCE_UPDATE_EVENT");
		else $notifications[] = array("error" => false, "description" => "Sono stati assegnati " . $exp . " punti esperienza a " . $userID . $description, "errorCode" => "EXPERIENCE_UPDATE_EVENT");
		$this->CI->experience_events_model->add($userID, "EXP_POINTS", $exp, $publishingTimestamp, $description, $courseID);
		$this->CI->notifications_model->add("Ti sono stati assegnati " . $exp . " punti esperienza" . $description, $publishingTimestamp, array($userID), true, $courseID);

		// Setup sending email permission
		$email = null;
		// Get the email of the target user
		$rights = $this->CI->notification_rights_model->get($userID);
		// If he agreed to receive emails, send him an email with the notification
		if($rights && $rights['exp']) $email = $this->CI->userinfo_model->get($userID)['email'];
		
// 		$notifications[] = array("error" => false, "description" => "Diritti utente: " . implode(",", $rights));
// 		$notifications[] = array("error" => false, "description" => "E-mail utente: " . $email);
		
		if($email)
		{
			$status = $this->CI->mailer->send_mail($email, "Novità sui tuoi punti esperienza a reSeed", "Hai ricevuto " . $exp . " punti esperienza" . $description);
// 			if(strcmp($status, "OK") == 0)
// 			{
// 				$notifications[] = array("error" => false, "description" => "MAIL INVIATA CORRETTAMENTE A " . $email);
// 			}
// 			else
// 			{
// 				$notifications[] = array("error" => true, "description" => "ERRORE DURANTE L'INVIO DELLA MAIL A " . $email . ". Errore: " . $status, "errorCode" => "MAIL_ERROR");
// 			}
		}
		
		// Get the achievements and rewards currently achieved by the user
		$achievements_and_rewards_db = $this->CI->user_achievements_rewards_model->get_achievements_and_rewards_obtained($userID);
		$achievements_and_rewards = array();
		foreach ($achievements_and_rewards_db as $achievement_or_reward)
		{
			$achievements_and_rewards[] = $achievement_or_reward['achievementOrRewardID'];
		}
		
		if($newLevel != $level)
		{
			$event = $newLevel > $level ? "LEVEL_UP" : "LEVEL_DOWN";
			
			// Add the level-up notification in the experience events table and notify this to the GUI
			$publishingTimestamp = $this->CI->time->get_timestamp();
			
			if(strcmp($user_logged_in, $userID) === 0) $notifications[] = array("error" => false, "description" => "Hai fatto level " . ($newLevel > $level ? "up" : "down") ."!", "errorCode" => "LEVEL_UPDATE_EVENT");
			else $notifications[] = array("error" => false, "description" => $userID . " ha fatto level " . ($newLevel > $level ? "up" : "down") ."!", "errorCode" => "LEVEL_UPDATE_EVENT");
			
			$this->CI->experience_events_model->add($userID, $event, $newLevel, $publishingTimestamp, null, $courseID);
			$this->CI->notifications_model->add("Hai fatto level-".($newLevel > $level ? "up" : "down")."! Nuovo livello raggiunto: " . $newLevel, $publishingTimestamp, array($userID), true, $courseID);
			if($email) $this->CI->mailer->send_mail($email, "Novità sui tuoi punti esperienza a reSeed", "Hai fatto level-".($newLevel > $level ? "up" : "down")."! Nuovo livello raggiunto: " . $newLevel);
			 
			// Assign new achievements and rewards
			if($newLevel > $level)
			{
				// Assign the reward corresponding to this level (if any)
				$all_achievements_and_rewards = $this->CI->achievements_and_rewards_model->get();
				foreach ($all_achievements_and_rewards as $achievement_or_reward)
				{
					if($achievement_or_reward['level'] != null && $achievement_or_reward['level'] <= $newLevel)
					{
						$achievement_or_rewardID = $achievement_or_reward['achievementRewardID'];

						// If the user hasn't already obtained that achievement/reward
						if(in_array($achievement_or_rewardID, $achievements_and_rewards)) continue;
	
						$type = $achievement_or_reward['type'];
	
						$publishingTimestamp = $this->CI->time->get_timestamp();
						
						if(strcmp($user_logged_in, $userID) === 0) $notifications[] = array("error" => false, "description" => "Hai ottenuto " . $achievement_or_rewardID . ": " . $achievement_or_reward['description'], "errorCode" => $type . "_EVENT");
						else $notifications[] = array("error" => false, "description" => $userID . " ha ottenuto " . $achievement_or_rewardID . ": " . $achievement_or_reward['description'], "errorCode" => $type . "_EVENT");
						
						$this->CI->experience_events_model->add($userID, "REWARD", $achievement_or_rewardID, $publishingTimestamp, null, $courseID);
						$this->CI->notifications_model->add("Hai ottenuto " . $achievement_or_rewardID . ": " . $achievement_or_reward['description'], $publishingTimestamp, array($userID), true, $courseID);
						$this->CI->user_achievements_rewards_model->add($userID, $achievement_or_rewardID, $publishingTimestamp, $courseID);
						if($email) $this->CI->mailer->send_mail($email, "Novità sui tuoi punti esperienza a reSeed", "Hai ottenuto " . $achievement_or_rewardID . ": " . $achievement_or_reward['description']);
					}
				}
			}
		}
		
		$this->CI->db->trans_complete();
		
		return $notifications;
	}
	
	public function calculateNewLevel($level, $newExperience)
	{
		if($newExperience < 0) return 0;
		
		// exp(n) = 125n^2 + 875n
		// 250n + 750 (parziale, essendo al livello n-1)

		return floor((-self::b + sqrt(pow(self::b, 2) + 4*self::a*$newExperience))/(2*self::a));
	}
	
	public function expForLevel($level)
	{
		// exp(n) = 125n^2 + 875n 
		return self::a * pow($level, 2) + self::b * $level;
	}
	
	public function getMissingExpForNextLevel($level, $currentExperience)
	{
		$expForNextLevel = $this->expForLevel($level+1);
		return $expForNextLevel - $currentExperience;
	}
}

?>