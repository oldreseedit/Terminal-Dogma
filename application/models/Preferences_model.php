<?php
class Preferences_model extends CI_Model
{
        const table_name = "preferences";
        
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
                		'profileVisibility' => array(
                				'type' => 'TINYINT',
                		),
                );
                
                $this->dbforge->add_key('userID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($userID, $exp, $info, $news, $events, $profile_visibility)
        {
        	$data = array(
        			'userID' => $userID,
        			'exp' => $exp,
        			'info' => $info,
        			'news' => $news,
        			'events' => $events,
        			'profileVisibility' => $profile_visibility
        	);
        	
        	$this->db->insert(self::table_name, $data);
        }
        
        public function get($userID)
        {
        	return $this->db->where('userID', $userID)->get(self::table_name)->row_array();
        }
        
        public function get_all()
        {
        	return $this->db->get(self::table_name)->result_array();
        }
        
        public function update($userID, $data)
        {
        	$this->db->where('userID', $userID)->update(self::table_name, $data);
        }
}
?>