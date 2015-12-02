<?php

class Achievements_and_rewards extends CI_Controller {

		const ACHIEVEMENT = "ACHIEVEMENT";
		const REWARD = "REWARD";
	
        public function __construct()
        {
                parent::__construct();
                $this->load->model('achievements_and_rewards_model');
                $this->load->model('user_achievements_rewards_model');
                $this->load->model('userinfo_model');
        }
        
        public function init()
        {
            $this->rewards_model->init();
            
            $this->load->model('user_achievements_rewards_model');
            $this->user_achievements_rewards_model->init();
        }
        
        public function add_reward()
        {
            $rewardID = $this->input->post('rewardID');
            if($rewardID == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare l'ID di una reward", "errorCode" => "MANDATORY_FIELD", "parameters" => array("rewardID")));
                return;
            }
            
            $description = $this->input->post('description');
            if($description == false)
            {
            	echo json_encode(array("error" => true, "description" => "Specificare una descrizione", "errorCode" => "MANDATORY_FIELD", "parameters" => array("description")));
            	return;
            }
            
            $level = $this->input->post('level');
            if($level == false)
            {
            	echo json_encode(array("error" => true, "description" => "Specificare il livello minimo della reward", "errorCode" => "MANDATORY_FIELD", "parameters" => array("level")));
            	return;
            }
            
            $order = $this->input->post('order');
            if($order == false) $order = $level;
            
            $category = $this->input->post('category');
            if($category == false) $category = null;
            
            $data = $this->input->post('data');
            if($data == false) $data = null;
            
            $this->achievements_and_rewards_model->add(self::REWARD, $rewardID, urldecode($description), $order, $level, $category, $data);
            
            echo json_encode(array("error" => false, "description" => "Reward memorizzata con successo."));
            return;
        }
        
        public function add_achievement()
        {
        	$achievementID = $this->input->post('achievementID');
			if($achievementID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare l'ID di un achievement", "errorCode" => "MANDATORY_FIELD", "parameters" => array("achievementID")));
        		return;
        	}
        	
        	$order = $this->input->post('order');
        	if($order == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare un ordine", "errorCode" => "MANDATORY_FIELD", "parameters" => array("description")));
        		return;
        	}
        	
        	$description = $this->input->post('description');
        	if($description == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare una descrizione", "errorCode" => "MANDATORY_FIELD", "parameters" => array("description")));
				return;
        	}

        	$this->achievements_and_rewards_model->add(self::ACHIEVEMENT, $achievementID, urldecode($description), $order, null, null);
            
        	echo json_encode(array("error" => false, "description" => "Achievement memorizzato con successo."));
        	return;
        }
        
        public function get()
        {
        	echo json_encode($this->achievements_and_rewards_model->get());
        }
        
        public function get_achievements_and_rewards()
        {
        	$userID = $this->input->post('username');
        	if($userID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Lo username è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}

        	echo json_encode($this->user_achievements_rewards_model->get_achievements_and_rewards($userID));
        }
        
        public function get_last_achievement()
        {
        	$userID = $this->input->post('username');
        	if($userID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Lo username è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}

        	$ar = $this->user_achievements_rewards_model->get_achievements_and_rewards_obtained($userID, "ACHIEVEMENT");
        	if(count($ar) > 0)
        	{
        		$last = $ar[0];
        		echo json_encode(array("error" => false, "lastAchievement" => array('achievementID' => $last['achievementOrRewardID'], 'description' => $last['description'], 'timestamp' => $last['publishingTimestamp'])));
        	}
        	else
        	{
        		echo json_encode(array("error" => false, "lastAchievement" => null));
        	}
        }
        
        public function get_next_reward()
        {
        	$userID = $this->input->post('username');
			if($userID == false)
			{
				echo json_encode(array("error" => true, "description" => "Lo username è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
				return;
			}
			
        	$exp_info = $this->userinfo_model->get_exp_info($userID);
        	$level = $exp_info['level'];
        	
        	$rewards = $this->achievements_and_rewards_model->get("REWARD", $level+1);
        	if(count($rewards) > 0)
        	{
        		echo json_encode(array("error" => false, "nextReward" => $rewards[0]['description']));
        	}
        	else
        	{
        		echo json_encode(array("error" => false, "nextReward" => null));
        	}
        }
}
?>