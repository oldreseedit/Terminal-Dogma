<?php
class Notification_rights_model extends CI_Model
{
        const table_name = "notifications_rights";
        
        public function __construct()
        {
                $this->load->database();
                $this->load->helper('url');
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'userID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30
                        ),
                        'exp' => array(
                                'type' => 'TINYINT',
                        ),
                		'info' => array(
                				'type' => 'TINYINT',
                		),
                		'news' => array(
                				'type' => 'TINYINT',
                		),
                		'events' => array(
                				'type' => 'TINYINT',
                		),
                );
                
                $this->dbforge->add_key('userID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function get($userID)
        {
        	return $this->db->where('userID', $userID)->get(self::table_name)->row_array();
        }
        
        public function set($userID, $data)
        {
        	$this->db->where('userID', $userID)->update(self::table_name, $data);
        }
}
?>