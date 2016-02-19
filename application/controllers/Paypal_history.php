<?php

class Paypal_history extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('paypal_history_model');
        }
        
        public function init()
        {
        	$this->paypal_history_model->init();
        }
        
        public function get_all()
        {
        	print json_encode($this->paypal_history_model->get_all());
        }
}
?>