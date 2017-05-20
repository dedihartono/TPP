<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hitung extends CI_Controller {

	
	public function __construct(){

		parent::__construct();
		
			$this->load->helper('url');

			$this->load->model('mdl_hitung','hitung');

			$this->load->model('master/mdl_pegawai','pegawai');

			$this->load->model('master/mdl_jabatan','jabatan');

			$this->load->model('master/mdl_golongan','golongan');

			$this->load->model('master/mdl_sekolah','sekolah');

			$this->load->model('master/mdl_uptd','uptd');

	}


	

	public function index()
	{
		$data['konten']="hitung";

		$this->load->view('template',$data);
	}

	public function ajax_list()
	{
		
		$list = $this->hitung->get_datatables();
		
		$data = array();
		
		$no = $_POST['start'];
		
		foreach ($list as $hitung) {
			
			$no++;
			
			$row = array();
			$row[] = $no;
			$row[] = $hitung->nama_pegawai;
			$row[] = $hitung->nip;
			$row[] = $hitung->npwp;
			$row[] = $hitung->nama_golongan;
			$row[] = $hitung->nama_jabatan;
			$row[] = $hitung->nominal_kehadiran;
			$row[] = $hitung->jumlah_pajak;
			$row[] = $hitung->jumlah_bersih;
			
			
			$data[] = $row;
		}

			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->hitung->count_all(),
							"recordsFiltered" => $this->hitung->count_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output);
	}
	
}
