<?php
class Course_block_positions_model extends CI_Model
{
        const table_name = "course_block_positions";
        
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
				'courseID' => array(
                	'type' => 'VARCHAR',
                    'constraint' => 30,
                    ),
                'block_positions' => array(
                	'type' => 'VARCHAR',
                	'constraint' => 1024,
                	)
			);
                
			$this->dbforge->add_key('username', TRUE);
			$this->dbforge->add_key('courseID', TRUE);
                
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table(self::table_name);
        }
        
        public function add($userID, $courseID, $block_positions)
        {
			$data = array(
            	'username' => $userID,
                'courseID' => $courseID,
                'block_positions' => $block_positions,
			);

			$this->db->insert(self::table_name, $data);
        }
        
        public function update($userID, $courseID, $block_positions)
        {
			$this->db
				->where('username', $userID)
	            ->where('courseID', $courseID)
	            ->update(self::table_name, array('block_positions' => $block_positions));
        }
        
        public function get($userID, $courseID)
        {
			return $this->db
                ->where('username', $userID)
                ->where('courseID', $courseID)
                ->get(self::table_name)->row_array();
        }
}
?>