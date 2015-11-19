<?php

class Welcome extends CI_Controller {

	const COOKIE_DAYS = 90;

	public function __construct()
    {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('users_model');
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->isLoggedIn();
		
		$this->load->view('index');
	}
	
	public function isLoggedIn()
    {
        // $userID = $this->input->post('username');
        // $token = $this->input->post('token');
        
        if(!isset($_COOKIE["username"]) || !isset($_COOKIE["token"]))
        {
            // print("A");
            setcookie('verified', 0, time()+86400*self::COOKIE_DAYS, "/");
        }
        else if(!$this->users_model->isLoggedIn($_COOKIE["username"], $_COOKIE["token"]))
        {
            // print("B");
            setcookie('verified', 0, time()+86400*self::COOKIE_DAYS, "/");
        }
        else
        {
            // print("C");
            setcookie('verified', 1, time()+86400*self::COOKIE_DAYS, "/");
        }
	}
}
