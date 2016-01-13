<?php
class Notifications_model extends CI_Model
{
        const table_name = "notifications";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'notificationID' => array(
                                'type' => 'INT',
                                 'auto_increment' => TRUE
                        ),
                        'text' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 4096
                        ),
                        'publishingTimestamp' => array(
                                'type' => 'DATETIME',
                				'constraint' => 6
                        ),
                        'username' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30
                        ),
                        'seen' => array(
                                'type' => 'TINYINT',
                        ),
                        'courseID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE,
                        ),
                        'private' => array(
                                'type' => 'TINYINT',
                        ),
                );
                
                $this->dbforge->add_key('notificationID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($text, $publishingTimestamp, $userIDs, $private, $courseID = null)
        {
                $data = array();
                
                foreach($userIDs as $userID)
                {
                        if($userID == null) continue;
                        
                        $userData = array(
                           'text' => $text,
                           'username' => $userID,
                           'publishingTimestamp' => $publishingTimestamp,
                           'seen' => false,
                           'private' => $private
                        );
                        
                        if($courseID != null) $userData['courseID'] = $courseID;
                        
                        $data[] = $userData;
                }
                
                if($data)
                	$this->db->insert_batch(self::table_name, $data);
        }
        
        public function delete($notificationID)
        {
                $data = array('notificationID' => $notificationID);

                return $this->db->delete(self::table_name, $data);
        }
        
        function update($notificationID, $text = null, $seen = null, $private = null, $courseID = null)
        {
                $data = array();
                if($text != null) $data['text'] = $text;
                if($courseID != null) $data['courseID'] = $courseID;
                if($seen != null) $data['seen'] = $seen;
                if($private != null) $data['private'] = $private;
                if(count($data) == 0) return false;
                
                $this->db->where('notificationID', $notificationID)->update(self::table_name, $data);
                
                return true;
        }
        
        public function update_batch($data)
        {
        	$this->db->update_batch(self::table_name, $data, 'notificationID');
        }
        
        public function get($notificationID)
        {
                return $this->db->where('notificationID', $notificationID)->get(self::table_name)->row_array();
        }
        
        public function get_notifications($courseID)
        {
                return $this->db
                ->select('text, publishingTimestamp')
                ->distinct()
                ->where('courseID', $courseID)
                ->where('private', false)
                ->order_by('publishingTimestamp', 'desc')
                ->get(self::table_name)
                ->result_array();
        }
        
        public function get_user_notifications($userID, $courseID = null)
        {
                $data = array('username' => $userID);
                if($courseID != null) $data['courseID'] = $courseID;
                
                return $this->db
                ->where($data)
                ->where('private', true)
                ->order_by('publishingTimestamp', 'desc')
                ->get(self::table_name)
                ->result_array();
        }
        
        public function get_unseen_user_notifications($userID, $courseID = null)
        {
                $data = array('username' => $userID);
                $data['seen'] = false;
                if($courseID != null) $data['courseID'] = $courseID;
                
                return $this->db
                ->where($data)
                ->where('private', true)
                ->order_by('publishingTimestamp', 'desc')
                ->get(self::table_name)
                ->result_array();
        }
}
?>