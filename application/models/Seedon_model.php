<?php

class Seedon_model extends CI_Model
{
	const table_name = "seedons";
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();
	}
	
	public function init()
	{
		$this->load->dbforge();
		
		$fields = array(
				'seedonID' => array(
						'type' => 'INT',
                    	'auto_increment' => TRUE
                ),
				'seedon' => array(
						'type' => 'CHAR',
						'constraint' => 32,
				),
				'startingDate' => array(
						'type' => 'DATETIME',
						'null' => true
				),
				'endingDate' => array(
						'type' => 'DATETIME',
						'null' => true
				),
				'description' => array(
						'type' => 'VARCHAR',
						'constraint' => 1024,
						'null' => true
				),
				'used' => array(
						'type' => 'TINYINT',
				),
		);
		
		$this->dbforge->add_key('seedonID', TRUE);
		
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table(self::table_name);
	}
	
	public function save($userID, $randomSeedon, $description = null, $startingDate = null, $endingDate = null, $tag = null)
	{
		$data = array();
		
		$data['username'] = $userID;
		$data['seedon'] = $randomSeedon;
		$data['used'] = false;
		
		if($description != null) $data['description'] = $description;
		if($startingDate != null) $data['startingDate'] = $startingDate;
		if($endingDate != null) $data['endingDate'] = $endingDate;
		if($tag != null) $data['tag'] = $tag;
		
		$this->db->insert(self::table_name, $data);
	}
	
	public function use_random_seedon($seedonID)
	{
		$this->db->where('seedonID', $seedonID)->update('seen', true);
	}
	
	public function get($userID)
	{
		return $this->db->where('username', $userID)->get(self::table_name)->result_array();
	}
	
	public function get_seedon_not_used($userID)
	{
		return $this->db->where(array('username' => $userID, 'used' => false))->get(self::table_name)->result_array();
	}
}

?>