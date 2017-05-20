<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Golongan extends CI_Controller {

	
	public function __construct(){

		parent::__construct();
		
			$this->load->helper('url');

			$this->load->model('mdl_golongan','golongan');
	}


	

	public function index()
	{
		$data['konten']="golongan";

		$this->load->view('template',$data);
	}

	public function ajax_list()
	{
		
		$list = $this->golongan->get_datatables();
		
		$data = array();
		
		$no = $_POST['start'];
		
		foreach ($list as $golongan) {
			
			$no++;
			
			$row = array();
			$row[] = $no;
			$row[] = $golongan->id_golongan;
			$row[] = $golongan->nama_golongan;
			$row[] = $golongan->pajak_pph21;

			$row[] = 
					'<a class="btn btn-sm btn-primary" href="javascript:void(0)" 
						title="Ubah" onclick="edit_golongan('."'".$golongan->id_golongan."'".')">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>

				  	<a class="btn btn-sm btn-danger" href="javascript:void(0)" 
				  		title="Hapus" onclick="delete_golongan('."'".$golongan->id_golongan."'".')">
				  		<i class="glyphicon glyphicon-trash"></i>
				  	</a>';
			
			$data[] = $row;
		}

			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->golongan->count_all(),
							"recordsFiltered" => $this->golongan->count_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->golongan->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nama_golongan' => $this->input->post('nama_golongan'),
				'pajak_pph21' => $this->input->post('pajak_pph21'),
			);
		$insert = $this->golongan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_golongan' => $this->input->post('nama_golongan'),
				'pajak_pph21' => $this->input->post('pajak_pph21'),
			);
		$this->golongan->update(array('id_golongan' => $this->input->post('id_golongan')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->golongan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama_golongan') == '')
		{

			$data['inputerror'][] = 'nama_golongan';
			$data['error_string'][] = 'Nama golongan Masih Kosong';
			$data['status'] = FALSE;
		}

		if($this->input->post('pajak_pph21') == '')
		{
			$data['inputerror'][] = 'pajak_pph21';
			$data['error_string'][] = 'Pajak PPH21 Masih Kosong';
			$data['status'] = FALSE;
		}

		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
