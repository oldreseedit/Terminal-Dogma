<?php
class Activities_model extends CI_Model
{
        const table_name = "activities";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'activityID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                        ),
                		'name' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 30,
                				'null' => true
                		),
                        'description' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 4096,
                        		'null' => true
                        ),
                		'otj_description' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 4096,
                				'null' => true
                		),
                		'who' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 4096,
                				'null' => true
                		),
                		'prices' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 4096,
                				'null' => true
                		),
                		'icon' => array(
                				'type' => 'VARCHAR',
                				'constraint' => 2000,
                				'null' => true
                		),
                );
                
                $this->dbforge->add_key('activityID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($activityID, $name = null, $description = null, $otj = null, $who = null, $prices = null, $iconURI = null)
        {
                $data = array(
                   'activityID' => $activityID,
                );
                
                if($name != null) $data['name'] = $name;
                if($description != null) $data['description'] = $description;
                if($otj != null) $data['otj_description'] = $otj;
                if($who != null) $data['who'] = $who;
                if($prices != null) $data['prices'] = $prices;
                if($iconURI != null) $data['icon'] = $iconURI;
                
                $this->db->insert(self::table_name, $data);
                return $this->db->insert_id();
        }
        
        public function delete($activityID)
        {
                $data = array('activityID' => $activityID);

                return $this->db->delete(self::table_name, $data);
        }
        
        public function exists($activityID)
        {
        	return count($this->db->where('activityID', $activityID)->get(self::table_name)->row_array()) > 0;
        }
        
        public function update($activityID, $name = null, $description = null, $otj = null, $who = null, $prices = null, $iconURI = null)
        {
                $data = array();
                
                if($name != null) $data['name'] = $name;
                if($description != null) $data['description'] = $description;
                if($otj != null) $data['otj_description'] = $otj;
                if($who != null) $data['who'] = $who;
                if($prices != null) $data['prices'] = $prices;
                if($iconURI != null) $data['icon'] = $iconURI;
                
                if(count($data) == 0) return false;
                
                $this->db->where('activityID', $activityID)->update(self::table_name, $data);
                return true;
        }
        
        public function get($activityID)
        {
                return $this->db->where('activityID', $activityID)->get(self::table_name)->row_array();
        }
}
?>