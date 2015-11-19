<?php
class Cancel_payment extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                // $this->load->model('contacts_model');
                $this->load->helper('url');
        }
        
        public function index()
        {
            $this->load->view('cancel_payment/cancel_payment');
        }
}
?>