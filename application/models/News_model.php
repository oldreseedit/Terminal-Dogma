<?php
class News_model extends CI_Model
{
        const table_name = "News";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'newsID' => array(
                                'type' => 'INT',
                                 'auto_increment' => TRUE
                        ),
                        'text' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 4096
                        ),
                        'publishingTimestamp' => array(
                                'type' => 'DATETIME'
                        ),
                        'courseID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE,
                        ),
                );
                
                $this->dbforge->add_key('newsID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($text, $publishingTimestamp, $courseID)
        {
                $data = array(
                   'text' => $text,
                   'publishingTimestamp' => $publishingTimestamp,
                   'courseID' => $courseID,
                );
                
                $this->db->insert(self::table_name, $data);
                return $this->db->insert_id();
        }
        
        public function delete($newsID)
        {
                $data = array('newsID' => $newsID);

                return $this->db->delete(self::table_name, $data);
        }
        
        public function update($newsID, $text = null, $publishingTimestamp = null, $courseID = null)
        {
                $data = array();
                if($text != null) $data['text'] = $lessonID;
                if($publishingTimestamp != null) $data['publishingTimestamp'] = $publishingTimestamp;
                if($courseID != null) $data['courseID'] = $courseID;
                if(count($data) == 0) return false;
                
                $this->db->where('newsID', $newsID)->update(self::table_name, $data);
                
                return true;
        }
        
        public function get($newsID)
        {
                return $this->db->where('newsID', $newsID)->get(self::table_name)->row_array();
        }
        
        public function get_latest_news($n, $courseID = null)
        {
                $data = array();
                if($courseID != null) $data['courseID'] = $courseID;
                return $this->db->where($data)->order_by('publishingTimestamp', 'desc')->limit($n)->get(self::table_name)->result_array();
        }
}
?>