<?php 


class Rekap_Rumdin_Polri extends CI_Controller{

	function __construct(){
		parent::__construct();		
		$this->load->model('Model_rdpolri');
		$this->load->model('Model_user');
		$this->load->helper('url');
		$this->load->model('Model_rdpnspolri');
 
	}
 
	function index(){
		$satker = $this->db->query("SELECT * FROM tb_user ")->result(); 
		foreach ($satker as $a) {
			$sat = $a->satker;
		}

		$b = $this->input->post('bulan');
		$t = $this->input->post('tahun');

		$pamen_kuat = $this->db->query("SELECT * FROM tb_personilpolri WHERE pangkat IN ('10','11','12')  AND bulan like '%".$b.$t."%'  ")->num_rows(); 
		$pama_kuat = $this->db->query("SELECT * FROM tb_personilpolri WHERE pangkat IN ('7','8','9')  AND bulan like '%".$b.$t."%'  ")->num_rows(); 
		$bintara_kuat = $this->db->query("SELECT * FROM tb_personilpolri WHERE pangkat IN ('1','2','3','4','5','6')  AND bulan like '%".$b.$t."%'  ")->num_rows(); 
		$jml_kuat = $this->db->query("SELECT * FROM tb_personilpolri WHERE  bulan like '%".$b.$t."%' ")->num_rows();

		$wherejml = "bulan like '%".$b.$t."%' ";
		$wherepamen = "pangkat in ('10','11','12') and bulan like '%".$b.$t."%' ";
		$wherepama = "pangkat in ('7','8','9') and bulan like '%".$b.$t."%' ";
		$wherebintara = "pangkat in ('1','2','3','4','5','6') and bulan like '%".$b.$t."%' ";

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
		

		$user['user'] = $this->Model_user->tampil_data()->result();
		$dmn = array('bulan'=> $b.$t );
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



        
		$data['b'] = $b;
		$data['t'] = $t;
		$data['rdpolri'] = $this->db->query("SELECT * FROM tb_potongan_polri,tb_user WHERE tb_potongan_polri.id_satker = tb_user.id_satker AND bulan like '%".$b.$t."%' ")->result();
		$this->load->view('rekap_rumdin/v_tampil_data_polri',$data);
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

		$filename = "LAPORAN SEWA RUMDIN POLRES BLN ".$month.".xlsx";

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename. '"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createwriter($object, 'Excel2007');
		$writer->save('php://output');

		exit;
	}

