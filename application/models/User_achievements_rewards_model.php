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
                				'type' => 'DATETIME',
                				'constraint' => 6
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
        
		public function get_achievements_and_rewards_obtained($userID, $type = null)
        {
			$data = array('username' => $userID);
			if($type != null) $data['type'] = $type;
        	
        	return $this->db
        	->join(Achievements_and_rewards_model::table_name, Achievements_and_rewards_model::table_name . "." . "achievementRewardID" . "=" . self::table_name . "." . "achievementOrRewardID")
        	->where($data)
        	->order_by('publishingTimestamp', 'desc')
        	->get(self::table_name)
        	->result_array();
        }
        
        public function get_achievements_and_rewards($userID)
        {
        	$this->db
        	->where('username', $userID)
        	->from(self::table_name);
        	
        	$subquery = $this->db->_compile_select();
        	$this->db->_reset_select();
        	
        	return $this->db->select('type, achievementRewardID, description, level, username, publishingTimestamp, courseID')
        	->from(Achievements_and_rewards_model::table_name)
        	->join("($subquery) t2", Achievements_and_rewards_model::table_name . "." . "achievementRewardID" . "=" . "t2" . "." . "achievementOrRewardID", "left")
        	->order_by('order', 'asc')
        	->get()
        	->result_array();
        }
}
?>