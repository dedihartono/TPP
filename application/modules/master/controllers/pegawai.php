<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {

	
	public function __construct(){

		parent::__construct();
		
			$this->load->helper('url');

			$this->load->model('mdl_pegawai','pegawai');

			$this->load->model('mdl_jabatan','jabatan');

			$this->load->model('mdl_golongan','golongan');

			$this->load->model('mdl_sekolah','sekolah');

			$this->load->model('mdl_uptd','uptd');
	}


	

	public function index()
	{
		$data['konten']="pegawai";

		$data['jabatan']=$this->jabatan->list_jabatan();

		$data['golongan']=$this->golongan->list_golongan();

		$data['sekolah']=$this->sekolah->list_sekolah();

		$this->load->view('template',$data);

	}

	public function ajax_list()
	{
		
		$list = $this->pegawai->get_datatables();
		
		$data = array();
		
		$no = $_POST['start'];
		
		foreach ($list as $pegawai) {
			
			$no++;
			
			$row = array();
			$row[] = $no;
			$row[] = $pegawai->id_pegawai;
			$row[] = $pegawai->nip;
			$row[] = $pegawai->nama_pegawai;
			$row[] = $pegawai->tgl_lahir;
			$row[] = $pegawai->npwp;
			$row[] = $pegawai->alamat_pegawai;
			$row[] = $pegawai->nama_jabatan;
			$row[] = $pegawai->nama_golongan;
			$row[] = $pegawai->nm_sekolah;

			$row[] = 
					'<a class="btn btn-sm btn-primary" href="javascript:void(0)" 
						title="Ubah" onclick="edit_pegawai('."'".$pegawai->id_pegawai."'".')">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>

				  	<a class="btn btn-sm btn-danger" href="javascript:void(0)" 
				  		title="Hapus" onclick="delete_pegawai('."'".$pegawai->id_pegawai."'".')">
				  		<i class="glyphicon glyphicon-trash"></i>
				  	</a>';
			
			$data[] = $row;
		}

			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->pegawai->count_all(),
							"recordsFiltered" => $this->pegawai->count_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->pegawai->get_by_id($id);
		$data->tgl_lahir = ($data->tgl_lahir == '00-00-0000') ? '' : $data->tgl_lahir; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nip' => $this->input->post('nip'),
				'nama_pegawai' => $this->input->post('nama_pegawai'),
				//'tgl_lahir' => $this->input->post('tgl_lahir'),
				'tgl_lahir' => date('Y-m-d', strtotime($this->input->post['tgl_lahir'])),
				'npwp' => $this->input->post('npwp'),
				'alamat_pegawai' => $this->input->post('alamat_pegawai'),
				'id_jabatan' => $this->input->post('id_jabatan'),
				'id_golongan' => $this->input->post('id_golongan'),
				'id_sekolah' => $this->input->post('id_sekolah'),
			);
		$insert = $this->pegawai->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nip' => $this->input->post('nip'),
				'nama_pegawai' => $this->input->post('nama_pegawai'),
				'tgl_lahir' => $this->input->post('tgl_lahir'),
				'npwp' => $this->input->post('npwp'),
				'alamat_pegawai' => $this->input->post('alamat_pegawai'),
				'id_jabatan' => $this->input->post('id_jabatan'),
				'id_golongan' => $this->input->post('id_golongan'),
				'id_sekolah' => $this->input->post('id_sekolah'),

			);
		$this->pegawai->update(array('id_pegawai' => $this->input->post('id_pegawai')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->pegawai->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama_pegawai') == '')
		{

			$data['inputerror'][] = 'nama_pegawai';
			$data['error_string'][] = 'Nama pegawai Masih Kosong';
			$data['status'] = FALSE;
		}

		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
