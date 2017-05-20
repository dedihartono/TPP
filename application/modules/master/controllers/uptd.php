<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uptd extends CI_Controller {

	
	public function __construct(){

		parent::__construct();
		
			$this->load->helper('url');

			$this->load->model('mdl_uptd','uptd');
	}


	

	public function index()
	{
		$data['konten']="uptd";

		$this->load->view('template',$data);
	}

	public function ajax_list()
	{
		
		$list = $this->uptd->get_datatables();
		
		$data = array();
		
		//$no = $_POST['start'];
		
		foreach ($list as $uptd) {
			
			//$no++;
			
			$row = array();
			//$row[] = $no;
			$row[] = $uptd->id_uptd;
			$row[] = $uptd->nm_uptd;
			$row[] = $uptd->alamat_uptd;
			
			$row[] = 
					'<a class="btn btn-sm btn-primary" href="javascript:void(0)" 
						title="Ubah" onclick="edit_uptd('."'".$uptd->id_uptd."'".')">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>

				  	<a class="btn btn-sm btn-danger" href="javascript:void(0)" 
				  		title="Hapus" onclick="delete_uptd('."'".$uptd->id_uptd."'".')">
				  		<i class="glyphicon glyphicon-trash"></i>
				  	</a>';
			
			$data[] = $row;
		}

			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->uptd->count_all(),
							"recordsFiltered" => $this->uptd->count_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->uptd->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nm_uptd' => $this->input->post('nm_uptd'),
				'alamat_uptd' => $this->input->post('alamat_uptd'),
			);
		$insert = $this->uptd->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nm_uptd' => $this->input->post('nm_uptd'),
				'alamat_uptd' => $this->input->post('alamat_uptd'),
			);
		$this->uptd->update(array('id_uptd' => $this->input->post('id_uptd')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->uptd->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nm_uptd') == '')
		{

			$data['inputerror'][] = 'nm_uptd';
			$data['error_string'][] = 'nm_uptd uptd Masih Kosong';
			$data['status'] = FALSE;
		}
/*
		if($this->input->post('alamat_uptd') == '')
		{

			$data['inputerror'][] = 'alamat_uptd';
			$data['error_string'][] = 'alamat_uptd uptd Masih Kosong';
			$data['status'] = FALSE;
		}
*/
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
