<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

class mdl_example extends CI_Model {




	public function __construct(){

		parent::__construct();

			

	}

	public function hitung()
	{
		
		return	$this->db->query("SELECT id_pelanggan, id_produk, SUM(jml_byr) AS total FROM `sales` GROUP BY id_pelanggan, id_produk")->result();
	
	}

}
