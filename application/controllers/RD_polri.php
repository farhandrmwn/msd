<?php 


class RD_polri extends CI_Controller{

	function __construct(){
		parent::__construct();		
		$this->load->model('Model_rdpolri');
		$this->load->model('Model_user');
		$this->load->helper('url');
		$this->load->model('Model_rdpnspolri');
 
	}
 
	function index(){
		$where = $this->session->userdata('id_satker');
		
		$satker = $this->db->query("SELECT * FROM tb_user WHERE id_satker = '$where' ")->result(); 
		foreach ($satker as $a) {
			$sat = $a->satker;
		}

		$b = $this->input->post('bulan');
		$t = $this->input->post('tahun');

		$pamen_kuat = $this->db->query("SELECT * FROM tb_personilpolri WHERE pangkat IN ('10','11','12')  AND bulan like '%".$b.$t."%'  ")->num_rows(); 
		$pama_kuat = $this->db->query("SELECT * FROM tb_personilpolri WHERE pangkat IN ('7','8','9')  AND bulan like '%".$b.$t."%'  ")->num_rows(); 
		$bintara_kuat = $this->db->query("SELECT * FROM tb_personilpolri WHERE pangkat IN ('1','2','3','4','5','6')  AND bulan like '%".$b.$t."%'  ")->num_rows(); 
		$jml_kuat = $this->db->query("SELECT * FROM tb_personilpolri WHERE  bulan like '%".$b.$t."%' ")->num_rows();

		$wherejml = "id_satker = '$where' and bulan like '%".$b.$t."%' ";
		$wherepamen = "id_satker = '$where' and pangkat in ('10','11','12') and bulan like '%".$b.$t."%' ";
		$wherepama = "id_satker = '$where' and pangkat in ('7','8','9') and bulan like '%".$b.$t."%' ";
		$wherebintara = "id_satker = '$where' and pangkat in ('1','2','3','4','5','6') and bulan like '%".$b.$t."%' ";

		$pamen_pot = $this->Model_rdpolri->hitungpot($wherepamen,'tb_personilpolri');
		if ($pamen_pot == NULL) {
			$pamen_pot = '0';
		}else{
			$pamen_pot;
		}
		$pama_pot = $this->Model_rdpolri->hitungpot($wherepama,'tb_personilpolri');
		if ($pama_pot == NULL) {
			$pama_pot = '0';
		}else{
			$pama_pot;
		}
		$bintara_pot = $this->Model_rdpolri->hitungpot($wherebintara,'tb_personilpolri');
		if ($pamen_pot == NULL) {
			$pama_pot = '0';
		}else{
			$pama_pot;
		}
		$total_jmlhpot = $this->Model_rdpolri->hitungpot($wherejml,'tb_personilpolri');
		$bulan = date('my');

		$data = array(
			'id_satker' => $where,
			'satker' => $sat,
			'pamen_kuat' => $pamen_kuat,
			'pamen_pot' => $pamen_pot,
			'pama_kuat' => $pama_kuat,
			'pama_pot' => $pama_pot,
			'bintara_kuat' => $bintara_kuat,
			'bintara_pot' => $bintara_pot,
			'jml_kuat' => $jml_kuat,
			'jml_pot' => $total_jmlhpot,
			'tot_kuat' => 0,
			'tot_pot' => 0,
			'ket' => 0,
			'bulan' => $bulan
		);
		$waktu = $this->db->query("SELECT * FROM tb_potongan_polri ORDER BY ID DESC LIMIT 1")->result();
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

		$row = $this->db->query("SELECT * FROM tb_potongan_polri")->num_rows();
		$row2 = $this->db->query("SELECT * FROM tb_personilpolri")->num_rows();


        $int = (int)$s;

        $skg = (int)$bulan;



		if ($cek == '') {
			$this->db->insert('tb_potongan_polri',$data);
		}else if ($int < $skg) {
			$this->db->insert('tb_potongan_polri',$data);
        }else if ($int == $skg) {
			if ($row2 == '0') {
				echo '';
			}else if ($row == '0') {
		   		 $this->db->insert('tb_potongan_polri',$data);
			}else{
				
				$array = array('id_satker' => $where, 'bulan like' => '%'.$s.'%');
				$this->db->where($array); 
				$this->db->update('tb_potongan_polri', $data);
			}  
		}

		$user['user'] = $this->Model_user->tampil_data()->result();
		$dmn = array('id_satker' => $this->session->userdata('id_satker'),'bulan'=> $b.$t );
		$data['total_pmnkuat'] = $this->Model_rdpolri->hitungpmnkuat($dmn,'tb_potongan_polri');
		$data['total_pmnpot'] = $this->Model_rdpolri->hitungpmnpot($dmn,'tb_potongan_polri');
		$data['total_pmkuat'] = $this->Model_rdpolri->hitungpmkuat($dmn,'tb_potongan_polri');
		$data['total_pmpot'] = $this->Model_rdpolri->hitungpmpot($dmn,'tb_potongan_polri');
		$data['total_bntrkuat'] = $this->Model_rdpolri->hitungbntrkuat($dmn,'tb_potongan_polri');
		$data['total_bntrpot'] = $this->Model_rdpolri->hitungbntrpot($dmn,'tb_potongan_polri');
		$data['total_jmlkuat'] = $this->Model_rdpolri->hitungjmlkuat($dmn,'tb_potongan_polri');
		$data['total_jmlhpot'] = $this->Model_rdpolri->hitungjmlpot($dmn,'tb_potongan_polri');
		$data['total_gol4kuat'] = $this->Model_rdpnspolri->hitunggol4kuat($dmn,'tb_potongan_pns');
		$data['total_gol4pot'] = $this->Model_rdpnspolri->hitunggol4pot($dmn,'tb_potongan_pns');
		$data['total_gol3kuat'] = $this->Model_rdpnspolri->hitunggol3kuat($dmn,'tb_potongan_pns');
		$data['total_gol3pot'] = $this->Model_rdpnspolri->hitunggol3pot($dmn,'tb_potongan_pns');
		$data['total_gol2kuat'] = $this->Model_rdpnspolri->hitunggol2kuat($dmn,'tb_potongan_pns');
		$data['total_gol2pot'] = $this->Model_rdpnspolri->hitunggol2pot($dmn,'tb_potongan_pns');
		$data['total_jmlhkuat'] = $this->Model_rdpnspolri->hitungjmlkuat($dmn,'tb_potongan_pns');
		$data['total_jmlhpot'] = $this->Model_rdpnspolri->hitungjmlpot($dmn,'tb_potongan_polri');




		$stk = $this->session->userdata('id_satker');
		$data['rdpolri'] = $this->db->query("SELECT * FROM tb_potongan_polri WHERE id_satker = '$stk' AND bulan like '%".$b.$t."%' ")->result();
		$this->load->view('rdpolri/v_tampil',$data);
	}

