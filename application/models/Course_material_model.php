<?php
class Course_material_model extends CI_Model
{
        const table_name = "Course_material";
        
        public function __construct()
        {
                $this->load->database();
                $this->load->model('lessons_model');
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'materialID' => array(
                                'type' => 'INT',
                                 'auto_increment' => TRUE
                        ),
                        'courseID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30
                        ),
                        'lessonID' => array(
                                'type' => 'INT'
                        ),
                        'fileURI' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 2000
                        ),
                        'uploadTimestamp' => array(
                                'type' => 'DATETIME'
                        ),
                        'note' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 1024,
                                'null' => TRUE
                        ),
                );
                
                $this->dbforge->add_key('materialID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($lessonID, $courseID, $fileURL, $uploadDate, $note = null)
        {
                $data = array(
                   'lessonID' => $lessonID,
                   'courseID' => $courseID,
                   'fileURI' => $fileURL,
                   'uploadTimestamp' => $uploadDate
                );
                
                if($note != null) $data['note'] = $note;
                
                $this->db->insert(self::table_name, $data);
                return $this->db->insert_id();
        }
        
        public function delete($materialID)
        {
                $data = array('materialID' => $materialID);

                return $this->db->delete(self::table_name, $data);
        }
        
        public function update($materialID, $lessonID = null, $courseID = null, $fileURI = null, $uploadDate = null, $note = null)
        {
                $data = array();
                if($lessonID != null) $data['lessonID'] = $lessonID;
                if($courseID != null) $data['courseID'] = $courseID;
                if($fileURI != null) $data['fileURI'] = $fileURI;
                if($uploadDate != null) $data['uploadTimestamp'] = $uploadDate;
                if($note != null) $data['note'] = $note;
                if(count($data) == 0) return false;
                
                $this->db->where('materialID', $materialID)->update(self::table_name, $data);
                
                return true;
        }
        
        public function get($materialID)
        {
                return $this->db->where('materialID', $materialID)->get(self::table_name)->row_array();
        }
        
        public function get_course_material($courseID)
        {
                return $this->db->where('courseID', $courseID)->get(self::table_name)->result_array();
        }
}
?>