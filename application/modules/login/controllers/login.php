<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index() {
		$this->load->view('login');
	}

	public function cek_login() 
	{
		$data = array('username' => $this->input->post('user', TRUE),
						'password' => md5($this->input->post('pass', TRUE))
	);

	$this->load->model('mdl_login');
	$hasil = $this->mdl_login->cek_user($data);
		if ($hasil->num_rows() == 1) {
			foreach ($hasil->result() as $sess) 
			{
				$sess_data['logged_in'] = 'Online';
				$sess_data['id'] = $sess->id;
				$sess_data['username'] = $sess->username;
				$sess_data['level'] = $sess->level;
				//$sess_data['nama_lengkap'] = $sess->nama_lengkap;
				$sess_data['gambar'] = $sess->gambar;	
				$this->session->set_userdata($sess_data);
			}
			if ($this->session->userdata('level')=='1') {
					$msg="<script>alert('Login Sebagai $sess->username')</script>";
					$this->session->set_flashdata("pesan",$msg);
				redirect('dashboard/dashboard');
			}
			elseif ($this->session->userdata('level')=='2') {
					$msg="<script>alert('Login Sebagai $sess->username')</script>";
					$this->session->set_flashdata("pesan",$msg);
				redirect('dashboard/dashboard');
			}
		}
		else 
		{
			$msg="<script>alert('Maaf! Username dan Password anda Salah')</script>";
				$this->session->set_flashdata("pesan",$msg);
			redirect('login');
		}
	}


	public function logout(){
		$this->session->sess_destroy();
			redirect("login");
	}
}

?>
