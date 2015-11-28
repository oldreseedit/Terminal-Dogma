<?php
class Profile_block_positions_model extends CI_Model
{
        const table_name = "profile_block_positions";
        
        public function __construct()
        {
			$this->load->database();
        }
        
		public function init()
        {
			$this->load->dbforge();
                
			$fields = array(
            	'username' => array(
                	'type' => 'VARCHAR',
                    'constraint' => 30
					),
                'block_positions' => array(
                	'type' => 'VARCHAR',
                	'constraint' => 256,
                	)
			);
                
			$this->dbforge->add_key('username', TRUE);
                
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table(self::table_name);
        }
        
        public function add($userID, $block_positions)
        {
			$data = array(
            	'username' => $userID,
                'block_positions' => $block_positions,
			);

			$this->db->insert(self::table_name, $data);
        }
        
        public function update($userID, $block_positions)
        {
        	if(count($this->get($userID) == 0)) $this->add($userID, $block_positions);
        	else $this->db
					->where('username', $userID)
	            	->update(self::table_name, array('block_positions' => $block_positions));
        }
        
        public function get($userID)
        {
			return $this->db
                ->where('username', $userID)
                ->get(self::table_name)->row_array();
        }
}
?>