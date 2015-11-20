<?php

class Achievements_and_rewards extends CI_Controller {

		const ACHIEVEMENT = "ACHIEVEMENT";
		const REWARD = "REWARD";
	
        public function __construct()
        {
                parent::__construct();
                $this->load->model('achievements_and_rewards_model');
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
            
            $this->achievements_and_rewards_model->add(self::REWARD, $rewardID, urldecode($description), $level);
            
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
        	
        	$description = $this->input->post('description');
        	if($description == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare una descrizione", "errorCode" => "MANDATORY_FIELD", "parameters" => array("description")));
				return;
        	}
        	
        	$this->achievements_and_rewards_model->add(self::ACHIEVEMENT, $achievementID, urldecode($description), $level);
            
        	echo json_encode(array("error" => false, "description" => "Achievement memorizzato con successo."));
        	return;
        }
        
        public function get()
        {
        	echo json_encode($this->achievements_and_rewards_model->get());
        }
}
?>