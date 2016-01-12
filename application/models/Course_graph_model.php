<?php
class Course_graph_model extends CI_Model
{
        const table_name = "course_graph";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'courseID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                        ),
                		'nextCourseID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                        ),
                );
                
                $this->dbforge->add_key('courseID', TRUE);
                $this->dbforge->add_key('nextCourseID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($courseID, $nextCourseID)
        {
                $data = array(
                   'courseID' => $courseID,
                   'nextCourseID' => $nextCourseID,
                );
                
                $this->db->insert(self::table_name, $data);
                return $this->db->insert_id();
        }
        
        public function delete($courseID, $nextCourseID)
        {
                $data = array('courseID' => $courseID, 'nextCourseID' => $nextCourseID);

                return $this->db->delete(self::table_name, $data);
        }
        
        public function get($courseID)
        {
                return $this->db->where('courseID', $courseID)->get(self::table_name)->result_array();
        }
}
?>