<?php 


class Rekap_Rumdin_Pns extends CI_Controller{

	function __construct(){
		parent::__construct();		
		$this->load->model('Model_rdpnspolri');
		$this->load->model('Model_user');
		$this->load->model('Model_rdpolri');
		$this->load->helper('url');
	}
 function index(){
		$b = $this->input->post('bulan');
		$t = $this->input->post('tahun');

		$gol4_kuat = $this->db->query("SELECT * FROM tb_personilpns WHERE pangkat = '4 ' AND bulan like '%".$b.$t."%' ")->num_rows(); 
		$gol3_kuat = $this->db->query("SELECT * FROM tb_personilpns WHERE pangkat = '3' AND bulan like '%".$b.$t."%' ")->num_rows(); 
		$gol2_kuat = $this->db->query("SELECT * FROM tb_personilpns WHERE pangkat = '2' AND bulan like '%".$b.$t."%'  ")->num_rows(); 
		$jml_kuat = $this->db->query("SELECT * FROM tb_personilpns WHERE bulan like '%".$b.$t."%' ")->num_rows();

		$wherejml = "bulan like '%".$b.$t."%' ";
		$wheregol4 = "pangkat = '4' and bulan like '%".$b.$t."%' ";
		$wheregol3 = "pangkat = '3' and bulan like '%".$b.$t."%' ";
		$wheregol2 = "pangkat = '2' and bulan like '%".$b.$t."%'  ";

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
		
		$user['user'] = $this->Model_user->tampil_data()->result();
		$dmn = array('bulan'=> $b.$t );
		$data['total_gol4kuat'] = $this->Model_rdpnspolri->hitunggol4kuat($dmn,'tb_potongan_pns');
		$data['total_gol4pot'] = $this->Model_rdpnspolri->hitunggol4pot($dmn,'tb_potongan_pns');
		$data['total_gol3kuat'] = $this->Model_rdpnspolri->hitunggol3kuat($dmn,'tb_potongan_pns');
		$data['total_gol3pot'] = $this->Model_rdpnspolri->hitunggol3pot($dmn,'tb_potongan_pns');
		$data['total_gol2kuat'] = $this->Model_rdpnspolri->hitunggol2kuat($dmn,'tb_potongan_pns');
		$data['total_gol2pot'] = $this->Model_rdpnspolri->hitunggol2pot($dmn,'tb_potongan_pns');
		$data['total_jmlhkuat'] = $this->Model_rdpnspolri->hitungjmlkuat($dmn,'tb_potongan_pns');
		$data['total_jmlhpot'] = $this->Model_rdpnspolri->hitungjmlpot($dmn,'tb_potongan_pns');
		

		$data['rdpnspolri'] = $this->db->query("SELECT * FROM tb_potongan_pns,tb_user WHERE tb_potongan_pns.id_satker = tb_user.id_satker AND tb_potongan_pns.bulan like '%".$b.$t."%' ")->result();
		$this->load->view('rekap_rumdin/v_tampil_data_pnspolri',$data);
	}
	
}

?>