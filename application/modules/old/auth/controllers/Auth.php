<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	
	public function __construct(){

		parent:: __construct();

			$this->load->helper('url');

	}

	public function index()
	{
		
		$this->load->view('login');
	
	}

	
	public function login(){

			$this->load->model('mdl_login');

			$cek_login = $this->mdl_login->validasi();
		
			//$cek = $this->testing();
			
			if($cek_login){

				foreach ($cek_login as $data_login) {
						# code...
						$id				= $data_login['id'];
						$username		= $data_login['username'];
						$nama_lengkap	= $data_login['nama_lengkap'];
						$foto			= $data_login['foto'];
						$level			= $data_login['level'];
						
					}	

					$data_login = array(
						'id'			=>$id,
						'username'		=>$username,
						'is_logged_in'	=>TRUE,
						'foto'			=>$foto,
						'level'			=>$level
					);

					$this->session->set_userdata($data_login);

						redirect(base_url().'index.php/dashboard/');

					echo "success";

			} 

				else{

					$this->index();

					echo('<script> alert(gagal)</script>');


			}


	}


	public function logout()
	{

		$this->session->sess_destroy();

		$this->index();
	
	}


}
