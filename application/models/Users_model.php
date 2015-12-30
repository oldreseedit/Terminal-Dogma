<?php

class Users_model extends CI_Model
{
        const table_name = "users";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'Username' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30
                        ),
                        'Password' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 200
                        ),
                        'Token' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 200
                        )
                );
                
                $this->dbforge->add_key('Username', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($userID, $password)
        {
                $encrypted_password = password_hash($password, PASSWORD_BCRYPT);
                
                $data = array(
                   'Username' => $userID,
                   'Password' => $encrypted_password,
                );
                
                $this->db->insert(self::table_name, $data);
        }
        
        public function match($userID, $password)
        {
                $this->db->select('Password');
                $this->db->from(self::table_name);
                $this->db->where("Username LIKE BINARY ", $userID);
                $query = $this->db->get();
                $result = $query->row_array();
                $encrypted_password = $result['Password'];
                
                return password_verify($password, $encrypted_password);
        }
        
        public function addToken($userID, $token)
        {
                $this->db->where('Username', $userID);
                $this->db->update(self::table_name, array('Token' => $token));
        }
        
        public function isLoggedIn($userID, $token)
        {
                $this->db->select('Token');
                $this->db->from(self::table_name);
                $this->db->where(array('Username' => $userID));
                $query = $this->db->get();
                $result = $query->row_array();
                $token_in_db = $result['Token'];
                
                return strcmp($token, $token_in_db) == 0;
        }
        
        public function isAdmin($userID, $token)
        {
        	$this->db->select('Username, Token');
        	$this->db->from(self::table_name);
        	$this->db->where(array('Username' => $userID));
        	$this->db->join('admins','admins.userID = ' . self::table_name . '.Username','inner');
        	$query = $this->db->get();
        	$result = $query->row_array();
            $token_in_db = $result['Token'];
            return strcmp($token, $token_in_db) == 0;
        }
        
        public function isUser($userID,$token)
        {
        	$this->db->select('Username, Token');
        	$this->db->from(self::table_name);
        	$this->db->where(array('Username' => $userID));
        	$query = $this->db->get();
        	$result = $query->row_array();
        	$token_in_db = $result['Token'];
        	return strcmp($token, $token_in_db) == 0;
        }
        
        public function delete($userID)
        {
                $this->db->delete(self::table_name, array('Username' => $userID));
        }
        
        public function exists($userID)
        {
                $this->db->select('Username');
                $this->db->from(self::table_name);
                $this->db->where(array('Username' => $userID));
                
                $query = $this->db->get();
                return $query->num_rows() == 1;
        }
}
?>