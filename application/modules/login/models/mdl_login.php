<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class mdl_login extends CI_Model {

		public function cek_user($data) 
		{
			$query = $this->db->get_where('tb_users', $data);
			return $query;
		}

	}

?>
