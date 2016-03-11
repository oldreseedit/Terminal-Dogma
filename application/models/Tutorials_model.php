<?php
class Tutorials_model extends CI_Model
{
        const table_name = "tutorials";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'tutorialID' => array(
                                'type' => 'INT',
                                 'auto_increment' => TRUE
                        ),
                        'title' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 1024
                        ),
                		'course' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 64
                		),
                		'description' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 2048
                		),
                		'requirements' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 2048
                		),
                		'body' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 4096
                		),
                		'tags' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 512
                		),
                		'seealso' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 1024
                		),
                		'publishingTimestamp' => array(
                				'type' => 'DATETIME'
                		),
                );
                
                $this->dbforge->add_key('tutorialID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($title, $body, $publishingTimestamp, $description = null, $course = null, $requirements = null, $tags = null, $seealso = null)
        {
                $data = array(
                   	'title' => $title,
					'body' => $body,
                    'publishingTimestamp' => $publishingTimestamp,
                );
                
                if($description != null) $data['description'] = $description;
                if($course != null) $data['course'] = $course;
                if($requirements != null) $data['requirements'] = $requirements;
                if($tags != null) $data['tags'] = $tags;
                if($seealso != null) $data['seealso'] = $seealso;
                
                $this->db->insert(self::table_name, $data);
                
                return $this->db->insert_id(); 
        }
        
        public function update($tutorialID, $title = null, $body = null, $publishingTimestamp = null, $description = null, $course = null, $requirements = null, $tags = null, $seealso = null)
        {
                $data = array();
                if($title != null) $data['title'] = $title;
                if($body != null) $data['body'] = $body;
                if($publishingTimestamp != null) $data['publishingTimestamp'] = $publishingTimestamp;
                
                if($description != null) $data['description'] = $description;
                if($course != null) $data['course'] = $course;
                if($requirements != null) $data['requirements'] = $requirements;
                if($tags != null) $data['tags'] = $tags;
                if($seealso != null) $data['seealso'] = $seealso;
                
                if(count($data) == 0) return false;
                
                $this->db->where('tutorialID', $tutorialID)->update(self::table_name, $data);
                
                return true;
        }
        
        public function delete($tutorialID)
        {
        	return $this->db->where('tutorialID', $tutorialID)->delete(self::table_name);
        }
        
        public function get($tutorialID)
        {
                return $this->db->where('tutorialID', $tutorialID)->get(self::table_name)->row_array();
        }
        
        public function get_all_tutorials()
        {
        	$data = array();
        	return $this->db->order_by('publishingTimestamp', 'desc')->get(self::table_name)->result_array();
        }
}
?>