<?php
class Payment_model extends CI_Model
{
        const table_name = "payment";
        
        public function __construct()
        {
                $this->load->database();
                $this->load->model('userinfo_model');
                $this->load->model('courses_model');
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'userID' => array('type' => 'VARCHAR', 'constraint' => 30),			
                        'courseID' => array('type' => 'VARCHAR', 'constraint' => 30),
                		'simulation' => array('type' => 'TINYINT'),
                        'paymentChoice' => array('type' => 'VARCHAR', 'constraint' => 30),
                        'rate' => array('type' => 'VARCHAR', 'constraint' => 30),
                        'paymentDate' => array('type' => 'DATETIME'),
                		'paypalCoursePaymentID' => array('type' => 'VARCHAR', 'constraint' => 2048),
                		'paypalSimulationPaymentID' => array('type' => 'VARCHAR', 'constraint' => 2048),
                );
                
                $this->dbforge->add_key('userID', TRUE);
                $this->dbforge->add_key('courseID', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
//         public function add($userID, $courseIDs, $paymentChoice, $rate, $paymentDate)
//         {
//                 $data = array();
                
//                 foreach($courseIDs as $course)
//                         array_push($data,
//                                 array(
//                                    'userID' => $userID,
//                                    'courseID' => $course,
//                                    'paymentChoice' => $paymentChoice,
//                                    'rate' => $rate,
//                                    'paymentDate' => $paymentDate
//                                 ));
                
//                 $this->db->insert_batch(self::table_name, $data);
//         }

		public function add($userID, $courseID, $simulation, $paymentChoice, $rate, $paymentDate, $paypalCoursePaymentID, $paypalSimulationPaymentID)
        {
                $data = array(
							'userID' => $userID,
                            'courseID' => $courseID,
                			'simulation' => $simulation,
                            'paymentChoice' => $paymentChoice,
                            'rate' => $rate,
                            'paymentDate' => $paymentDate,
                			'paypalCoursePaymentID' => $paypalCoursePaymentID,
                			'paypalSimulationPaymentID' => $paypalSimulationPaymentID
				);

                $this->db->insert(self::table_name, $data);
        }
        
        public function add_simulation($userID, $courseID, $paypalSimulationPaymentID)
        {
        	$data = array('simulation' => true, 'paypalSimulationPaymentID' => $paypalSimulationPaymentID);
        	
        	$this->db->where('userID', $userID);
        	$this->db->where('courseID', $courseID);
        	
        	$this->db->update(self::table_name, $data);
        }
        
        public function get($paymentID)
        {
                $this->db->where('paymentID', $paymentID);
                $query = $this->db->get(self::table_name);
                return $query->row_array();
        }
        
        public function get_payment($userID, $courseID)
        {
                $var = "";
                for($i=0; $i<count($courseID); $i++)
                {
                        if($i > 0) $var .= ' OR ';
                        $var .= 'courseID = "' . $courseID[$i] . '"';
                }
                
                $this->db->where('userID = ' . '"' . $userID . '"' . ' AND (' . $var . ')');
                        
                $query = $this->db->get(self::table_name);
                return $query->result_array();
        }
        
        public function get_courses($userID = null)
        {
                $courses = array();
                
                $this->db->distinct();
                $query = $this->db->select('courseID');
                $query = $this->db->from(self::table_name);
                
                if($userID != null) $this->db->where('userID', $userID);
                
                $query = $this->db->get();
                return $query->result_array();
        }
        
        public function get_courses_with_info($userID = null)
        {
        	$courses = array();
        
        	$this->db->distinct();
        	$query = $this->db->select(self::table_name . '.courseID, name, paymentDate, subject, icon, startingDate, price, duration');
        	$query = $this->db->from(self::table_name);
        
        	if($userID != null) $this->db->where('userID', $userID);
        
        	$query = $this->db->
        	join(Courses_model::table_name, Courses_model::table_name . "." . "courseID" . " = " . self::table_name . "." . "courseID")->
        	get();
        	return $query->result_array();
        }
        
        public function get_subscribers($courseID = null)
        {
                $courses = array();
                
                $this->db->distinct();
                $query = $this->db->select('courseID, userID');
                $query = $this->db->from(self::table_name);
                
                if($courseID != null) $this->db->where('courseID', $courseID);
                
                $query = $this->db->get();
                return $query->result_array();
        }
        
        public function get_subscribers_names($courseID = null)
        {
                $courses = array();
                
                $user_info_table = Userinfo_model::table_name;
                
                $this->db->distinct();
                $query = $this->db->select('courseID, '.$user_info_table.'.userID, '.$user_info_table.'.name, '.$user_info_table.'.surname');
                $query = $this->db->from(self::table_name);
                $this->db->join($user_info_table, $user_info_table . '.userID = ' . self::table_name . '.userID');
                
                if($courseID != null) $this->db->where('courseID', $courseID);
                
                $query = $this->db->get();
                return $query->result_array();
        }
}
?>