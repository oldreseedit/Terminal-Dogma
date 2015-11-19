<?php
class Register_model extends CI_Model
{
        const table_name = "Register";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'attendanceID' => array(
                                'type' => 'INT',
                                 'auto_increment' => TRUE
                        ),
                        'lessonID' => array(
                                'type' => 'INT',
                        ),
                        'userID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30
                        ),
                        'attendance' => array(
                                'type' => 'TINYINT'
                        ),
                        'note' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 100,
                                'null' => TRUE,
                        ),
                );
                
                $this->dbforge->add_key('attendanceID', TRUE);
                
                $this->dbforge->add_field($fields);
                
                // $attributes = array('ENGINE' => 'InnoDB');
                // $this->dbforge->create_table(self::table_name, FALSE; $attributes);
                // https://rtcamp.com/tutorials/mysql/innodb-to-myisam/
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($lessonId, $userId, $attendance, $note)
        {
                $data = array(
                   'lessonID' => $lessonId,
                   'userID' => $userId,
                   'attendance' => $attendance,
                   'note' => urldecode($note)
                );

                $this->db->insert(self::table_name, $data);
        }
        
        public function update($attendanceID, $lessonId, $userId, $attendance, $note)
        {
                $this->db->where('attendanceID', $attendanceID);
                $this->db->where('lessonID', $lessonId);
                $this->db->where('userID', $userId);

                $data = array();                
                if($attendance != null) $data['attendance'] = $attendance;
                if($note != null) $data['note'] = $note;
                
                $this->db->update(self::table_name, $data);
        }
        
        public function update_batch($attendances)
        {
                $this->db->update_batch(self::table_name, $attendances, 'attendanceID');
        }
        
        public function delete_user($userId)
        {
                $this->db->delete(self::table_name, array('userID' => $userId));
        }
        
        public function delete_lesson($lessonId)
        {
                $this->db->delete(self::table_name, array('lessonID' => $lessonId));
        }
        
        public function delete($attendanceID)
        {
                $this->db->delete(self::table_name, array('$attendanceID' => $attendanceID));
        }
        
        public function get($lessonId = null, $userId = null)
        {
                $costraints = array();

                if($lessonId != null) $costraints['lessonID'] = $lessonId;
                if($userId != null) $costraints['userID'] = $userId;
                
                $query = $this->db->get_where(self::table_name, $costraints);
                
                return $query->result_array();
        }
}
?>