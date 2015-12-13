<?php

class Activity extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('activity_block_positions_model');
                $this->load->model('activities_model');

                $this->load->library('permissions');
                
                $this->load->helper('url');
        }
        
        public function index($activityID)
        {
        	if(!$this->activities_model->exists($activityID))
        	{
        		$this->load->view("errors/html/error_404.php", array('heading' => "Errore", 'message' => "Servizio inesistente."));
        		return;
        	}
        	
                $this->load->view('activities/activity');
        }
}
?>