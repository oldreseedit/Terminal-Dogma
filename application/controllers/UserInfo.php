<?php
class UserInfo extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('userinfo_model');
                $this->load->helper('url');
        }
        
        public function init()
        {
            $this->userinfo_model->init();
        }
}
?>