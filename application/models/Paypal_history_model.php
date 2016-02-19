<?php
class Paypal_history_model extends CI_Model
{
        const table_name = "paypal";
        
        public function __construct()
        {
                $this->load->database();
        }
        
        public function init()
        {
                $this->load->dbforge();
                
                $fields = array(
                		'paymentID' => array(
                				'type' => 'INT',
                				'auto_increment' => TRUE
                		),
                		
                		'paypalPaymentID' => array('type' => 'VARCHAR', 'constraint' => 1024),
                        'userID' => array('type' => 'VARCHAR', 'constraint' => 30),
                        'request' => array('type' => 'VARCHAR', 'constraint' => 2048),
        				'response' => array('type' => 'VARCHAR', 'constraint' => 2048),
                		'paymentDate' => array('type' => 'DATETIME'),
                		'state' => array('type' => 'VARCHAR', 'constraint' => 16),
                );
                
                $this->dbforge->add_key('paymentID', TRUE);
                
                $this->dbforge->add_field($fields);
                
                $this->dbforge->create_table(self::table_name);
        }
        
        public function add($paypalPaymentID, $userID, $request, $response, $paymentDate, $state)
        {
                $data = array(
						'paypalPaymentID' => $paypalPaymentID,
                        'userID' => $userID,
                        'request' => $request,
                		'response' => $response,
                        'paymentDate' => $paymentDate,
                		'state' => $state
				);
                
                $this->db->insert(self::table_name, $data);
        }
        
//         public function update_paypal($paypalPaymentID, $response, $status)
//         {
//         	$this->db->where('paypalPaymentID', $paypalPaymentID)->update(self::table_name, array('response' => $response, 'state' => $status));
//         }
        
//         public function get($paymentID)
//         {
//                 $this->db->where('paymentID', $paymentID);
//                 $query = $this->db->get(self::table_name);
//                 return $query->row_array();
//         }
        
        public function get_all()
        {
        	return $this->db->order_by("paymentDate", "desc")->get(self::table_name)->result_array();
        }
}
?>