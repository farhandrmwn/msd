<?php 


class RD_pns_polri extends CI_Controller{

	function __construct(){
		parent::__construct();		
		$this->load->model('Model_rdpnspolri');
		$this->load->model('Model_rdpolri');
		$this->load->model('Model_user');
		$this->load->helper('url');
 
	}
 
	function index(){
		$where = $this->session->userdata('id_satker');
		
		$satker = $this->db->query("SELECT * FROM tb_user WHERE id_satker = '$where' ")->result(); 
		foreach ($satker as $a) {
			$sat = $a->satker;
		}
		
		$b = $this->input->post('bulan');
		$t = $this->input->post('tahun');

		$gol4_kuat = $this->db->query("SELECT * FROM tb_personilpns WHERE pangkat = '4 ' AND bulan like '%".$b.$t."%' ")->num_rows(); 
		$gol3_kuat = $this->db->query("SELECT * FROM tb_personilpns WHERE pangkat = '3' AND bulan like '%".$b.$t."%' ")->num_rows(); 
		$gol2_kuat = $this->db->query("SELECT * FROM tb_personilpns WHERE pangkat = '2' AND bulan like '%".$b.$t."%'  ")->num_rows(); 
		$jml_kuat = $this->db->query("SELECT * FROM tb_personilpns WHERE bulan like '%".$b.$t."%' ")->num_rows();

		$wherejml = "id_satker = '$where' and bulan like '%".$b.$t."%' ";
		$wheregol4 = "id_satker = '$where' and pangkat = '4' and bulan like '%".$b.$t."%' ";
		$wheregol3 = "id_satker = '$where' and pangkat = '3' and bulan like '%".$b.$t."%' ";
		$wheregol2 = "id_satker = '$where' and pangkat = '2' and bulan like '%".$b.$t."%'  ";

		$gol4_pot = $this->Model_rdpolri->hitungpot($wheregol4,'tb_personilpns');
		if ($gol4_pot == NULL) {
			$gol4_pot = '0';
		}else{
			$gol4_pot;
		}
		$gol3_pot = $this->Model_rdpolri->hitungpot($wheregol3,'tb_personilpns');
		if ($gol3_pot == NULL) {
			$gol3_pot = '0';
		}else{
			$gol3_pot;
		}
		$gol2_pot = $this->Model_rdpolri->hitungpot($wheregol2,'tb_personilpns');
		if ($gol2_pot == NULL) {
			$gol2_pot = '0';
		}else{
			$gol2_pot;
		}
		$total_jmlhpot = $this->Model_rdpolri->hitungpot($wherejml,'tb_personilpns');
		$bulan = date('my');

		$data = array(
			'id_satker' => $where,
			'satker' => $sat,
			'gol4_kuat' => $gol4_kuat,
			'gol4_pot' => $gol4_pot,
			'gol3_kuat' => $gol3_kuat,
			'gol3_pot' => $gol3_pot,
			'gol2_kuat' => $gol2_kuat,
			'gol2_pot' => $gol2_pot,
			'jml_kuat' => $jml_kuat,
			'jml_pot' => $total_jmlhpot,
			'tot_kuat' => 0,
			'tot_pot' => 0,
			'ket' => '-',
			'bulan' => $bulan
		);
		$waktu = $this->db->query("SELECT * FROM tb_potongan_pns ORDER BY ID DESC LIMIT 1")->result();
             foreach ($waktu as $a) {
              $cek =  $a->bulan;
			  $s = substr($cek, -4,4);
             }
             if (@$cek == null) {
            	$cek = '';
            }else{
            	$cek;
            }
            if (@$s == null) {
            	$s = '';
            }else{
            	$s;
            }

		
		$row = $this->db->query("SELECT * FROM tb_potongan_pns")->num_rows();
		$row2 = $this->db->query("SELECT * FROM tb_personilpns")->num_rows();

        $int = (int)$s;

        $skg = (int)$bulan;

        if ($cek == '') {
			$this->db->insert('tb_potongan_pns',$data);
		}else if ($int < $skg) {
			$this->db->insert('tb_potongan_pns',$data);
        }else if ($int == $skg) {
			if ($row2 == '0') {
				echo '';
			}else if ($row == '0') {
		   		 $this->db->insert('tb_potongan_pns',$data);
			}else{
				
				$array = array('id_satker' => $where, 'bulan like' => '%'.$s.'%');
				$this->db->where($array); 
				$this->db->update('tb_potongan_pns', $data);
			}  
		}

		$user['user'] = $this->Model_user->tampil_data()->result();
	$dmn = array('id_satker' => $this->session->userdata('id_satker'),'bulan'=> $b.$t );
		$data['total_gol4kuat'] = $this->Model_rdpnspolri->hitunggol4kuat($dmn,'tb_potongan_pns');
		$data['total_gol4pot'] = $this->Model_rdpnspolri->hitunggol4pot($dmn,'tb_potongan_pns');
		$data['total_gol3kuat'] = $this->Model_rdpnspolri->hitunggol3kuat($dmn,'tb_potongan_pns');
		$data['total_gol3pot'] = $this->Model_rdpnspolri->hitunggol3pot($dmn,'tb_potongan_pns');
		$data['total_gol2kuat'] = $this->Model_rdpnspolri->hitunggol2kuat($dmn,'tb_potongan_pns');
		$data['total_gol2pot'] = $this->Model_rdpnspolri->hitunggol2pot($dmn,'tb_potongan_pns');
		$data['total_jmlhkuat'] = $this->Model_rdpnspolri->hitungjmlkuat($dmn,'tb_potongan_pns');
		$data['total_jmlhpot'] = $this->Model_rdpnspolri->hitungjmlpot($dmn,'tb_potongan_pns');
		

		$stk = $this->session->userdata('id_satker');
		$data['rdpnspolri'] = $this->db->query("SELECT * FROM tb_potongan_pns WHERE id_satker = '$stk' AND bulan like '%".$b.$t."%' ")->result();
		$this->load->view('rdpnspolri/v_tampil',$data);
	}

