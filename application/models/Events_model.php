<?php
class Events_model extends CI_Model
{
        const table_name = "events";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'eventID' => array(
                                'type' => 'INT',
                                 'auto_increment' => TRUE
                        ),
                        'title' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 1024
                        ),
                		'description' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 4096
                		),
                		'place' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 2048
                		),
                		'startingDate' => array(
                				'type' => 'DATETIME'
                		),
                		'endingDate' => array(
                				'type' => 'DATETIME'
                		),
                		'publishingTimestamp' => array(
                				'type' => 'DATETIME'
                		),
                );
                
                $this->dbforge->add_key('eventID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($title, $description, $place, $startingDate, $endingDate, $publishingTimestamp)
        {
                $data = array(
                   	'title' => $title,
					'description' => $description,
                	'place' => $place,
                	'startingDate' => $startingDate,
                	'endingDate' => $endingDate,
                    'publishingTimestamp' => $publishingTimestamp,
                );
                
                $this->db->insert(self::table_name, $data);
        }
        
        public function delete($eventID)
        {
                $data = array('eventID' => $eventID);

                return $this->db->delete(self::table_name, $data);
        }
        
        public function update($eventID, $title = null, $description = null, $place = null, $startingDate = null, $endingDate = null, $publishingTimestamp = null)
        {
                $data = array();
                if($title != null) $data['title'] = $title;
                if($description != null) $data['description'] = $description;
                if($place != null) $data['place'] = $place;
                if($startingDate != null) $data['startingDate'] = $startingDate;
                if($endingDate != null) $data['endingDate'] = $endingDate;
                if($publishingTimestamp != null) $data['publishingTimestamp'] = $publishingTimestamp;
                if(count($data) == 0) return false;
                
                $this->db->where('eventID', $eventID)->update(self::table_name, $data);
                
                return true;
        }
        
        public function get($eventID)
        {
                return $this->db->where('eventID', $eventID)->get(self::table_name)->row_array();
        }
        
        public function get_latest_events($n)
        {
                $data = array();
                return $this->db->order_by('startingDate', 'desc')->limit($n)->get(self::table_name)->result_array();
        }
}
?>