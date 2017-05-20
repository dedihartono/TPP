<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {

	
	public function __construct(){

		parent::__construct();
		
			$this->load->helper('url');

			$this->load->model('mdl_jabatan','jabatan');
	}


	

	public function index()
	{
		$data['konten']="jabatan";

		$this->load->view('template',$data);
	}

	public function ajax_list()
	{
		
		$list = $this->jabatan->get_datatables();
		
		$data = array();
		
		$no = $_POST['start'];
		
		foreach ($list as $jabatan) {
			
			$no++;
			
			$row = array();
			$row[] = $no;
			$row[] = $jabatan->id_jabatan;
			$row[] = $jabatan->nama_jabatan;
			$row[] = $jabatan->nominal_awal;

			$row[] = 
					'<a class="btn btn-sm btn-primary" href="javascript:void(0)" 
						title="Ubah" onclick="edit_jabatan('."'".$jabatan->id_jabatan."'".')">
						<i class="glyphicon glyphicon-pencil"></i>
					</a>

				  	<a class="btn btn-sm btn-danger" href="javascript:void(0)" 
				  		title="Hapus" onclick="delete_jabatan('."'".$jabatan->id_jabatan."'".')">
				  		<i class="glyphicon glyphicon-trash"></i>
				  	</a>';
			
			$data[] = $row;
		}

			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->jabatan->count_all(),
							"recordsFiltered" => $this->jabatan->count_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->jabatan->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		//var_dump($data);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nama_jabatan' => $this->input->post('nama_jabatan'),
				'nominal_awal' => $this->input->post('nominal_awal'),
			);
		$insert = $this->jabatan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_jabatan' => $this->input->post('nama_jabatan'),
				'nominal_awal' => $this->input->post('nominal_awal'),
			);
		$this->jabatan->update(array('id_jabatan' => $this->input->post('id_jabatan')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->jabatan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama_jabatan') == '')
		{

			$data['inputerror'][] = 'nama_jabatan';
			$data['error_string'][] = 'Nama Jabatan Masih Kosong';
			$data['status'] = FALSE;
		}

		if($this->input->post('nominal_awal') == '')
		{
			$data['inputerror'][] = 'nominal_awal';
			$data['error_string'][] = 'Nominal Masih Kosong';
			$data['status'] = FALSE;
		}

		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

/*
	function _validate2()
	{
                $this->form_validation->set_error_delimiters('<div id="error">', '</div>');
		
		$this->form_validation->set_rules('nip', 'nip', 'required|numeric|max_length[4]|trim|required|xss_clean|callback_valid_id');
                $this->form_validation->set_rules('nama', 'nama', 'required|max_length[32]|trim|required|xss_clean');
                if ($this->form_validation->run() == TRUE){
	  	$data = array(
	  		'nip' => $this->input->post('nip'),
	  		'nama' => $this->input->post('nama')
	  				
	  	);
	  	$this->ds_mod2->create_data($data);
	  	redirect('ds_con2');
	}
        else {
                $this->index();
            
       }
    }

*/
}
