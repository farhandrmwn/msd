<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('Model_user');
		$this->load->helper('url');

		// if(!$this->session->userdata('logged_in'))
  //       {
  //           $pemberitahuan = "<div class='alert alert-warning'>Anda harus login dulu </div>";
  //           $this->session->set_flashdata('pemberitahuan', $pemberitahuan);
  //           redirect('login');
  //       }

	}

	function index()
	{
        $session_data = $this->session->userdata('logged_in');
		$sesi['username'] = $session_data['username'];
		$sesi['konfigurasi'] = $this->Model_user->tampil_data()->result();
		$this->load->view('v_user', $sesi);
	}

	public function admin(){
		$data['user'] = $this->Model_user->tampil_data()->result();
		$this->load->view('user/v_admin',$data);
	}

	function tambah(){
		$this->load->view('user/v_input');
	}

	function tambah_aksi(){
		$satker = $this->input->post('satker');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$level = $this->input->post('level');
		
		$data = array(
			'satker' => $satker,
			'username' => $username,
			'password' => $password,
			'level' => $level
		);
		$this->Model_user->input_data($data,'tb_user');
		redirect('user/admin');
	}

	function hapus($id){
		$where = array('id_satker' => $id);
		$this->Model_user->hapus_data($where,'tb_user');
		redirect('user/admin');
	}

	function konfigurasi($id){
		$where = array('id_satker' => $id);
		$data['konfigurasi'] = $this->Model_user->edit_data($where,'tb_user')->result();
		$this->load->view('user/konfigurasi.php', $data);
	}
	function update(){
		$id_satker = $this->input->post('id_satker');
		$nama_kabag = $this->input->post('nama_kabag');
		$jabatan_kabag = $this->input->post('jabatan_kabag');
		$nrp_kabag = $this->input->post('nrp_kabag');	
		$nama_kasikeu = $this->input->post('nama_kasikeu');
		$jabatan_kasikeu = $this->input->post('jabatan_kasikeu');
		$nrp_kasikeu = $this->input->post('nrp_kasikeu');
		$nama_kasi = $this->input->post('nama_kasi');
		$jabatan_kasi = $this->input->post('jabatan_kasi');
		$nrp_kasi = $this->input->post('nrp_kasi');
		$nama_kepala = $this->input->post('nama_kepala');
		$jabatan_kepala = $this->input->post('jabatan_kepala');
		$nrp_kepala = $this->input->post('nrp_kepala');
		$nama_keuangan = $this->input->post('nama_keuangan');
		$jabatan_keuangan = $this->input->post('jabatan_keuangan');
		$nrp_keuangan = $this->input->post('nrp_keuangan');
		$alamat = $this->input->post('alamat');
 
		$data = array(
			'nama_kabag' => $nama_kabag,
			'jabatan_kabag' => $jabatan_kabag,
			'nrp_kabag' => $nrp_kabag,
			'nama_kasikeu' => $nama_kasikeu,
			'jabatan_kasikeu' => $jabatan_kasikeu,
			'nrp_kasikeu' => $nrp_kasikeu,
			'nama_kasi' => $nama_kasi,
			'jabatan_kasi' => $jabatan_kasi,
			'nrp_kasi' => $nrp_kasi,
			'nama_kepala' => $nama_kepala,
			'jabatan_kepala' => $jabatan_kepala,
			'nrp_kepala' => $nrp_kepala,
			'nama_keuangan' => $nama_keuangan,
			'jabatan_keuangan' => $jabatan_keuangan,
			'nrp_keuangan' => $nrp_keuangan,
			'alamat' => $alamat
			);
			$where = array(
				'id_satker' => $id_satker
			);	
		$this->Model_user->update_data($where,$data,'tb_user');
		redirect('user');
	}

}

?>