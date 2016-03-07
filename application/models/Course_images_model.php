<?php
class Course_images_model extends CI_Model
{
        const table_name = "course_images";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                		'imageID' => array(
                				'type' => 'INT',
                				'auto_increment' => TRUE
                		),
                		'courseID' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 30,
                		),
                		'imageURI' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 2000
                        ),
                		'preference_order' => array(
                				'type' => 'INT',
                				'unsigned' => TRUE
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
                
                $this->dbforge->add_key('imageID', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($courseID, $imageURI, $preferenceOrder, $uploadTimestamp, $note = null)
        {
                $data = array(
                   'courseID' => $courseID,
                   'imageURI' => $imageURI,
                   'preferenceOrder' => $preferenceOrder,
                   'uploadTimestamp' => $uploadTimestamp
                );
                if($note != null) $data['note'] = $note;

                $this->db->insert(self::table_name, $data);
        }
        
        public function update($imageID, $preferenceOrder)
        {
        	$this->db->where('imageID', $imageID)->update(self::table_name, array('preferenceOrder' => $preferenceOrder));
        }
        
        public function delete($imageID)
        {
            $this->db->delete(self::table_name, array('imageID' => $imageID));
        }
        
        public function get($subject)
        {
        	// return $this->db->where('courseID', $courseID)->get(self::table_name)->result_array();
        	$images = array();
        	foreach(preg_grep('/^([^.]).*[^(db)]$/', scandir("imgs/carousel/".$subject)) as $file)
        	{
        		$images[] = $file;
        	}
        	
        	return $images;
        }
}
?>