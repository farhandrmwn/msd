<?php 
 
 
class Rekap extends CI_Controller{
 
	function __construct(){
		parent::__construct();		
		$this->load->model('Model_rekap');
		$this->load->model('Model_user');
		$this->load->helper(array('url','download'));
 		
	}
 
	function index(){


	}

	public function admin(){
		$data['rekap'] = $this->Model_rekap->tampil_admin()->result();
		$this->load->view('rekap/v_admin',$data);
	}

	private function _uploadImage()
	{
	    $config['upload_path']          = './uploads/';
	    $config['allowed_types']        = 'xls|xlsx|xlsm';
	    // $config['max_width']            = 1024;
	    // $config['max_height']           = 768;

	    $this->load->library('upload', $config);
	    // if ($this->upload->do_upload('foto')) {
	    //     return $this->upload->data("file_name");
	    // }
	    if ( ! $this->upload->do_upload('berkas')){
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('rekap/v_tampil', $error);
		}else{
			$data = array('upload_data' => $this->upload->data());
			$this->load->view('rekap/v_tampil', $data);
		}
	    
	    return $this->upload->data("file_name");
	}
 
	function tambah(){
		$user['user'] = $this->Model_user->tampil_data()->result();
		$this->load->view('rekap/v_input',$user);
	}

	function hapus($id_rekap){
		$where = array('id_rekap' => $id_rekap);
		$this->Model_rekap->hapus_data($where,'tb_rekap');
		redirect('rekap/admin');
	}

	function edit($id_rekap){
		$where = array('id_rekap' => $id_rekap);
		$data['rekap'] = $this->Model_rekap->edit_data($where,'tb_rekap')->result();
		$this->load->view('rekap/v_edit',$data);
	}

	function update(){
		$id_rekap = $this->input->post('id_rekap');
		$file = $this->_uploadImage();
		$bulan = $this->input->post('bulan');
		$keterangan = $this->input->post('keterangan');
	 
		$data = array(
			'waktu' => $bulan,
			'file' => $file,
			'keterangan' => $keterangan
			);
	 
		$where = array(
			'id_rekap' => $id_rekap
		);
	 
		$this->Model_rekap->update_data($where,$data,'tb_rekap');
		redirect('rekap/admin');
}

	function tambah_aksi(){
		$file = $this->_uploadImage();
		$bulan = $this->input->post('bulan');
		$keterangan = $this->input->post('keterangan');
	 
		$data = array(
			'waktu' => $bulan,
			'file' => $file,
			'keterangan' => $keterangan
			);
		$this->Model_rekap->input_data($data,'tb_rekap');
		redirect('rekap/admin');
	}
	function download($id_rekap)
	{
		$data = $this->db->get_where('tb_rekap',['id_rekap'=>$id_rekap])->row();
		force_download('uploads/'.$data->file,NULL);
	}

}