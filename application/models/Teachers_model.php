<?php
class Teachers_model extends CI_Model
{
        const table_name = "teachers";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                		'teacherID' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 30
                		),
                        'description' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 4096,
                        		'null' => true
                        ),
                		'picture' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 2000,
                				'null' => true
                		),
                );
                
                $this->dbforge->add_key('teacherID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($teacherID, $description = null, $picture = null)
        {
                $data = array(
                   'teacherID' => $teacherID,
                );
                
                if($description != null) $data['description'] = $description;
                if($picture != null) $data['picture'] = $picture;
                
                $this->db->insert(self::table_name, $data);
                return $this->db->insert_id();
        }
        
        public function delete($teacherID)
        {
                $data = array('teacherID' => $teacherID);

                return $this->db->delete(self::table_name, $data);
        }
        
        public function update($teacherID, $description = null, $picture = null)
        {
                $data = array();
                
                if($description != null) $data['description'] = $description;
                if($picture != null) $data['picture'] = $picture;
                
                if(count($data) == 0) return false;
                
                $this->db->where('teacherID', $teacherID)->update(self::table_name, $data);
                return true;
        }
        
        public function get($teacherID)
        {
                return $this->db->where('teacherID', $teacherID)->get(self::table_name)->row_array();
        }
}
?>