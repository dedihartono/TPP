<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mdl_hitung extends CI_Model {

	var $table = 'tb_pegawai';
	var $table1 = 'tb_hitung';
	var $table2 = 'tb_golongan';
	var $table3 = 'tb_jabatan';
	
	var $column_order = array(null, null, null, null); //set column field database for datatable orderable
	var $column_search = array('nama_pegawai', 'nama_jabatan', 'nama_golongan'); //set column field database for datatable searchable 
	//var $order = array('id_hitung' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->select('TRUNCATE((nominal_awal*kehadiran)/100,0) AS nominal_kehadiran , 
			TRUNCATE ((nominal_awal*pajak_pph21)/100,0) AS pajak_golongan,
				TRUNCATE((((nominal_awal*pajak_pph21)/100)*denda_pajak)/100,0) AS pajak_denda,
					(TRUNCATE((nominal_awal*pajak_pph21)/100,0) +TRUNCATE ((TRUNCATE((nominal_awal*pajak_pph21)/100,0)*denda_pajak)/100,0)) AS jumlah_pajak,
						(TRUNCATE((nominal_awal*kehadiran)/100,0) - (TRUNCATE((nominal_awal*pajak_pph21)/100,0) + TRUNCATE((TRUNCATE((nominal_awal*pajak_pph21)/100,0)*denda_pajak)/100,0))) AS jumlah_bersih,	
			nama_pegawai, nip, npwp, nama_jabatan, nominal_awal, kehadiran, nama_golongan, pajak_pph21, denda_pajak');
	

		$this->db->from($this->table);

		$this->db->join($this->table1, 'tb_hitung.id_pegawai = tb_pegawai.id_pegawai', 'right');

		$this->db->join($this->table2, 'tb_golongan.id_golongan = tb_pegawai.id_golongan', 'left');

		$this->db->join($this->table3, 'tb_jabatan.id_jabatan = tb_pegawai.id_jabatan', 'left');

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_hitung',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_hitung', $id);
		$this->db->delete($this->table);
	}

}
