<?php
class Courses_model extends CI_Model
{
        const table_name = "courses";
        
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
                		'subject' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 30
                		),
                        'description' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 4096,
                        		'null' => true
                        ),
                		'syllabus' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 4096,
                				'null' => true
                		),
                		'icon' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 2000,
                				'null' => true
                		),
                		'startingDate' => array(
                				'type' => 'DATE'
                		),
                		'endingDate' => array(
                				'type' => 'DATE'
                		),
                		'startingHour' => array(
                				'type' => 'DATETIME'
                		),
                		'endingHour' => array(
                				'type' => 'DATETIME'
                		),
                		'price' => array(
                				'type' => 'DECIMAL',
                				'constraint' => '7,2',
                				'unsigned' => true
                		),
                		'duration' => array(
                				'type' => 'INT',
                				'unsigned' => true
                		)
                );
                
                $this->dbforge->add_key('courseID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($courseID, $name, $description = null, $syllabus = null, $iconURI = null)
        {
                $data = array(
                   'courseID' => $courseID,
                   'subject' => $name,
                );
                
                if($description != null) $data['description'] = $description;
                if($syllabus != null) $data['syllabus'] = $syllabus;
                if($iconURI != null) $data['icon'] = $iconURI;
                
                $this->db->insert(self::table_name, $data);
                return $this->db->insert_id();
        }
        
        public function exists($courseID)
        {
        	return count($this->db->where('courseID', $courseID)->get(self::table_name)->row_array()) > 0;
        }
        
        public function delete($courseID)
        {
                $data = array('courseID' => $courseID);

                return $this->db->delete(self::table_name, $data);
        }
        
        public function update($courseID, $name = null, $description = null, $syllabus = null, $iconURI = null)
        {
                $data = array();
                
                if($name != null) $data['subject'] = $name;
                if($description != null) $data['description'] = $description;
                if($syllabus != null) $data['syllabus'] = $syllabus;
                if($iconURI != null) $data['icon'] = $iconURI;
                
                if(count($data) == 0) return false;
                
                $this->db->where('courseID', $courseID)->update(self::table_name, $data);
                return true;
        }
        
        public function get($courseID)
        {
                return $this->db->where('courseID', $courseID)->get(self::table_name)->row_array();
        }
        
        public function get_all()
        {
        	return $this->db->get(self::table_name)->result_array();
        }
        
        public function get_all_names()
        {
        	return $this->db->select('subject')->distinct()->get(self::table_name)->result_array();
        }
        
        public function get_all_iterations($subject)
        {
        	return $this->db->where('subject', $subject)->order_by('startingDate', 'desc')->get(self::table_name)->result_array();
        }
}
?>