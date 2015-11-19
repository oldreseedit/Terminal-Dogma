<?php
class Confirm_payment extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                // $this->load->model('contacts_model');
                $this->load->helper('url');
        }
        
        public function index()
        {
            $this->load->view('confirm_payment/confirm_payment');
        }
}
?>