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
                                'type' => 'VARCHAR',
                        		'constraint' => 100
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
                				'type' => 'TEXT',
                		),
                		'mainImage' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 2048
                		),
                		'requirements' => array(
                				'type' => 'TEXT',
                		),
                		'body' => array(
                				'type' => 'TEXT',
                		),
                		'tags' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 512
                		),
                		'seealso' => array(
                				'type' => 'TEXT',
                		),
                		'publishingTimestamp' => array(
                				'type' => 'DATETIME'
                		),
                		'images' => array(
                				'type' => 'TEXT',
                		),
                );
                
                $this->dbforge->add_key('tutorialID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($tutorialID, $title, $body, $publishingTimestamp, $description = null, $course = null, $requirements = null, $tags = null, $seealso = null, $mainImage = null, $images)
        {
                $data = array(
                	'tutorialID' => $tutorialID,
                   	'title' => $title,
					'body' => $body,
                    'publishingTimestamp' => $publishingTimestamp,
                );
                
                if($description != null) $data['description'] = $description;
                if($course != null) $data['course'] = $course;
                if($requirements != null) $data['requirements'] = $requirements;
                if($tags != null) $data['tags'] = $tags;
                if($mainImage != null) $data['mainImage'] = $mainImage;
                if($seealso != null) $data['seealso'] = $seealso;
                
                if(!empty($images)) $data['images'] = json_encode($images);
                
                $this->db->insert(self::table_name, $data);
        }
        
        public function update($tutorialID, $title = null, $body = null, $publishingTimestamp = null, $description = null, $course = null, $requirements = null, $tags = null, $seealso = null, $mainImage = null)
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
                if($mainImage != null) $data['mainImage'] = $mainImage;
                
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