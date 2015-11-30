<?php

class User_achievements_rewards_model extends CI_Model
{
        const table_name = "user_achievements_rewards";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'achievementOrRewardID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 32
                        ),
                        'username' => array(
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
                
                $this->dbforge->add_key('achievementOrRewardID', TRUE);
                $this->dbforge->add_key('username', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($userID, $achievementOrRewardID, $timestamp, $courseID = null)
        {
        	$data = array(
        			'username' => $userID,
        			'achievementOrRewardID' => $achievementOrRewardID,
        			'publishingTimestamp' => $timestamp
        	);
        	if($courseID != null) $data['courseID'] = $courseID;
        	
        	$this->db->insert(self::table_name, $data);
        }
        
        public function delete($userID, $achievementOrRewardID)
        {
        	$this->db->delete(self::table_name, array('username' => $userID, 'achievementOrRewardID' => $achievementOrRewardID));
        }
        
		public function get_achievements_and_rewards_obtained($userID)
        {
        	return $this->db
        	->where('username', $userID)
        	->get(self::table_name)
        	->result_array();
        }
        
        public function get_achievements_and_rewards($userID)
        {
        	return $this->db
        	->select('type, achievementRewardID, description, level, username, publishingTimestamp, courseID')
        	->from(Achievements_and_rewards_model::table_name)
        	->join(self::table_name, Achievements_and_rewards_model::table_name . "." . "achievementRewardID" . "=" . self::table_name . "." . "achievementOrRewardID", "left")
        	->where('username', $userID)
        	->or_where('username', null)
        	->get()
        	->result_array();
        }
}
?>