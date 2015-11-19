<?php
class Experience_events_model extends CI_Model
{
        const table_name = "Experience_events";
        
        public function __construct()
        {
                $this->load->database();
        }
		
		public function drop()
		{
			$this->load->dbforge();
			$this->dbforge->drop_table(self::table_name);
		}
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'expEventID' => array(
                                'type' => 'INT',
                                 'auto_increment' => TRUE
                        ),
                        'event_type' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 50
                        ),
                        'description' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 4096,
								'null' => TRUE,
                        ),
                        'publishingTimestamp' => array(
                                'type' => 'DATETIME'
                        ),
                        'username' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30
                        ),
                        'courseID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE,
                        ),
                );
                
                $this->dbforge->add_key('expEventID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($userID, $eventType, $publishingTimestamp, $description = null, $courseID = null)
        {
                $data = array(
                   'username' => $userID,
                   'event_type' => $eventType,
                   'description' => $description,
                   'publishingTimestamp' => $publishingTimestamp,
                );
                
                if($courseID != null) $data['courseID'] = $courseID;
                        
                $this->db->insert(self::table_name, $data);
        }
        
        public function delete($expEventID)
        {
                $data = array('expEventID' => $expEventID);

                return $this->db->delete(self::table_name, $data);
        }

        public function update($expEventID, $description = null, $courseID = null)
        {
                $data = array();
                if($description != null) $data['description'] = $description;
                if($courseID != null) $data['courseID'] = $courseID;
                if(count($data) == 0) return false;
                
                $this->db->where('expEventID', $expEventID)->update(self::table_name, $data);
                
                return true;
        }
        
        public function get($expEventID)
        {
                return $this->db->where('expEventID', $expEventID)->get(self::table_name)->row_array();
        }
        
        public function get_experience_events($userID, $courseID = null)
        {
                $data = array('username' => $userID);
                if($courseID != null) $data['courseID'] = $courseID;
                
                return $this->db
                ->where($data)
                ->order_by('publishingTimestamp', 'desc')
                ->get(self::table_name)
                ->result_array();
        }
}
?>