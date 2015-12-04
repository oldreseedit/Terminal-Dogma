<?php
class Admins_model extends CI_Model
{
        const table_name = "admins";
        
        public function __construct()
        {
                $this->load->database();
                $this->load->helper('url');
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'userID' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30
                        ),
                        'isAdmin' => array(
                                'type' => 'TINYINT',
                        ),
                );
                
                $this->dbforge->add_key('userID', TRUE);
                
                $this->dbforge->add_field($fields);
                $this->dbforge->create_table(self::table_name);
        }
        
        public function get_admins()
        {
                $query = $this->db->get(self::table_name);
                return $query->result_array();
        }
        
        public function is_admin($userID)
        {
                $result = $this->db->select('isAdmin')->where('userID', $userID)->get(self::table_name)->row_array();
                if(count($result) == 0) return false;
                
                if($result['isAdmin']) return true;
                else return false;
        }
        
        public function add_admin($userID)
        {
                $data = array(
                   'userID' => $userID,
                   'isAdmin' => true
                );

                $this->db->insert(self::table_name, $data);
        }
        
        public function set_admin($userID, $isAdmin = true)
        {
                $this->db->where('userID', $userID);
                $this->db->update(self::table_name, array('isAdmin' => $isAdmin));
        }
}
?>