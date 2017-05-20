<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends CI_Controller {

	
	public function __construct(){

		parent::__construct();
		
			$this->load->helper('url');
			
			$this->load->model('mdl_example','example');

	}

	public function index()
	{
		

		$data['konten'] = 'hitung';
		
		$data['hitung'] = $this->example->hitung();

		$this->load->view('template', $data);

	}
}
