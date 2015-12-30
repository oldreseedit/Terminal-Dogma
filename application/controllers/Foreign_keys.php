<?php
class Foreign_keys extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('foreign_keys_model');
        }
        
        public function remove_all()
        {
        	$this->foreign_keys_model->remove_all();
        }
        
        public function add_all()
        {
        	$this->foreign_keys_model->add_all();
        }
}
?>