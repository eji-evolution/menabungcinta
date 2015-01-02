<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        auth_login();
    }

	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['page'] = 'master/content';
		$this->load->view('backend/layout',$data);
	}

}