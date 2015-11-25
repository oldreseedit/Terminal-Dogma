<?php

class Experience
{
	public function __construct()
	{
		$this->CI =& get_instance();
		
		$this->CI->load->model('userinfo_model');
		$this->CI->load->model('notifications_model');
	
		$this->CI->load->model('experience_events_model');
		$this->CI->load->model('achievements_and_rewards_model');
		$this->CI->load->model('user_achievements_rewards_model');
	}
	
	public function add_exp_to_user($userID, $exp, $courseID = null, $description = null)
	{
		$publishingTimestamp = date("Y-m-d H:i:s");
		 
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
		$notifications[] = array("error" => false, "description" => "Sono stati assegnati " . $exp . " punti esperienza a " . $userID . ".", "errorCode" => "EXPERIENCE_UPDATE_EVENT");
		$this->CI->experience_events_model->add($userID, "EXP_POINTS", $exp, $publishingTimestamp, $description, $courseID);
		$this->CI->notifications_model->add("Ti sono stati assegnati " . $exp . " punti esperienza.", $publishingTimestamp, array($userID), true, $courseID);
		
		// Get the achievements and rewards currently achieved by the user
		$achievements_and_rewards_db = $this->CI->user_achievements_rewards_model->get_achievements_and_rewards($userID);
		$achievements_and_rewards = array();
		foreach ($achievements_and_rewards_db as $achievement_or_reward)
		{
			$achievements_and_rewards[] = $achievement_or_reward['AchievementOrRewardID'];
		}
		
		if($newLevel != $level)
		{
			$event = $newLevel > $level ? "LEVEL_UP" : "LEVEL_DOWN";
			 
			// Add the level-up notification in the experience events table and notify this to the GUI
			$notifications[] = array("error" => false, "description" => $userID . " ha fatto level " . ($newLevel > $level ? "up" : "down") ."!", "errorCode" => "LEVEL_UPDATE_EVENT");
			$this->CI->experience_events_model->add($userID, $event, $newLevel, $publishingTimestamp, null, $courseID);
			$this->CI->notifications_model->add("Hai fatto level-".($newLevel > $level ? "up" : "down")."! Nuovo livello raggiunto: " . $newLevel, $publishingTimestamp, array($userID), true, $courseID);
			 
			// Assign new achievements and rewards
			if($newLevel > $level)
			{
				// Assign the reward corresponding to this level (if any)
				$all_achievements_and_rewards = $this->CI->achievements_and_rewards_model->get();
				foreach ($all_achievements_and_rewards as $achievement_or_reward)
				{
					if($achievement_or_reward['Level'] != null && $achievement_or_reward['Level'] <= $newLevel)
					{
						$achievement_or_rewardID = $achievement_or_reward['AchievementRewardID'];

						// If the user hasn't already obtained that achievement/reward
						if(in_array($achievement_or_rewardID, $achievements_and_rewards)) continue;
	
						$type = $achievement_or_reward['Type'];
	
						$notifications[] = array("error" => false, "description" => $userID . " ha ottenuto " . $achievement_or_rewardID . ": " . $achievement_or_reward['Description'], "errorCode" => $type . "_EVENT");
						$this->CI->experience_events_model->add($userID, "REWARD", $achievement_or_rewardID, $publishingTimestamp, null, $courseID);
						$this->CI->notifications_model->add("Hai ottenuto " . $achievement_or_rewardID . ": " . $achievement_or_reward['Description'], $publishingTimestamp, array($userID), true, $courseID);
						$this->CI->user_achievements_rewards_model->add($userID, $achievement_or_rewardID, $publishingTimestamp, $courseID);
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
		
		// exp(n) = 875n + 125n^2
		// 750 + 250n (parziale, essendo al livello n-1)
		$a = 125;
		$b = 875;
			
		return floor((-$b + sqrt(pow($b, 2) + 4*$a*$newExperience))/(2*$a));
	}
}

?>