	public function pilih()
	{

		

		// INI BELUM DITAMBAH VALIDASI BULAN !
		


		$this->load->view('rdpolri/pilih');
		
	}

	public function pilihan()
	{
		$this->load->view('rdpolri/v_pilih');
		
	}

	public function admin(){
       	$data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
       	$filtersatker = $this->input->post('satker');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		if(empty($filtersatker)){
			$satker = '';
		}
		if(empty($bulan)){
			$bulan = '';
		}
		if(empty($tahun)){
			$tahun = '';
		}
		$data['filtersatker'] = $filtersatker;
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$bln = $bulan.' '.$tahun;

		$data['rdpolri'] = $this->db->query("SELECT * FROM tb_potongan_polri WHERE id_satker = '$filtersatker' AND bulan = '$bln' ")->result();

		$where = array('id_satker' => $filtersatker, 'bulan' => $bln);
		$data['total_pmnkuat'] = $this->Model_rdpolri->hitungpmnkuat($where,'tb_potongan_polri');
		$data['total_pmnpot'] = $this->Model_rdpolri->hitungpmnpot($where,'tb_potongan_polri');
		$data['total_pmkuat'] = $this->Model_rdpolri->hitungpmkuat($where,'tb_potongan_polri');
		$data['total_pmpot'] = $this->Model_rdpolri->hitungpmpot($where,'tb_potongan_polri');
		$data['total_bntrkuat'] = $this->Model_rdpolri->hitungbntrkuat($where,'tb_potongan_polri');
		$data['total_bntrpot'] = $this->Model_rdpolri->hitungbntrpot($where,'tb_potongan_polri');
		$data['total_jmlhkuat'] = $this->Model_rdpolri->hitungjmlkuat($where,'tb_potongan_polri');
		$data['total_jmlhpot'] = $this->Model_rdpolri->hitungjmlpot($where,'tb_potongan_polri');
		$data['total_gol4kuat'] = $this->Model_rdpnspolri->hitunggol4kuat($where,'tb_potongan_pns');
		$data['total_gol4pot'] = $this->Model_rdpnspolri->hitunggol4pot($where,'tb_potongan_pns');
		$data['total_gol3kuat'] = $this->Model_rdpnspolri->hitunggol3kuat($where,'tb_potongan_pns');
		$data['total_gol3pot'] = $this->Model_rdpnspolri->hitunggol3pot($where,'tb_potongan_pns');
		$data['total_gol2kuat'] = $this->Model_rdpnspolri->hitunggol2kuat($where,'tb_potongan_pns');
		$data['total_gol2pot'] = $this->Model_rdpnspolri->hitunggol2pot($where,'tb_potongan_pns');
		$data['total_jmlhkuat'] = $this->Model_rdpnspolri->hitungjmlkuat($where,'tb_potongan_pns');
		$data['total_jmlhpot'] = $this->Model_rdpnspolri->hitungjmlpot($where,'tb_potongan_polri');
		$this->load->view('rdpolri/v_admin',$data);
	}
 
	function tambah(){
		$user['user'] = $this->Model_user->tampil_data()->result();
		$this->load->view('rdpolri/v_input', $user);
	}

	function hapus($id){
		$where = array('id' => $id);
		$this->Model_rdpolri->hapus_data($where,'tb_potongan_polri');
		redirect('RD_polri');
	}

	function edit($id){
		$where = array('id' => $id);
		$data['rdpolri'] = $this->Model_rdpolri->edit_data($where,'tb_potongan_polri')->result();
		$this->load->view('rdpolri/v_edit',$data);
	}
	function update(){
		$where = $this->session->userdata('id_satker');
		$id = $this->input->post('id');
		$satker = $this->session->userdata('satker');
		$pamen_kuat = $this->input->post('pamen_kuat');
		$pamen_pot = $this->input->post('pamen_pot');	
		$pama_kuat = $this->input->post('pama_kuat');
		$pama_pot = $this->input->post('pama_pot');
		$bintara_kuat = $this->input->post('bintara_kuat');
		$bintara_pot = $this->input->post('bintara_pot');
		$jml_kuat = $this->input->post('jml_kuat');
		$jml_pot = $this->input->post('jml_pot');
		$ket = $this->input->post('ket');
		$bulan = $this->input->post('bulan');
 
		$data = array(
			'id_satker' => $where,
			'satker' => $satker,
			'pamen_kuat' => $pamen_kuat,
			'pamen_pot' => $pamen_pot,
			'pama_kuat' => $pama_kuat,
			'pama_pot' => $pama_pot,
			'bintara_kuat' => $bintara_kuat,
			'bintara_pot' => $bintara_pot,
			'jml_kuat' => $jml_kuat,
			'jml_pot' => $jml_pot,
			'ket' => $ket,
			'bulan' => $bulan
			);
	 
		$where = array(
			'id' => $id
		);
	 
		$this->Model_rdpolri->update_data($where,$data,'tb_potongan_polri');
		redirect('RD_polri');
}

