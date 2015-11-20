<?php

class User_achievements_rewards_model extends CI_Model
{
        const table_name = "User_Achievements_Rewards";
        
        public function __construct()
        {
                $this->load->database();
                // $this->load->helper('url');
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'AchievementOrRewardID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 32
                        ),
                        'Username' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30
                        ),
                );
                
                $this->dbforge->add_key('AchievementOrRewardID', TRUE);
                $this->dbforge->add_key('Username', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($userID, $achievementOrRewardID)
        {
        	$this->db->insert(self::table_name, array('Username' => $userID, 'AchievementOrRewardID' => $achievementOrRewardID));
        }
        
		public function get_achievements_and_rewards($userID)
        {
        	return $this->db
        	->where('Username', $userID)
        	->get(self::table_name)
        	->result_array();
        }
}
?>