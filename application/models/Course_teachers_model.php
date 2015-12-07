<?php
class Course_teachers_model extends CI_Model
{
        const table_name = "course_teachers";
        
        public function __construct()
        {
                $this->load->database();
                $this->load->model('teachers_model');
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                		'courseID' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 30,
                		),
                		'teacherID' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 30
                		)
                );
                
                $this->dbforge->add_key('courseID', TRUE);
                $this->dbforge->add_key('teacherID', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($courseID, $teacherID)
        {
                $data = array(
                   'courseID' => $courseID,
                   'teacherID' => $teacherID,
                );

                $this->db->insert(self::table_name, $data);
        }
        
        public function delete($courseID, $teacherID)
        {
        	$data = array(
        			'courseID' => $courseID,
        			'teacherID' => $teacherID,
        	);
        	
            $this->db->delete(self::table_name, $data);
        }
        
        public function get_teachers($courseID)
        {
                return $this->db->where('courseID', $courseID)->get(self::table_name)->result_array();
        }
        
		public function get_courses($teacherID)
        {
                return $this->db->where('teacherID', $teacherID)->get(self::table_name)->result_array();
        }
        
        public function get($courseID)
        {
        	return $this->db->where('courseID', $courseID)
        	->join(Teachers_model::table_name, Teachers_model::table_name . ".teacherID" . " = " . self::table_name . ".teacherID")
        	->get(self::table_name)->result_array();
        }
}
?>