	function tambah_aksi(){
		$where = $this->session->userdata('id_satker');
		$satker = $this->session->userdata('satker');
		$pamen_kuat = $this->input->post('pamen_kuat');
		$pamen_pot = $this->input->post('pamen_pot');	
		$pama_kuat = $this->input->post('pama_kuat');
		$pama_pot = $this->input->post('pama_pot');
		$bintara_kuat = $this->input->post('bintara_kuat');
		$bintara_pot = $this->input->post('bintara_pot');
		$jml_kuat = $this->input->post('jml_kuat');
		$jml_pot = $this->input->post('jml_pot');
		$ket = $this->input->post('ket');
		$bulan = $this->input->post('bulan');
 
		$data = array(
			'id_satker' => $where,
			'satker' => $satker,
			'pamen_kuat' => $pamen_kuat,
			'pamen_pot' => $pamen_pot,
			'pama_kuat' => $pama_kuat,
			'pama_pot' => $pama_pot,
			'bintara_kuat' => $bintara_kuat,
			'bintara_pot' => $bintara_pot,
			'jml_kuat' => $jml_kuat,
			'jml_pot' => $jml_pot,
			'ket' => $ket,
			'bulan' => $bulan
			);
		$this->Model_rdpolri->input_data($data,'tb_potongan_polri');
		redirect('RD_polri');
	}

