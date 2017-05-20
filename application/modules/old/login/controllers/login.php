<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();	
		$this->load->model('mdl_login');
		
	}

	public function index()
	{
		if($this->session->userdata("level"))
			{
				redirect("login");
			}
			$this->load->view('login');
	}

	public function ceklogin()
	{
		$this->load->model("mdl_login");
		$this->mdl_login->ceklogin();
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect("login");
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
