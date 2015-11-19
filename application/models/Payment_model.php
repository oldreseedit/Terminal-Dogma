<?php
class Payment_model extends CI_Model
{
        const table_name = "Payment";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                        'userID' => array('type' => 'VARCHAR', 'constraint' => 30),			
                        'courseID' => array('type' => 'VARCHAR', 'constraint' => 30),
                        'paymentChoice' => array('type' => 'VARCHAR', 'constraint' => 30),
                        'rate' => array('type' => 'VARCHAR', 'constraint' => 30),
                        'paymentDate' => array('type' => 'DATETIME')
                );
                
                $this->dbforge->add_key('userID', TRUE);
                $this->dbforge->add_key('courseID', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($userID, $courseID, $paymentChoice, $rate, $paymentDate)
        {
                $data = array();
                
                foreach($courseID as $course)
                        array_push($data,
                                array(
                                   'userID' => $userID,
                                   'courseID' => $course,
                                   'paymentChoice' => $paymentChoice,
                                   'rate' => $rate,
                                   'paymentDate' => $paymentDate
                                ));
                
                $this->db->insert_batch(self::table_name, $data);
        }
        
        public function get($paymentID)
        {
                $this->db->where('paymentID', $paymentID);
                $query = $this->db->get(self::table_name);
                return $query->row_array();
        }
        
        public function get_payment($userID, $courseID)
        {
                // $this->db->where('userID', $userID);
                
                $var = "";
                for($i=0; $i<count($courseID); $i++)
                {
                        if($i > 0) $var .= ' OR ';
                        $var .= 'courseID = "' . $courseID[$i] . '"';
                }
                
                $this->db->where('userID = ' . '"' . $userID . '"' . ' AND (' . $var . ')');
                // foreach($courseID as $course)
                //$this->db->or_where('courseID', $course);
                        
                $query = $this->db->get(self::table_name);
                return $query->result_array();
        }
        
        public function get_courses($userID = null)
        {
                $courses = array();
                
                $this->db->distinct();
                $query = $this->db->select('CourseID');
                $query = $this->db->from('Payment');
                
                if($userID != null) $this->db->where('userID', $userID);
                
                $query = $this->db->get();
                return $query->result_array();
        }
        
        public function get_subscribers($courseID = null)
        {
                $courses = array();
                
                $this->db->distinct();
                $query = $this->db->select('CourseID, UserID');
                $query = $this->db->from('Payment');
                
                if($courseID != null) $this->db->where('CourseID', $courseID);
                
                $query = $this->db->get();
                return $query->result_array();
        }
        
        public function get_subscribers_names($courseID = null)
        {
                $courses = array();
                
                $this->db->distinct();
                $query = $this->db->select('CourseID, InfoUtenti.userID, InfoUtenti.name, InfoUtenti.surname');
                $query = $this->db->from('Payment');
                $this->db->join('InfoUtenti', 'InfoUtenti.userID = Payment.userID');
                
                if($courseID != null) $this->db->where('CourseID', $courseID);
                
                $query = $this->db->get();
                return $query->result_array();
        }
}
?>