<?php 
 
 
class Mutdat extends CI_Controller{
 
	function __construct(){
		parent::__construct();		
		$this->load->model('Model_mutdat');
		$this->load->model('Model_user');
		$this->load->helper(array('url','download'));
 		
	}
 
	function index(){
		$user['user'] = $this->Model_user->tampil_data()->result();
		$where = array('id_satker' => $this->session->userdata('id_satker'));
		$data['mutdat'] = $this->Model_mutdat->tampil_data($where, 'tb_mutdat')->result();
		$this->load->view('mutdat/v_tampil',$data , array('error' => ' ' ));
	}

	public function admin(){
		$data['mutdat'] = $this->Model_mutdat->tampil_admin()->result();
		$this->load->view('mutdat/v_admin',$data);
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
			$this->load->view('mutdat/v_tampil', $error);
		}else{
			$data = array('upload_data' => $this->upload->data());
			$this->load->view('mutdat/v_tampil', $data);
		}
	    
	    return $this->upload->data("file_name");
	}
 
	function tambah(){
		$user['user'] = $this->Model_user->tampil_data()->result();
		$this->load->view('mutdat/v_input',$user);
	}

	function hapus($id){
		$where = array('id' => $id);
		$this->Model_mutdat->hapus_data($where,'tb_mutdat');
		redirect('mutdat');
	}

	function edit($id){
		$where = array('id' => $id);
		$data['mutdat'] = $this->Model_mutdat->edit_data($where,'tb_mutdat')->result();
		$this->load->view('mutdat/v_edit',$data);
	}

	function update(){
		$where = $this->session->userdata('id_satker');
		$id = $this->input->post('id');
		$satker = $this->input->post('satker');
		$bulan = $this->input->post('bulan');
		$file = $this->_uploadImage();
	 
		$data = array(
			'id_satker' => $where,
			'satker' => $satker,
			'bulan' => $bulan,
			'file' => $file
			);
	 
		$where = array(
			'id' => $id
		);
	 
		$this->Model_mutdat->update_data($where,$data,'tb_mutdat');
		redirect('mutdat');
}

	function tambah_aksi(){
		$where = $this->session->userdata('id_satker');
		$satker = $this->input->post('satker');
		$bulan = $this->input->post('bulan');
		$file = $this->_uploadImage();
		
		$data = array(
			'id_satker' => $where,
			'satker' => $satker,
			'bulan' => $bulan,
			'file' => $file
		);
		$this->Model_mutdat->input_data($data,'tb_mutdat');
		redirect('Mutdat');
	}
	function download($id)
	{
		$data = $this->db->get_where('tb_mutdat',['id'=>$id])->row();
		force_download('uploads/'.$data->file,NULL);
	}

}