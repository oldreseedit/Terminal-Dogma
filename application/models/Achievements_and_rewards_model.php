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
                        'achievementRewardID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 32
                        ),
                		'type' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 15
                		),
                        'description' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 256
                        ),
                        'level' => array(
                                'type' => 'INT',
                        		'unsigned' => TRUE,
                        		'null' => TRUE,
                        ),
                		'order' => array(
                				'type' => 'INT',
                				'unsigned' => TRUE,
                				'null' => TRUE,
                		)
                );
                
                $this->dbforge->add_key('achievementRewardID', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($type, $achievementID, $description, $order = null, $level = null)
        {
        	$data = array(
        			'type' => $type,
        			'achievementRewardID' => $achievementID,
        			'description' => $description,
        	);
        	
        	if($order != null) $data['order'] = $order;
        	if($level != null) $data['level'] = $level;
        
        	$this->db->insert(self::table_name, $data);
        }
        
        public function get($type = null, $level = null)
        {
        	$constraints = array();
        	if($type != null) $constraints['type'] = $type;
        	if($level != null) $constraints['level'] = $level;
        	
        	if(count($constraints) == 0) return $this->db->order_by('order', 'asc')->get(self::table_name)->result_array();
        	else return $this->db->where($constraints)->order_by('order', 'asc')->get(self::table_name)->result_array();
        }
}
?>