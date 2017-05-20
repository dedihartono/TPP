<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mdl_login extends ci_Model 
{
	public function __construct()
	{
		parent::__construct();		
	}

	public function ceklogin()
	{
		//variable
		$user=$this->input->post("user");
		$pass=md5($this->input->post("pass"));
		//////////////////////////////////////
		
		$q="select * from user where username='$user' and password='$pass'";
		$db=$this->db->query($q);
		if ($db->num_rows()!=0)
		{
			$db=$db->row();
			if($db->level=="1")
			{
			$data=array(
			'level'=>'Admin',
			);
			 $this->session->set_userdata($data);
			 $msg="<script>alert('Login Sebagai Administrator')</script>";
			 $this->session->set_flashdata("pesan",$msg);
			 redirect('dashboard/dashboard');
			}
		}

		else{
			$msg="<script>alert('Maaf! Username dan Password anda Salah')</script>";
			
			$this->session->set_flashdata("pesan",$msg);
			
			redirect('login');
		}
	}


}
?>