		public function polri_excel($object){
		$month = date('F, Y');
		$BULAN = date('F');
		$year = date('Y');
		$b = $this->input->post('bulan');
		if ($this->session->userdata('level') == 'admin'){
			$filtersatker = $this->session->userdata('id_satker');
			$data['rdpolri'] = $this->db->query("SELECT * FROM tb_potongan_polri,tb_user WHERE tb_potongan_polri.id_satker = tb_user.id_satker AND bulan like '%".$b."%' ")->result();
			$user['user'] = $this->Model_user->tampil_data()->result();
			$sheets = $object->setActiveSheetIndex(0);
			$sheets->setTitle("POLRI ".$month);
			$u = $this->db->query('SELECT * FROM tb_user WHERE id_satker = '.$filtersatker)->row();
			$lastRow = 12+count($data['rdpolri']);
			$baris = 10;
			$no = 1;

			$object->getActiveSheet()->getStyle('A7:O'.$lastRow.'')->applyFromArray(array(
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
			$object->getActiveSheet()->setCellValue('B'.$baris, $r->satker);
			$object->getActiveSheet()->setCellValue('C'.$baris, '-');
			$object->getActiveSheet()->setCellValue('D'.$baris, '-');
			$object->getActiveSheet()->setCellValue('E'.$baris, $r->pamen_kuat);
			$object->getActiveSheet()->setCellValue('F'.$baris, $r->pamen_pot);
			$object->getActiveSheet()->setCellValue('G'.$baris, $r->pama_kuat);
			$object->getActiveSheet()->setCellValue('H'.$baris, $r->pama_pot);
			$object->getActiveSheet()->setCellValue('I'.$baris, $r->bintara_kuat);
			$object->getActiveSheet()->setCellValue('J'.$baris, $r->bintara_pot);
			$object->getActiveSheet()->setCellValue('K'.$baris, '-');
			$object->getActiveSheet()->setCellValue('L'.$baris, '-');
			$object->getActiveSheet()->setCellValue('M'.$baris, $r->jml_kuat);
			$object->getActiveSheet()->setCellValue('N'.$baris, $r->jml_pot);
			$object->getActiveSheet()->setCellValue('O'.$baris, $r->ket);
			

			$baris++;
		}
			$where = array('bulan' => $b);
		 	$object->getActiveSheet()->getStyle('B'.($baris+2).':J'.($baris+2))->applyFromArray($styleArray);
		 	$object->getActiveSheet()->getStyle('C'.($lastRow+9))->applyFromArray($stylettd);
	    	$object->getActiveSheet()->getStyle('K'.($lastRow+9))->applyFromArray($stylettd);
		 	$object->getActiveSheet()->getStyle('A'.($lastRow+3).':K'.($lastRow+10))->applyFromArray($style);
			$object->getActiveSheet()->setCellValue('B'.($baris+2), 'JUMLAH');

			$object->getActiveSheet()->setCellValue('E'.($baris+2), $data['total_pmnkuat'] = $this->Model_rdpolri->hitungpmnkuat($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('F'.($baris+2), $data['total_pmnpot'] = $this->Model_rdpolri->hitungpmnpot($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('G'.($baris+2), $data['total_pmkuat'] = $this->Model_rdpolri->hitungpmkuat($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('H'.($baris+2), $data['total_pmpot'] = $this->Model_rdpolri->hitungpmpot($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('I'.($baris+2), $data['total_bntrkuat'] = $this->Model_rdpolri->hitungbntrkuat($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('J'.($baris+2), $data['total_bntrpot'] = $this->Model_rdpolri->hitungbntrpot($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('M'.($baris+2), $data['total_jmlhkuat'] = $this->Model_rdpolri->hitungjmlkuat($where,'tb_potongan_polri'));
			$object->getActiveSheet()->setCellValue('N'.($baris+2), $data['total_jmlhpot'] = $this->Model_rdpolri->hitungjmlpot($where,'tb_potongan_polri'));
		}	

		$object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$object->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$object->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$object->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('E')->setWidth(7);
		$object->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('G')->setWidth(7);
		$object->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('I')->setWidth(7);
		$object->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('K')->setWidth(7);
		$object->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('M')->setWidth(7);
		$object->getActiveSheet()->getColumnDimension('N')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('O')->setWidth(10);


		

	    $object->getActiveSheet()->getStyle('A1:O'.$lastRow)->applyFromArray($style);
	    $object->getActiveSheet()->getStyle('A7:O9')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray);
	    // $object->getActiveSheet()->getStyle('B1')->applyFromArray($styleimg);
	    $object->getActiveSheet()->getStyle('A5')->applyFromArray($stylettd);
	    // $object->getActiveSheet()->getStyle('A0')->getFont()->setUnderline(true);


	    $object->getActiveSheet()->mergeCells('A7:A9');
	    $object->getActiveSheet()->mergeCells('B7:B9');
	    $object->getActiveSheet()->mergeCells('C7:L7');
		$object->getActiveSheet()->mergeCells('M7:N8');
		$object->getActiveSheet()->mergeCells('O7:O9');
		$object->getActiveSheet()->mergeCells('C8:D8');
		$object->getActiveSheet()->mergeCells('E8:F8');
		$object->getActiveSheet()->mergeCells('G8:H8');
		$object->getActiveSheet()->mergeCells('I8:J8');
		$object->getActiveSheet()->mergeCells('K8:L8');
		$object->getActiveSheet()->mergeCells('A1:C1');
		$object->getActiveSheet()->mergeCells('A2:C2');
		$object->getActiveSheet()->mergeCells('A5:O5');
		$object->getActiveSheet()->mergeCells('A4:O4');

		$object->getActiveSheet()->setCellValue('A1', 'KEPOLISIAN DAERAH SUMATERA SELATAN');
		$object->getActiveSheet()->setCellValue('A4', 'LAPORAN POTONGAN SEWA RUMAH DINAS POLRI');
		$object->getActiveSheet()->setCellValue('A5', 'BULAN  '.$month);
		$object->getActiveSheet()->setCellValue('A7', 'NO');
		$object->getActiveSheet()->setCellValue('B7', 'SATKER');
		$object->getActiveSheet()->setCellValue('C7', 'PANGKAT');
		$object->getActiveSheet()->setCellValue('E8', 'PAMEN');
		$object->getActiveSheet()->setCellValue('G8', 'PAMA');
		$object->getActiveSheet()->setCellValue('I8', 'BINTARA');
		$object->getActiveSheet()->setCellValue('C8', 'PATI');
		$object->getActiveSheet()->setCellValue('K8', 'TAMTAMA');
		$object->getActiveSheet()->setCellValue('M7', 'JUMLAH');
		$object->getActiveSheet()->setCellValue('C9', 'KUAT');
		$object->getActiveSheet()->setCellValue('D9', 'POT');
		$object->getActiveSheet()->setCellValue('E9', 'KUAT');
		$object->getActiveSheet()->setCellValue('F9', 'POT');
		$object->getActiveSheet()->setCellValue('G9', 'KUAT');
		$object->getActiveSheet()->setCellValue('H9', 'POT');
		$object->getActiveSheet()->setCellValue('I9', 'KUAT');
		$object->getActiveSheet()->setCellValue('J9', 'POT');
		$object->getActiveSheet()->setCellValue('K9', 'KUAT');
		$object->getActiveSheet()->setCellValue('L9', 'POT');
		$object->getActiveSheet()->setCellValue('M9', 'KUAT');
		$object->getActiveSheet()->setCellValue('N9', 'POT');
		$object->getActiveSheet()->setCellValue('O7', 'KET');
		$object->getActiveSheet()->setCellValue('A2', 'DAERAH SUMATERA SELATAN');
		$object->getActiveSheet()->setCellValue('K'.($lastRow+3), 'ATAS NAMA');
		$object->getActiveSheet()->setCellValue('K'.($lastRow+4), 'KEPALA KEPOLISIAN DAERAH SUMATERA SELATAN');
		$object->getActiveSheet()->setCellValue('K'.($lastRow+5), 'KABIDKEU');
		$object->getActiveSheet()->setCellValue('K'.($lastRow+9), $u->nama_kepala);
		$object->getActiveSheet()->setCellValue('K'.($lastRow+10), $u->jabatan_kepala.' NRP '.$u->nrp_kepala);


			
		return $object;
	}

	public function pns_excel($object){
		$month = date('F, Y');
		$BULAN = date('F');
		$year = date('Y');
		$b = $this->input->post('bulan');
		if ($this->session->userdata('level') == 'admin'){
			$filtersatker = $this->session->userdata('id_satker');
			$data['rdpnspolri'] = $this->db->query("SELECT * FROM tb_potongan_pns,tb_user WHERE tb_potongan_pns.id_satker = tb_user.id_satker AND tb_potongan_pns.bulan like '%".$b."%' ")->result();
			$user['user'] = $this->Model_user->tampil_data()->result();
			$object->createSheet();
			$sheets = $object->setActiveSheetIndex(1);
			$sheets->setTitle("PNS POLRI ".$month);
			$u = $this->db->query('SELECT * FROM tb_user WHERE id_satker = '.$filtersatker)->row();

		$lastRow = 12+count($data['rdpnspolri']);
		$object->getActiveSheet()->getStyle('A7:M'.$lastRow.'')->applyFromArray(array(
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

	    


		$baris = 10;
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
			$object->getActiveSheet()->setCellValue('B'.$baris, $rp->satker);
			$object->getActiveSheet()->setCellValue('C'.$baris, $rp->gol4_kuat);
			$object->getActiveSheet()->setCellValue('D'.$baris, $rp->gol4_pot);
			$object->getActiveSheet()->setCellValue('E'.$baris, $rp->gol3_kuat);
			$object->getActiveSheet()->setCellValue('F'.$baris, $rp->gol3_pot);
			$object->getActiveSheet()->setCellValue('G'.$baris, $rp->gol2_kuat);
			$object->getActiveSheet()->setCellValue('H'.$baris, $rp->gol2_pot);
			$object->getActiveSheet()->setCellValue('I'.$baris, '-');
			$object->getActiveSheet()->setCellValue('J'.$baris, '-');
			$object->getActiveSheet()->setCellValue('K'.$baris, $rp->jml_kuat);
			$object->getActiveSheet()->setCellValue('L'.$baris, $rp->jml_pot);
			$object->getActiveSheet()->setCellValue('M'.$baris, $rp->ket);
			

			$baris++;
		}
			$where = array('bulan' => $b);
		 	$object->getActiveSheet()->getStyle('B'.($baris+2).':J'.($baris+2))->applyFromArray($styleArray);
		 	$object->getActiveSheet()->getStyle('C'.($lastRow+9))->applyFromArray($stylettd);
	    	$object->getActiveSheet()->getStyle('K'.($lastRow+9))->applyFromArray($stylettd);
		 	$object->getActiveSheet()->getStyle('A'.($lastRow+3).':K'.($lastRow+10))->applyFromArray($style);
			$object->getActiveSheet()->setCellValue('B'.($baris+2), 'JUMLAH');
			$object->getActiveSheet()->setCellValue('C'.($baris+2), $data['total_gol4kuat'] = $this->Model_rdpnspolri->hitunggol4kuat($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('D'.($baris+2), 		$data['total_gol4pot'] = $this->Model_rdpnspolri->hitunggol4pot($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('E'.($baris+2), 		$data['total_gol3kuat'] = $this->Model_rdpnspolri->hitunggol3kuat($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('F'.($baris+2), 		$data['total_gol3pot'] = $this->Model_rdpnspolri->hitunggol3pot($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('G'.($baris+2), 		$data['total_gol2kuat'] = $this->Model_rdpnspolri->hitunggol2kuat($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('H'.($baris+2), 		$data['total_gol2pot'] = $this->Model_rdpnspolri->hitunggol2pot($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('K'.($baris+2), 		$data['total_jmlhkuat'] = $this->Model_rdpnspolri->hitungjmlkuat($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('L'.($baris+2), 		$data['total_jmlhpot'] = $this->Model_rdpnspolri->hitungjmlpot($where,'tb_potongan_pns'));

		}

		$object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$object->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$object->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$object->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('E')->setWidth(7);
		$object->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('G')->setWidth(7);
		$object->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('I')->setWidth(7);
		$object->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('K')->setWidth(7);
		$object->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('M')->setWidth(10);



	    $object->getActiveSheet()->getStyle('A1:M'.$lastRow)->applyFromArray($style);
	    $object->getActiveSheet()->getStyle('A7:M9')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('A5')->applyFromArray($stylettd);
	    // $object->getActiveSheet()->getStyle('A10')->getFont()->setUnderline(true);


	    $object->getActiveSheet()->mergeCells('A7:A9');
	    $object->getActiveSheet()->mergeCells('B7:B9');
	    $object->getActiveSheet()->mergeCells('C7:J7');
		$object->getActiveSheet()->mergeCells('K7:L8');
		$object->getActiveSheet()->mergeCells('M7:M9');
		$object->getActiveSheet()->mergeCells('C8:D8');
		$object->getActiveSheet()->mergeCells('E8:F8');
		$object->getActiveSheet()->mergeCells('G8:H8');
		$object->getActiveSheet()->mergeCells('I8:J8');
		$object->getActiveSheet()->mergeCells('A1:C1');
		$object->getActiveSheet()->mergeCells('A2:C2');
		$object->getActiveSheet()->mergeCells('A4:M4');
		$object->getActiveSheet()->mergeCells('A5:M5');

		$object->getActiveSheet()->setCellValue('A1', 'KEPOLISIAN DAERAH SUMATERA SELATAN');
		$object->getActiveSheet()->setCellValue('A4', 'LAPORAN POTONGAN SEWA RUMAH DINAS POLRI');
		$object->getActiveSheet()->setCellValue('A5', 'BULAN  '.$month);
		$object->getActiveSheet()->setCellValue('A7', 'NO');
		$object->getActiveSheet()->setCellValue('B7', 'BULAN');
		$object->getActiveSheet()->setCellValue('C7', 'PANGKAT');
		$object->getActiveSheet()->setCellValue('C8', 'GOL IV');
		$object->getActiveSheet()->setCellValue('E8', 'GOL III');
		$object->getActiveSheet()->setCellValue('G8', 'GOL II');
		$object->getActiveSheet()->setCellValue('I8', 'GOL I');
		$object->getActiveSheet()->setCellValue('K7', 'JUMLAH');
		$object->getActiveSheet()->setCellValue('C9', 'KUAT');
		$object->getActiveSheet()->setCellValue('D9', 'POT');
		$object->getActiveSheet()->setCellValue('E9', 'KUAT');
		$object->getActiveSheet()->setCellValue('F9', 'POT');
		$object->getActiveSheet()->setCellValue('G9', 'KUAT');
		$object->getActiveSheet()->setCellValue('H9', 'POT');
		$object->getActiveSheet()->setCellValue('I9', 'KUAT');
		$object->getActiveSheet()->setCellValue('J9', 'POT');
		$object->getActiveSheet()->setCellValue('K9', 'KUAT');
		$object->getActiveSheet()->setCellValue('L9', 'POT');
		$object->getActiveSheet()->setCellValue('M7', 'KET');
		$object->getActiveSheet()->setCellValue('A2', 'DAERAH SUMATERA SELATAN');

		$object->getActiveSheet()->setCellValue('K'.($lastRow+3), 'ATAS NAMA');
		$object->getActiveSheet()->setCellValue('K'.($lastRow+4), 'KEPALA KEPOLISIAN DAERAH SUMATERA SELATAN');
		$object->getActiveSheet()->setCellValue('K'.($lastRow+5), 'KABIDKEU');
		$object->getActiveSheet()->setCellValue('K'.($lastRow+9), $u->nama_kepala);
		$object->getActiveSheet()->setCellValue('K'.($lastRow+10), $u->jabatan_kepala.' NRP '.$u->nrp_kepala);

		
		return $object;
	}

}

?>