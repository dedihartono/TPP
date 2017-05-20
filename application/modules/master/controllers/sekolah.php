<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sekolah extends CI_Controller {

	
	public function __construct(){

		parent::__construct();
		
			$this->load->helper('url');

			$this->load->model('mdl_sekolah', 'sekolah');

			$this->load->model('mdl_uptd', 'uptd');

	}


	

	public function index()
	{
		$data['konten']="sekolah";
		$data['uptd']=$this->uptd->list_uptd();


		$this->load->view('template',$data);
	}

	public function ajax_list()
	{
		
		$list = $this->sekolah->get_datatables();
		
		$data = array();
		
		//$no = $_POST['start'];
		
		foreach ($list as $sekolah) {
			
			//$no++;
			
			$row = array();
			//$row[] = $no;
			$row[] = $sekolah->id_sekolah;
			$row[] = $sekolah->nm_sekolah;
			$row[] = $sekolah->alamat_sekolah;
			$row[] = $sekolah->nm_uptd;
			

			$row[] = 
					'<a class="btn btn-sm btn-primary" href="javascript:void(0)" 
						title="Ubah" onclick="edit_sekolah('."'".$sekolah->id_sekolah."'".')">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>

				  	<a class="btn btn-sm btn-danger" href="javascript:void(0)" 
				  		title="Hapus" onclick="delete_sekolah('."'".$sekolah->id_sekolah."'".')">
				  		<i class="glyphicon glyphicon-trash"></i>
				  	</a>';
			
			$data[] = $row;
		}

			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->sekolah->count_all(),
							"recordsFiltered" => $this->sekolah->count_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output);
	}

	public function ajax_uptd($id){
		
		$data = $this->uptd->get_by_id($id);

			echo json_encode($data);
	}

	public function ajax_edit($id)
	{
		$data = $this->sekolah->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nm_sekolah' => $this->input->post('nm_sekolah'),
				'alamat_sekolah' => $this->input->post('alamat_sekolah'),
				'id_uptd' => $this->input->post('id_uptd'),
			);
		$insert = $this->sekolah->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(

				'nm_sekolah' => $this->input->post('nm_sekolah'),
				'alamat_sekolah' => $this->input->post('alamat_sekolah'),
				'id_uptd' => $this->input->post('id_uptd'),
			);
		$this->sekolah->update(array('id_sekolah' => $this->input->post('id_sekolah')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->sekolah->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nm_sekolah') == '')
		{

			$data['inputerror'][] = 'nm_sekolah';
			$data['error_string'][] = 'nm_sekolah sekolah Masih Kosong';
			$data['status'] = FALSE;
		}
/*
		if($this->input->post('alamat_sekolah') == '')
		{

			$data['inputerror'][] = 'alamat_sekolah';
			$data['error_string'][] = 'alamat_sekolah sekolah Masih Kosong';
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
