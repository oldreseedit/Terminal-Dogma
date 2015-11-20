<?php

class Achievements_and_rewards_model extends CI_Model
{
        const table_name = "achievements_and_rewards";
        
        public function __construct()
        {
			$this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'AchievementRewardID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 32
                        ),
                		'Type' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 15
                		),
                        'Description' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 256
                        ),
                        'Level' => array(
                                'type' => 'INT',
                        		'unsigned' => TRUE,
                        		'null' => TRUE,
                        )
                );
                
                $this->dbforge->add_key('AchievementRewardID', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($type, $achievementID, $description, $level = null)
        {
        	$data = array(
        			'Type' => $type,
        			'AchievementRewardID' => $achievementID,
        			'Description' => $description,
        	);
        	
        	if($level != null) $data['Level'] = $level;
        
        	$this->db->insert(self::table_name, $data);
        }
        
        public function get()
        {
        	return $this->db->get(self::table_name)->result_array();
        }
}
?>