	public function excel(){
		$month = date('F, Y');
		$year = date('Y');
		require(APPPATH. 'PHPExcel-1.8/Classes/PHPExcel.php');
		require(APPPATH. 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

		$object = new PHPExcel();
		$object = $this->polri_excel($object);
		$object = $this->pns_excel($object);
		// $object = $this->keuangan_excel($object);

		$filename = "LAPORAN SEWA RUMDIN POLRES BLN ".$month.".xls";

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename. '"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createwriter($object, 'Excel5');
	
		$writer->save('php://output');

		exit;
	}

	public function polri_excel($object){
		$month = date('F, Y');
		$BULAN = date('F');
		$year = date('Y');
		$b = $this->input->post('bulan');
		$filtersatker = $this->session->userdata('id_satker');
		if ($this->session->userdata('level') == 'satker'){
			$data['rdpolri'] = $this->db->query("SELECT * FROM tb_potongan_polri WHERE id_satker = '$filtersatker' AND bulan like '%".$b."%' ")->result();
			$user['user'] = $this->Model_user->tampil_data()->result();
			$sheets = $object->setActiveSheetIndex(0);
			$sheets->setTitle("POLRI ".$month);
			$u = $this->db->query('SELECT * FROM tb_user WHERE id_satker = '.$filtersatker)->row();
			$lastRow = 22+count($data['rdpolri']);
			$baris = 20;
			$no = 1;

			$object->getActiveSheet()->getStyle('A17:K'.$lastRow.'')->applyFromArray(array(
			        'borders' => array(
			            'allborders' => array(
			                'style' => PHPExcel_Style_Border::BORDER_THIN
			            )
			        )
			    )
			);
			$style = array(
		        'alignment' => array(
		       		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        ),
		        'font'  => array(
			        'size'  => 10,
			        'name' => 'Arial',
			    )
		    );
		    $styleArray = array(
			    'font'  => array(
			        'size'  => 10,
			        'name' => 'Arial',
			        'bold' => true,
			    ));
		    $stylettd = array(
			    'font'  => array(
			        'bold' => true,
			        'underline'  => true,
			    ));

			
			foreach ($data['rdpolri'] as $r){
			
						if ($r->bulan == '0121') {
                          $bulan = 'Januari 2021';
                        }elseif ($r->bulan == '0221') {
                          $bulan = 'Februari 2021';
                        }elseif ($r->bulan == '0321') {
                          $bulan = 'Maret 2021';
                        }elseif ($r->bulan == '0421') {
                          $bulan = 'April 2021';
                        }elseif ($r->bulan == '0521') {
                          $bulan = 'Mei 2021';
                        }elseif ($r->bulan == '0621') {
                          $bulan = 'Juni 2021';
                        }elseif ($r->bulan == '0721') {
                          $bulan = 'Juli 2021';
                        }elseif ($r->bulan == '0821') {
                          $bulan = 'Agustus 2021';
                        }elseif ($r->bulan == '0921') {
                          $bulan = 'September 2021';
                        }elseif ($r->bulan == '1021') {
                          $bulan = 'Oktober 2021';
                        }elseif ($r->bulan == '1121') {
                          $bulan = 'November 2021';
                        }elseif ($r->bulan == '1221') {
                          $bulan = 'Desember 2021';
                        };
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, $bulan);
			$object->getActiveSheet()->setCellValue('C'.$baris, $r->pamen_kuat);
			$object->getActiveSheet()->setCellValue('D'.$baris, $r->pamen_pot);
			$object->getActiveSheet()->setCellValue('E'.$baris, $r->pama_kuat);
			$object->getActiveSheet()->setCellValue('F'.$baris, $r->pama_pot);
			$object->getActiveSheet()->setCellValue('G'.$baris, $r->bintara_kuat);
			$object->getActiveSheet()->setCellValue('H'.$baris, $r->bintara_pot);
			$object->getActiveSheet()->setCellValue('I'.$baris, $r->jml_kuat);
			$object->getActiveSheet()->setCellValue('J'.$baris, $r->jml_pot);
			$object->getActiveSheet()->setCellValue('K'.$baris, $r->ket);
			

			$baris++;
		}
			$where = array('id_satker' => $filtersatker, 'bulan' => $b);
			echo json_encode($where);die;
		 	$object->getActiveSheet()->getStyle('B'.($baris+2).':J'.($baris+2))->applyFromArray($styleArray);
		 	$object->getActiveSheet()->getStyle('C'.($lastRow+9))->applyFromArray($stylettd);
	    	$object->getActiveSheet()->getStyle('I'.($lastRow+9))->applyFromArray($stylettd);
		 	$object->getActiveSheet()->getStyle('A'.($lastRow+3).':I'.($lastRow+10))->applyFromArray($style);
			$object->getActiveSheet()->setCellValue('B'.($baris+2), 'JUMLAH');

			$object->getActiveSheet()->setCellValue('C'.($baris+2), $data['total_pmnkuat'] = $this->Model_rdpolri->hitungpmnkuat($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('D'.($baris+2), $data['total_pmnpot'] = $this->Model_rdpolri->hitungpmnpot($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('E'.($baris+2), $data['total_pmkuat'] = $this->Model_rdpolri->hitungpmkuat($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('F'.($baris+2), $data['total_pmpot'] = $this->Model_rdpolri->hitungpmpot($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('G'.($baris+2), $data['total_bntrkuat'] = $this->Model_rdpolri->hitungbntrkuat($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('H'.($baris+2), $data['total_bntrpot'] = $this->Model_rdpolri->hitungbntrpot($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('I'.($baris+2), $data['total_jmlhkuat'] = $this->Model_rdpolri->hitungjmlkuat($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('J'.($baris+2), $data['total_jmlhpot'] = $this->Model_rdpolri->hitungjmlpot($where,'tb_potongan_polri'));
		}elseif ($this->session->userdata('level') == 'admin'){
			$where = array('id_satker' => $this->session->userdata('id_satker'));
			$data['rdpolri'] = $this->db->query("SELECT * FROM tb_potongan_polri WHERE id_satker = '$filtersatker' AND bulan like '%".$b."%' ")->result();
			$user['user'] = $this->Model_user->tampil_data()->result();
			$sheets = $object->setActiveSheetIndex(0);
			$sheets->setTitle("POLRI ".$month);
			$sess_data = $this->session->userdata('id_satker');
			$u = $this->db->query('SELECT * FROM tb_user WHERE id_satker = '.$sess_data)->row();


			$lastRow = 22+count($data['rdpolri']);
			$baris = 20;
			$no = 1;

			$object->getActiveSheet()->getStyle('A17:K'.$lastRow.'')->applyFromArray(array(
			        'borders' => array(
			            'allborders' => array(
			                'style' => PHPExcel_Style_Border::BORDER_THIN
			            )
			        )
			    )
			);
			$styleimg = array(
		        'alignment' => array(
		       		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        ),
		    );
			$style = array(
		        'alignment' => array(
		       		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        ),
		        'font'  => array(
			        'size'  => 10,
			        'name' => 'Arial',
			    )
		    );
		    $styleArray = array(
			    'font'  => array(
			        'size'  => 10,
			        'name' => 'Arial',
			        'bold' => true,
			    ));
		    $stylettd = array(
			    'font'  => array(
			        'bold' => true,
			        'underline'  => true,
			    ));


			foreach ($data['rdpolri'] as $r){
				
						if ($r->bulan == '0121') {
                          $bulan = 'Januari 2021';
                        }elseif ($r->bulan == '0221') {
                          $bulan = 'Februari 2021';
                        }elseif ($r->bulan == '0321') {
                          $bulan = 'Maret 2021';
                        }elseif ($r->bulan == '0421') {
                          $bulan = 'April 2021';
                        }elseif ($r->bulan == '0521') {
                          $bulan = 'Mei 2021';
                        }elseif ($r->bulan == '0621') {
                          $bulan = 'Juni 2021';
                        }elseif ($r->bulan == '0721') {
                          $bulan = 'Juli 2021';
                        }elseif ($r->bulan == '0821') {
                          $bulan = 'Agustus 2021';
                        }elseif ($r->bulan == '0921') {
                          $bulan = 'September 2021';
                        }elseif ($r->bulan == '1021') {
                          $bulan = 'Oktober 2021';
                        }elseif ($r->bulan == '1121') {
                          $bulan = 'November 2021';
                        }elseif ($r->bulan == '1221') {
                          $bulan = 'Desember 2021';
                        };
				$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
				$object->getActiveSheet()->setCellValue('B'.$baris, $bulan);
				$object->getActiveSheet()->setCellValue('C'.$baris, $r->pamen_kuat);
				$object->getActiveSheet()->setCellValue('D'.$baris, $r->pamen_pot);
				$object->getActiveSheet()->setCellValue('E'.$baris, $r->pama_kuat);
				$object->getActiveSheet()->setCellValue('F'.$baris, $r->pama_pot);
				$object->getActiveSheet()->setCellValue('G'.$baris, $r->bintara_kuat);
				$object->getActiveSheet()->setCellValue('H'.$baris, $r->bintara_pot);
				$object->getActiveSheet()->setCellValue('I'.$baris, $r->jml_kuat);
				$object->getActiveSheet()->setCellValue('J'.$baris, $r->jml_pot);
				$object->getActiveSheet()->setCellValue('K'.$baris, $r->ket);
			

				$baris++;
			}
		 	$object->getActiveSheet()->getStyle('B'.($baris+2).':J'.($baris+2))->applyFromArray($styleArray);
		 	$object->getActiveSheet()->getStyle('C'.($lastRow+9))->applyFromArray($stylettd);
	    	$object->getActiveSheet()->getStyle('I'.($lastRow+9))->applyFromArray($stylettd);
		 	$object->getActiveSheet()->getStyle('A'.($lastRow+3).':I'.($lastRow+10))->applyFromArray($style);
			$object->getActiveSheet()->setCellValue('B'.($baris+2), 'JUMLAH');

			$object->getActiveSheet()->setCellValue('C'.($baris+2), $data['total_pmnkuat'] = $this->Model_rdpolri->hitungpmnkuatadmin());
			$object->getActiveSheet()->setCellValue('D'.($baris+2), 		$data['total_pmnpot'] = $this->Model_rdpolri->hitungpmnpotadmin());
			$object->getActiveSheet()->setCellValue('E'.($baris+2), 		$data['total_pmkuat'] = $this->Model_rdpolri->hitungpmkuatadmin());
			$object->getActiveSheet()->setCellValue('F'.($baris+2), 		$data['total_pmpot'] = $this->Model_rdpolri->hitungpmpotadmin());
			$object->getActiveSheet()->setCellValue('G'.($baris+2), 		$data['total_bntrkuat'] = $this->Model_rdpolri->hitungbntrkuatadmin());
			$object->getActiveSheet()->setCellValue('H'.($baris+2), 		$data['total_bntrpot'] = $this->Model_rdpolri->hitungbntrpotadmin());
			$object->getActiveSheet()->setCellValue('I'.($baris+2), 		$data['total_jmlhkuat'] = $this->Model_rdpolri->hitungjmlkuatadmin());
			$object->getActiveSheet()->setCellValue('J'.($baris+2), 		$data['total_jmlhpot'] = $this->Model_rdpolri->hitungjmlpotadmin());
		}	

		$object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$object->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$object->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$object->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$object->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$object->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$object->getActiveSheet()->getColumnDimension('K')->setWidth(25);


		

	    $object->getActiveSheet()->getStyle('A1:R'.$lastRow)->applyFromArray($style);
	    $object->getActiveSheet()->getStyle('A17:K19')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('A13')->applyFromArray($styleArray);
	    // $object->getActiveSheet()->getStyle('B1')->applyFromArray($styleimg);
	    $object->getActiveSheet()->getStyle('A14')->applyFromArray($stylettd);
	    $object->getActiveSheet()->getStyle('A10')->getFont()->setUnderline(true);


	    $object->getActiveSheet()->mergeCells('A17:A19');
	    $object->getActiveSheet()->mergeCells('B17:B19');
	    $object->getActiveSheet()->mergeCells('C17:H17');
		$object->getActiveSheet()->mergeCells('I17:J18');
		$object->getActiveSheet()->mergeCells('K17:K19');
		$object->getActiveSheet()->mergeCells('C18:D18');
		$object->getActiveSheet()->mergeCells('E18:F18');
		$object->getActiveSheet()->mergeCells('G18:H18');
		$object->getActiveSheet()->mergeCells('A8:C8');
		$object->getActiveSheet()->mergeCells('A9:C9');
		$object->getActiveSheet()->mergeCells('A10:C10');
		$object->getActiveSheet()->mergeCells('A13:K13');
		$object->getActiveSheet()->mergeCells('A14:K14');

		if (file_exists('Assets/img/brand/logopolri.png')) {
	        $objDrawing = new PHPExcel_Worksheet_Drawing();
	        $objDrawing->setName('Customer Signature');
	        $objDrawing->setDescription('Customer Signature');
	        //Path to signature .png file
	        $img = FCPATH.'Assets/img/brand/logopolri.png';    
	        $objDrawing->setPath($img);
	        $objDrawing->setOffsetX(8);                     //setOffsetX works properly
	        $objDrawing->setCoordinates('B1');             //set image to cell E38
	        $objDrawing->setHeight(140);                     //img height  
	        $objDrawing->setWorksheet($object->getActiveSheet());  //save      
    	}
		$object->getActiveSheet()->setCellValue('A8', 'KEPOLISIAN DAERAH SUMATERA SELATAN');
		$object->getActiveSheet()->setCellValue('A13', 'LAPORAN POTONGAN SEWA RUMAH DINAS POLRI');
		$object->getActiveSheet()->setCellValue('A14', 'BULAN : '.$month);
		$object->getActiveSheet()->setCellValue('A17', 'NO');
		$object->getActiveSheet()->setCellValue('B17', 'BULAN');
		$object->getActiveSheet()->setCellValue('C17', 'PANGKAT');
		$object->getActiveSheet()->setCellValue('C18', 'PAMEN');
		$object->getActiveSheet()->setCellValue('E18', 'PAMA');
		$object->getActiveSheet()->setCellValue('G18', 'BINTARA');
		$object->getActiveSheet()->setCellValue('I17', 'JUMLAH');
		$object->getActiveSheet()->setCellValue('C19', 'KUAT');
		$object->getActiveSheet()->setCellValue('D19', 'POT');
		$object->getActiveSheet()->setCellValue('E19', 'KUAT');
		$object->getActiveSheet()->setCellValue('F19', 'POT');
		$object->getActiveSheet()->setCellValue('G19', 'KUAT');
		$object->getActiveSheet()->setCellValue('H19', 'POT');
		$object->getActiveSheet()->setCellValue('I19', 'KUAT');
		$object->getActiveSheet()->setCellValue('J19', 'POT');
		$object->getActiveSheet()->setCellValue('K17', 'KETERANGAN');
		$object->getActiveSheet()->setCellValue('K16', '(POLRI)');
		$object->getActiveSheet()->setCellValue('A9', 'RESORT '.$u->satker);
			$object->getActiveSheet()->setCellValue('A10', $u->alamat);
			$object->getActiveSheet()->setCellValue('C'.($lastRow+3), 'MENGETAHUI');
			$object->getActiveSheet()->setCellValue('C'.($lastRow+4), 'KEPALA KEPOLISIAN RESORT');
			$object->getActiveSheet()->setCellValue('C'.($lastRow+5), $u->satker);
			$object->getActiveSheet()->setCellValue('C'.($lastRow+9), $u->nama_kepala);
			$object->getActiveSheet()->setCellValue('C'.($lastRow+10), $u->jabatan_kepala.' NRP '.$u->nrp_kepala);
			$object->getActiveSheet()->setCellValue('I'.($lastRow+3), 'MENGETAHUI');
			$object->getActiveSheet()->setCellValue('I'.($lastRow+4), 'KEPALA SEKSI KEUANGAN');
			$object->getActiveSheet()->setCellValue('I'.($lastRow+5), $u->satker);
			$object->getActiveSheet()->setCellValue('I'.($lastRow+9), $u->nama_keuangan);
			$object->getActiveSheet()->setCellValue('I'.($lastRow+10), $u->jabatan_keuangan.' NRP '.$u->nrp_keuangan);


			
		return $object;
	}

	public function pns_excel($object){
		$month = date('F, Y');
		$BULAN = date('F');
		$year = date('Y');
		$b = $this->input->post('bulan');
		if ($this->session->userdata('level') == 'satker'){
			$filtersatker = $this->session->userdata('id_satker');
			$data['rdpnspolri'] = $this->db->query("SELECT * FROM tb_potongan_pns WHERE id_satker = '$filtersatker' AND bulan like '%".$b."%' ")->result();
			$user['user'] = $this->Model_user->tampil_data()->result();
			$object->createSheet();
			$sheets = $object->setActiveSheetIndex(1);
			$sheets->setTitle("PNS POLRI ".$month);
			$u = $this->db->query('SELECT * FROM tb_user WHERE id_satker = '.$filtersatker)->row();

		$lastRow = 22+count($data['rdpnspolri']);
		$object->getActiveSheet()->getStyle('A17:K'.$lastRow.'')->applyFromArray(array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        )
		    )
		);
		$style = array(
	        'alignment' => array(
	       		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'font'  => array(
		        'size'  => 10,
		        'name' => 'Arial',
		    )
	    );
	    $styleArray = array(
		    'font'  => array(
		        'size'  => 10,
		        'name' => 'Arial',
		        'bold' => true,
		    ));
	    $stylettd = array(
		    'font'  => array(
		        'bold' => true,
		        'underline'  => true,
		    ));

	    


		$baris = 20;
		$no = 1;

		foreach ($data['rdpnspolri'] as $rp){

			if ($rp->bulan == '0121') {
                          $bulan = 'Januari 2021';
                        }elseif ($r->bulan == '0221') {
                          $bulan = 'Februari 2021';
                        }elseif ($r->bulan == '0321') {
                          $bulan = 'Maret 2021';
                        }elseif ($r->bulan == '0421') {
                          $bulan = 'April 2021';
                        }elseif ($r->bulan == '0521') {
                          $bulan = 'Mei 2021';
                        }elseif ($r->bulan == '0621') {
                          $bulan = 'Juni 2021';
                        }elseif ($r->bulan == '0721') {
                          $bulan = 'Juli 2021';
                        }elseif ($r->bulan == '0821') {
                          $bulan = 'Agustus 2021';
                        }elseif ($r->bulan == '0921') {
                          $bulan = 'September 2021';
                        }elseif ($r->bulan == '1021') {
                          $bulan = 'Oktober 2021';
                        }elseif ($r->bulan == '1121') {
                          $bulan = 'November 2021';
                        }elseif ($r->bulan == '1221') {
                          $bulan = 'Desember 2021';
                        };
			
			
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, $bulan);
			$object->getActiveSheet()->setCellValue('C'.$baris, $rp->gol4_kuat);
			$object->getActiveSheet()->setCellValue('D'.$baris, $rp->gol4_pot);
			$object->getActiveSheet()->setCellValue('E'.$baris, $rp->gol3_kuat);
			$object->getActiveSheet()->setCellValue('F'.$baris, $rp->gol3_pot);
			$object->getActiveSheet()->setCellValue('G'.$baris, $rp->gol2_kuat);
			$object->getActiveSheet()->setCellValue('H'.$baris, $rp->gol2_pot);
			$object->getActiveSheet()->setCellValue('I'.$baris, $rp->jml_kuat);
			$object->getActiveSheet()->setCellValue('J'.$baris, $rp->jml_pot);
			$object->getActiveSheet()->setCellValue('K'.$baris, $rp->ket);
			

			$baris++;
		}
			$where = array('id_satker' => $filtersatker, 'bulan' => $b);
		 	$object->getActiveSheet()->getStyle('B'.($baris+2).':J'.($baris+2))->applyFromArray($styleArray);
		 	$object->getActiveSheet()->getStyle('C'.($lastRow+9))->applyFromArray($stylettd);
	    	$object->getActiveSheet()->getStyle('I'.($lastRow+9))->applyFromArray($stylettd);
		 	$object->getActiveSheet()->getStyle('A'.($lastRow+3).':I'.($lastRow+10))->applyFromArray($style);
			$object->getActiveSheet()->setCellValue('B'.($baris+2), 'JUMLAH');
			$object->getActiveSheet()->setCellValue('C'.($baris+2), $data['total_gol4kuat'] = $this->Model_rdpnspolri->hitunggol4kuat($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('D'.($baris+2), 		$data['total_gol4pot'] = $this->Model_rdpnspolri->hitunggol4pot($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('E'.($baris+2), 		$data['total_gol3kuat'] = $this->Model_rdpnspolri->hitunggol3kuat($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('F'.($baris+2), 		$data['total_gol3pot'] = $this->Model_rdpnspolri->hitunggol3pot($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('G'.($baris+2), 		$data['total_gol2kuat'] = $this->Model_rdpnspolri->hitunggol2kuat($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('H'.($baris+2), 		$data['total_gol2pot'] = $this->Model_rdpnspolri->hitunggol2pot($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('I'.($baris+2), 		$data['total_jmlhkuat'] = $this->Model_rdpnspolri->hitungjmlkuat($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('J'.($baris+2), 		$data['total_jmlhpot'] = $this->Model_rdpnspolri->hitungjmlpot($where,'tb_potongan_pns'));





		}elseif ($this->session->userdata('level') == 'admin'){
			$where = array('id_satker' => $this->session->userdata('id_satker'));
			$data['rdpnspolri'] = $this->Model_rdpnspolri->tampil_data($where,'tb_potongan_pns')->result();
			$user['user'] = $this->Model_user->tampil_data()->result();
			$object->createSheet();
			$sheets = $object->setActiveSheetIndex(1);
			$sheets->setTitle("PNS POLRI ".$month);
			$sess_data = $this->session->userdata('id_satker');
			$u = $this->db->query('SELECT * FROM tb_user WHERE id_satker = '.$sess_data)->row();

			$lastRow = 22+count($data['rdpnspolri']);
		$object->getActiveSheet()->getStyle('A17:K'.$lastRow.'')->applyFromArray(array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        )
		    )
		);
		$style = array(
	        'alignment' => array(
	       		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'font'  => array(
		        'size'  => 10,
		        'name' => 'Arial',
		    )
	    );
	    $styleArray = array(
		    'font'  => array(
		        'size'  => 10,
		        'name' => 'Arial',
		        'bold' => true,
		    ));
	    $stylettd = array(
		    'font'  => array(
		        'bold' => true,
		        'underline'  => true,
		    ));


	    $baris = 20;
		$no = 1;

		foreach ($data['rdpnspolri'] as $rp){
			
			
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, $rp->satker);
			$object->getActiveSheet()->setCellValue('C'.$baris, $rp->gol4_kuat);
			$object->getActiveSheet()->setCellValue('D'.$baris, $rp->gol4_pot);
			$object->getActiveSheet()->setCellValue('E'.$baris, $rp->gol3_kuat);
			$object->getActiveSheet()->setCellValue('F'.$baris, $rp->gol3_pot);
			$object->getActiveSheet()->setCellValue('G'.$baris, $rp->gol2_kuat);
			$object->getActiveSheet()->setCellValue('H'.$baris, $rp->gol2_pot);
			$object->getActiveSheet()->setCellValue('I'.$baris, $rp->jml_kuat);
			$object->getActiveSheet()->setCellValue('J'.$baris, $rp->jml_pot);
			$object->getActiveSheet()->setCellValue('K'.$baris, $rp->ket);
			

			$baris++;
		}
		 	$object->getActiveSheet()->getStyle('B'.($baris+3).':J'.($baris+2))->applyFromArray($styleArray);
		 	$object->getActiveSheet()->getStyle('C'.($lastRow+9))->applyFromArray($stylettd);
	    	$object->getActiveSheet()->getStyle('I'.($lastRow+9))->applyFromArray($stylettd);
		 	$object->getActiveSheet()->getStyle('A'.($lastRow+3).':I'.($lastRow+10))->applyFromArray($style);
			$object->getActiveSheet()->setCellValue('B'.($baris+2), 'JUMLAH');
			$object->getActiveSheet()->setCellValue('C'.($baris+2), $data['total_gol4kuat'] = $this->Model_rdpnspolri->hitunggol4kuatadmin());
			$object->getActiveSheet()->setCellValue('D'.($baris+2), 		$data['total_gol4pot'] = $this->Model_rdpnspolri->hitunggol4potadmin());
			$object->getActiveSheet()->setCellValue('E'.($baris+2), 		$data['total_gol3kuat'] = $this->Model_rdpnspolri->hitunggol3kuatadmin());
			$object->getActiveSheet()->setCellValue('F'.($baris+2), 		$data['total_gol3pot'] = $this->Model_rdpnspolri->hitunggol3potadmin());
			$object->getActiveSheet()->setCellValue('G'.($baris+2), 		$data['total_gol2kuat'] = $this->Model_rdpnspolri->hitunggol2kuatadmin());
			$object->getActiveSheet()->setCellValue('H'.($baris+2), 		$data['total_gol2pot'] = $this->Model_rdpnspolri->hitunggol2potadmin());
			$object->getActiveSheet()->setCellValue('I'.($baris+2), 		$data['total_jmlhkuat'] = $this->Model_rdpnspolri->hitungjmlkuatadmin());
			$object->getActiveSheet()->setCellValue('J'.($baris+2), 		$data['total_jmlhpot'] = $this->Model_rdpnspolri->hitungjmlpotadmin());
		}

		$object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$object->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$object->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$object->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$object->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$object->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$object->getActiveSheet()->getColumnDimension('K')->setWidth(25);



	    $object->getActiveSheet()->getStyle('A1:R'.$lastRow)->applyFromArray($style);
	    $object->getActiveSheet()->getStyle('A17:K19')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('A13')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('A14')->applyFromArray($stylettd);
	    $object->getActiveSheet()->getStyle('A10')->getFont()->setUnderline(true);


	    $object->getActiveSheet()->mergeCells('A17:A19');
	    $object->getActiveSheet()->mergeCells('B17:B19');
	    $object->getActiveSheet()->mergeCells('C17:H17');
		$object->getActiveSheet()->mergeCells('I17:J18');
		$object->getActiveSheet()->mergeCells('K17:K19');
		$object->getActiveSheet()->mergeCells('C18:D18');
		$object->getActiveSheet()->mergeCells('E18:F18');
		$object->getActiveSheet()->mergeCells('G18:H18');
		$object->getActiveSheet()->mergeCells('A8:C8');
		$object->getActiveSheet()->mergeCells('A9:C9');
		$object->getActiveSheet()->mergeCells('A10:C10');
		$object->getActiveSheet()->mergeCells('A13:K13');
		$object->getActiveSheet()->mergeCells('A14:K14');

		if (file_exists('assets/img/brand/logopolri.png')) {
	        $objDrawing = new PHPExcel_Worksheet_Drawing();
	        $objDrawing->setName('Customer Signature');
	        $objDrawing->setDescription('Customer Signature');
	        //Path to signature .png file
	        $img = FCPATH.'assets/img/brand/logopolri.png';    
	        $objDrawing->setPath($img);
	        $objDrawing->setOffsetX(8);                     //setOffsetX works properly
	        $objDrawing->setCoordinates('B1');             //set image to cell E38
	        $objDrawing->setHeight(140);                     //img height  
	        $objDrawing->setWorksheet($object->getActiveSheet());  //save      
    	}

		$object->getActiveSheet()->setCellValue('A8', 'KEPOLISIAN DAERAH SUMATERA SELATAN');
		$object->getActiveSheet()->setCellValue('A13', 'LAPORAN POTONGAN SEWA RUMAH DINAS POLRI');
		$object->getActiveSheet()->setCellValue('A14', 'BULAN : '.$month);
		$object->getActiveSheet()->setCellValue('A17', 'NO');
		$object->getActiveSheet()->setCellValue('B17', 'BULAN');
		$object->getActiveSheet()->setCellValue('C17', 'PANGKAT');
		$object->getActiveSheet()->setCellValue('C18', 'GOL-IV');
		$object->getActiveSheet()->setCellValue('E18', 'GOL-III');
		$object->getActiveSheet()->setCellValue('G18', 'GOL-II');
		$object->getActiveSheet()->setCellValue('I17', 'JUMLAH');
		$object->getActiveSheet()->setCellValue('C19', 'KUAT');
		$object->getActiveSheet()->setCellValue('D19', 'POT');
		$object->getActiveSheet()->setCellValue('E19', 'KUAT');
		$object->getActiveSheet()->setCellValue('F19', 'POT');
		$object->getActiveSheet()->setCellValue('G19', 'KUAT');
		$object->getActiveSheet()->setCellValue('H19', 'POT');
		$object->getActiveSheet()->setCellValue('I19', 'KUAT');
		$object->getActiveSheet()->setCellValue('J19', 'POT');
		$object->getActiveSheet()->setCellValue('K17', 'KETERANGAN');
		$object->getActiveSheet()->setCellValue('K16', '(PNS)');
		$object->getActiveSheet()->setCellValue('A9', 'RESORT '.$u->satker);
		$object->getActiveSheet()->setCellValue('A10', $u->alamat);

		$object->getActiveSheet()->setCellValue('C'.($lastRow+3), 'MENGETAHUI');
		$object->getActiveSheet()->setCellValue('C'.($lastRow+4), 'KEPALA KEPOLISIAN RESORT');
		$object->getActiveSheet()->setCellValue('C'.($lastRow+5), $u->satker);
		$object->getActiveSheet()->setCellValue('C'.($lastRow+9), $u->nama_kepala);
		$object->getActiveSheet()->setCellValue('C'.($lastRow+10), $u->jabatan_kepala.' NRP '.$u->nrp_kepala);
		$object->getActiveSheet()->setCellValue('I'.($lastRow+3), 'MENGETAHUI');
		$object->getActiveSheet()->setCellValue('I'.($lastRow+4), 'KEPALA SEKSI KEUANGAN');
		$object->getActiveSheet()->setCellValue('I'.($lastRow+5), $u->satker);
		$object->getActiveSheet()->setCellValue('I'.($lastRow+9), $u->nama_keuangan);
		$object->getActiveSheet()->setCellValue('I'.($lastRow+10), $u->jabatan_keuangan.' NRP '.$u->nrp_keuangan);

		
		return $object;
	}

}

?>