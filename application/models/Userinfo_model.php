<?php
class Userinfo_model extends CI_Model
{
        const table_name = "users_info";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'userID' => array('type' => 'VARCHAR', 'constraint' => 30),
                        'email' => array('type' => 'VARCHAR', 'constraint' => 30),
                        'registrationDate' => array('type' => 'DATETIME'),
                        'name' => array('type' => 'VARCHAR', 'constraint' => 30),
                        'surname' => array('type' => 'VARCHAR', 'constraint' => 30),
                        'birthdate' => array('type' => 'DATE'),
                        'profilePicture' => array('type' => 'VARCHAR', 'constraint' => 2083),
                        'profession' => array('type' => 'VARCHAR', 'constraint' => 50),
                        'schoolName' => array('type' => 'VARCHAR', 'constraint' => 100),
                        'educationLevel' => array('type' => 'VARCHAR', 'constraint' => 100),
                        'address' => array('type' => 'VARCHAR', 'constraint' => 256),
                        'phoneNumber' => array('type' => 'VARCHAR', 'constraint' => 20),
                        'mobileNumber' => array('type' => 'VARCHAR', 'constraint' => 20),
                        'advertisementProvenance' => array('type' => 'VARCHAR', 'constraint' => 256),
                        'currentExp' => array('type' => 'INT', 'unsigned' => TRUE),
                        'previousExp' => array('type' => 'INT', 'unsigned' => TRUE),
                        'level' => array('type' => 'SMALLINT', 'unsigned' => TRUE),
                );
                
                $this->dbforge->add_key('userID', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($userID, $mail, $name, $surname, $registration_timestamp)
        {
                $data = array(
                   'userID' => $userID,
                   'email' => $mail,
                   'name' => $name,
                   'surname' => $surname,
                   'registrationDate' => $registration_timestamp
                );
                
                $this->db->insert(self::table_name, $data);
        }
        
        public function update($userID, $data)
        {
                $this->db->where('userID', $userID);
                $this->db->update(self::table_name, $data);
        }
        
        public function get($userID)
        {
                $this->db->where('userID', $userID);
                $query = $this->db->get(self::table_name);
                return $query->row_array();
        }
        
        public function get_all()
        {
                $query = $this->db->get(self::table_name);
                return $query->result_array();
        }
        
        public function delete($userID)
        {
                $this->db->delete(self::table_name, array('userID' => $userID));
        }
        
        public function get_exp_info($userID)
        {
                return $this->db->select('level, currentExp')->where('userID', $userID)->get(self::table_name)->row_array();
        }
        
        public function update_exp_info($userID, $oldExp, $newExp, $level)
        {
                $this->db->where('userID', $userID)->update(self::table_name, array('currentExp' => $newExp, 'previousExp' => $oldExp, 'level' => $level));
        }
}
?>