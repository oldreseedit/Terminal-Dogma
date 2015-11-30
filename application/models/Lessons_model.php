<?php
class Lessons_model extends CI_Model
{
        const table_name = "Lessons";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'lessonID' => array(
                                'type' => 'INT',
                                 'auto_increment' => TRUE
                        ),
                        'courseID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30
                        ),
                        'startingDate' => array(
                                'type' => 'DATETIME'
                        ),
                        'endingDate' => array(
                                'type' => 'DATETIME'
                        ),
                        'lessonNote' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 100,
                                'null' => TRUE,
                        ),
                );
                
                $this->dbforge->add_key('lessonID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($start_time, $end_time, $courseId = null, $note = null)
        {
                $data = array(
                   'startingDate' => $start_time,
                   'endingDate' => $end_time,
                );
                
                if($courseId != null) $data['courseID'] = $courseId;
                if($note != null) $data['lessonNote'] = $note;
                
                $this->db->insert(self::table_name, $data);
                return $this->db->insert_id();
        }
        
        public function update($lessonId, $start_time, $end_time, $courseId, $note)
        {       
                $data = array();
                
                if($lessonId != null) $data['lessonID'] = $lessonId;
                if($start_time != null) $data['startingDate'] = $start_time;
                if($end_time != null) $data['endingDate'] = $end_time;
                if($courseId != null) $data['courseID'] = $courseId;
                if($note != null) $data['lessonNote'] = $note;
                
                $this->db->where('lessonID', $lessonId);
                $this->db->update(self::table_name, $data);
        }
        
        public function get_last_lessonID()
        {
                $this->db->select('TOP 1 lessonID');
                $this->db->from(self::table_name);
                $this->db->order_by('lessonID', 'desc');
                
                $query = $this->db->get();
                return $query->result_array();
        }
        
        public function delete($lessonId)
        {
                $data = array('lessonID' => $lessonId);

                $this->db->delete(self::table_name, $data);
        }
        
        // public function get_running_courses()
        // {
        //         $this->db->distinct();
        //         $this->db->select('courseID');
        //         $query = $this->db->get(self::table_name);
        //         return $query->result_array();
        // }
        
        // public function get($start_time = null, $end_time = null, $courseId = null, $lessonId = null)
        // {
        //         // print "start time: " . $start_time;
        //         // print "end time: " . $end_time;
        //         // print "course ID: " . $courseId;
                
        //         if ($lessonId == null && $start_time == null && $end_time == null && $courseId == null)
        //         {
        //                 $query = $this->db->get(self::table_name);
        //                 return $query->result_array();
        //         }
        //         else
        //         {
        //                 $this->db->from(self::table_name);
                        
        //                 if($start_time == null && $end_time == null && $lessonId != null) $this->db->where('lessonID =', $lessonId);
        //                 else
        //                 {
        //                         if($start_time != null) $this->db->where('startingDate >=', $start_time);
        //                         if($end_time != null) $this->db->where('endingDate <=', $end_time);
        //                 }
                        
        //                 if($courseId != null) $this->db->where('courseID =', $courseId);
                        
        //                 $query = $this->db->get();
        //                 return $query->result_array();
        //         }
        // }
        
        public function get($start_time = null, $end_time = null, $courseId = null, $lessonId = null, $sorted = true)
        {
                $costraints = array();

                if($lessonId != null) $costraints['lessonID'] = $lessonId;
                if($start_time != null) $costraints['startingDate >='] = $start_time;
                if($end_time != null) $costraints['endingDate <='] = $end_time;
                if($courseId != null) $costraints['courseID'] = $courseId;
                
                // Aggiungere sorting facility
                if($sorted) $this->db->order_by("startingDate", "asc");
                
                $query = $this->db->get_where(self::table_name, $costraints);
                
                return $query->result_array();
        }
        
        public function get_courses()
        {
                return $this->db->select('courseID')->distinct()->get(self::table_name)->result_array();
        }
}
?>