<?php 
 
 
class Informasi extends CI_Controller{
 
	function __construct(){
		parent::__construct();		
		$this->load->model('Model_informasi');
		$this->load->model('Model_user');
		$this->load->helper('url');
		date_default_timezone_set("Asia/Jakarta");
 		
	}
 
	public function index(){
		$user['user'] = $this->Model_user->tampil_data()->result();
		$where = array('satker' => $this->session->userdata('satker'));
		$query = "SELECT * FROM tb_info WHERE satker = ? OR satker = ? ORDER BY id DESC";
		$data['informasi'] = $this->db->query($query,array($where, 'SEMUA SATKER'))->result();
		$this->load->view('informasi/v_tampil',$data);
	}

	public function admin(){
		$data['informasi'] = $this->Model_informasi->tampil_admin()->result();
		$this->load->view('informasi/v_admin',$data);
	}

	public function show(){
		$where = $this->input->get();
		$data['informasi'] = $this->Model_informasi->tampil_admin()->result();
		$this->load->view('informasi/v_admin',$data);
	}
 
	function tambah(){
		$user['user'] = $this->Model_user->tampil_data()->result();
		$this->load->view('informasi/v_input',$user);
	}

	function hapus($id){
		$where = array('id' => $id);
		$this->Model_informasi->hapus_data($where,'tb_info');
		redirect('informasi/admin');
	}

	function edit($id){
		$data['user'] = $this->Model_user->tampil_data()->result();
		$where = array('id' => $id);
		$data['informasi'] = $this->Model_informasi->edit_data($where,'tb_info')->result();

		$this->load->view('informasi/v_edit',$data);
	}

	function update(){
		$id = $this->input->post('id');
		$satker = $this->input->post('satker');
		$judul = $this->input->post('judul');
		$deskripsi = $this->input->post('deskripsi');
		$waktu = date("Y-m-d h:i:sa");	
 
		$data = array(
			'satker' => $satker,
			'judul' => $judul,
			'deskripsi' => $deskripsi,
			'waktu' => $waktu
			);
	 
		$where = array(
			'id' => $id
		);
	 
		$this->Model_informasi->update_data($where,$data,'tb_info');
		redirect('informasi/admin');
}

	function tambah_aksi(){
		$satker = $this->input->post('satker');
		$judul = $this->input->post('judul');
		$deskripsi = $this->input->post('deskripsi');
		$waktu = date("Y-m-d h:i:sa");	
 
		$data = array(
			'satker' => $satker,
			'judul' => $judul,
			'deskripsi' => $deskripsi,
			'waktu' => $waktu
			);
		$this->Model_informasi->input_data($data,'tb_info');
		redirect('informasi/admin');
	}

}