	public function pilih()
	{
		$this->load->view("rdpnspolri/v_pilih");
	}

	public function admin(){
		$data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
       	$satker = $this->input->post('satker');
		$b = $this->input->post('bulan');
		$t = $this->input->post('tahun');

		$data['rdpnspolri'] = $this->db->query("SELECT * FROM tb_potongan_pns WHERE id_satker = '$satker' AND bulan like '%".$b.$t."%' ")->result();

		$data['total_gol4kuat'] = $this->Model_rdpnspolri->hitunggol4kuatadmin();
		$data['total_gol4pot'] = $this->Model_rdpnspolri->hitunggol4potadmin();
		$data['total_gol3kuat'] = $this->Model_rdpnspolri->hitunggol3kuatadmin();
		$data['total_gol3pot'] = $this->Model_rdpnspolri->hitunggol3potadmin();
		$data['total_gol2kuat'] = $this->Model_rdpnspolri->hitunggol2kuatadmin();
		$data['total_gol2pot'] = $this->Model_rdpnspolri->hitunggol2potadmin();
		$data['total_jmlhkuat'] = $this->Model_rdpnspolri->hitungjmlkuatadmin();
		$data['total_jmlhpot'] = $this->Model_rdpnspolri->hitungjmlpotadmin();


		$this->load->view('rdpnspolri/v_admin',$data);
	}
 
	function tambah(){
		$this->load->view('rdpnspolri/v_input');
	}

	function hapus($id){
		$where = array('id' => $id);
		$this->Model_rdpnspolri->hapus_data($where,'tb_potongan_pns');
		redirect('RD_pns_polri');
	}

	function edit($id){
		$where = array('id' => $id);
		$data['rdpnspolri'] = $this->Model_rdpnspolri->edit_data($where,'tb_potongan_pns')->result();
		$this->load->view('rdpnspolri/v_edit',$data);
	}
	function update(){
		$where = $this->session->userdata('id_satker');
		$id = $this->input->post('id');
		$satker = $this->session->userdata('satker');
		$gol4_kuat = $this->input->post('gol4_kuat');
		$gol4_pot = $this->input->post('gol4_pot');	
		$gol3_kuat = $this->input->post('gol3_kuat');
		$gol3_pot = $this->input->post('gol3_pot');
		$gol2_kuat = $this->input->post('gol2_kuat');
		$gol2_pot = $this->input->post('gol2_pot');
		$jml_kuat = $this->input->post('jml_kuat');
		$jml_pot = $this->input->post('jml_pot');
		$ket = $this->input->post('ket');
		$bulan = $this->input->post('bulan');
 
		$data = array(
			'id_satker' => $where,
			'satker' => $satker,
			'gol4_kuat' => $gol4_kuat,
			'gol4_pot' => $gol4_pot,
			'gol3_kuat' => $gol3_kuat,
			'gol3_pot' => $gol3_pot,
			'gol2_kuat' => $gol2_kuat,
			'gol2_pot' => $gol2_pot,
			'jml_kuat' => $jml_kuat,
			'jml_pot' => $jml_pot,
			'ket' => $ket,
			'bulan' => $bulan
			);
	 
		$where = array(
			'id' => $id
		);
	 
		$this->Model_rdpnspolri->update_data($where,$data,'tb_potongan_pns');
		redirect('RD_pns_polri');
}

	function tambah_aksi(){
		$where = $this->session->userdata('id_satker');
		$satker = $this->session->userdata('satker');
		$gol4_kuat = $this->input->post('gol4_kuat');
		$gol4_pot = $this->input->post('gol4_pot');	
		$gol3_kuat = $this->input->post('gol3_kuat');
		$gol3_pot = $this->input->post('gol3_pot');
		$gol2_kuat = $this->input->post('gol2_kuat');
		$gol2_pot = $this->input->post('gol2_pot');
		$jml_kuat = $this->input->post('jml_kuat');
		$jml_pot = $this->input->post('jml_pot');
		$ket = $this->input->post('ket');
		$bulan = $this->input->post('bulan');
 
		$data = array(
			'id_satker' => $where,
			'satker' => $satker,
			'gol4_kuat' => $gol4_kuat,
			'gol4_pot' => $gol4_pot,
			'gol3_kuat' => $gol3_kuat,
			'gol3_pot' => $gol3_pot,
			'gol2_kuat' => $gol2_kuat,
			'gol2_pot' => $gol2_pot,
			'jml_kuat' => $jml_kuat,
			'jml_pot' => $jml_pot,
			'ket' => $ket,
			'bulan' => $bulan
			);
		$this->Model_rdpnspolri->input_data($data,'tb_potongan_pns');
		redirect('RD_pns_polri');
	}
}

?>