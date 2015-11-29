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
                		'publishingTimestamp' => array(
                				'type' => 'DATETIME'
                		),
                		'courseID' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 30,
                				'null' => TRUE,
                		),
                );
                
                $this->dbforge->add_key('AchievementOrRewardID', TRUE);
                $this->dbforge->add_key('Username', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($userID, $achievementOrRewardID, $timestamp, $courseID = null)
        {
        	$data = array(
        			'Username' => $userID,
        			'AchievementOrRewardID' => $achievementOrRewardID,
        			'publishingTimestamp' => $timestamp
        	);
        	if($courseID != null) $data['courseID'] = $courseID;
        	
        	$this->db->insert(self::table_name, $data);
        }
        
        public function delete($userID, $achievementOrRewardID)
        {
        	$this->db->delete(self::table_name, array('Username' => $userID, 'AchievementOrRewardID' => $achievementOrRewardID));
        }
        
		public function get_achievements_and_rewards_obtained($userID)
        {
        	return $this->db
        	->where('Username', $userID)
        	->get(self::table_name)
        	->result_array();
        }
        
        public function get_achievements_and_rewards($userID)
        {
        	return $this->db
        	->select('Type, AchievementRewardID, Description, Level, Username, publishingTimestamp, courseID')
        	->from(Achievements_and_rewards_model::table_name)
        	->join(self::table_name, Achievements_and_rewards_model::table_name . "." . "AchievementRewardID" . "=" . self::table_name . "." . "AchievementOrRewardID", "left")
        	->where('Username', $userID)
        	->or_where('Username', null)
        	->get()
        	->result_array();
        }
}
?>