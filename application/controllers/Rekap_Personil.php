<?php 
 
 
class Rekap_Personil extends CI_Controller{
 
	function __construct(){
		parent::__construct();		
		$this->load->model('Model_personil');
		$this->load->model('Model_user');
		$this->load->helper(array('url','download'));
 		
	}
 
	public function index(){
        $where = $this->session->userdata('id_satker');
		$b = $this->input->post('bulan');
		$t = $this->input->post('tahun');

		$data['b'] = $b;
		$data['t'] = $t;
		$data['satker'] = $this->db->query("SELECT * FROM tb_pyb,tb_user WHERE tb_pyb.id_satker = tb_user.id_satker  AND tb_pyb.bulan like '%".$b.$t."%' group by tb_pyb.id_satker  order by tb_pyb.id_satker   ")->result();
		$data['personil'] = $this->db->query("SELECT * FROM tb_pyb,tb_user WHERE tb_pyb.id_satker = tb_user.id_satker  AND tb_pyb.bulan like '%".$b.$t."%' order by tb_pyb.id_satker  ")->result();
		$this->load->view('rekap_personil/v_tampil',$data);
	}


	public function excel(){
		$month = date('F, Y');
		$year = date('Y');
		require(APPPATH. 'PHPExcel-1.8/Classes/PHPExcel.php');
		require(APPPATH. 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

		$object = new PHPExcel();
		$object = $this->personil_excel($object);
		// $object = $this->keuangan_excel($object);

		$filename = "DATA PERSONIL YANG BERMASALAH BLN ".$month.".xls";

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename. '"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createwriter($object, 'Excel5');
	
		$writer->save('php://output');

		exit;
	}

	public function personil_excel($object){
		$month = date('F Y');
		$year = date('Y');
		$filtersatker = $this->session->userdata('id_satker');
		$bulan = $this->input->get('bulan');
		$tahun = $this->input->get('tahun');
		$bln = $bulan.$tahun;
		if ($this->session->userdata('level') == 'admin'){
			$query = "SELECT * FROM tb_pyb WHERE id_satker = '$filtersatker' AND bulan = '$bln'";
			$data['satker'] = $this->db->query("SELECT * FROM tb_pyb,tb_user WHERE tb_pyb.id_satker = tb_user.id_satker  AND tb_pyb.bulan like '%".$bln."%' group by tb_pyb.id_satker  order by tb_pyb.id_satker   ")->result();
			$data['personil'] = $this->db->query("SELECT * FROM tb_pyb,tb_user WHERE tb_pyb.id_satker = tb_user.id_satker  AND tb_pyb.bulan like '%".$bln."%' order by tb_pyb.id_satker  ")->result();
			$user['user'] = $this->Model_user->tampil_data()->result();
			$sheets = $object->setActiveSheetIndex(0);
			$sheets->setTitle("PERSONIL BRMSLH ".$month);
			$u = $this->db->query('SELECT * FROM tb_user WHERE id_satker = '.$filtersatker)->row();

			
		}

			


		$object->getActiveSheet()->getRowDimension('13')->setRowHeight(30);
		$object->getActiveSheet()->getRowDimension('14')->setRowHeight(30);

		$object->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('C')->setWidth(45);
		$object->getActiveSheet()->getColumnDimension('D')->setWidth(45);
		$object->getActiveSheet()->getColumnDimension('E')->setWidth(50);
		$object->getActiveSheet()->getColumnDimension('F')->setWidth(35);
		$object->getActiveSheet()->getColumnDimension('G')->setWidth(45);
		$object->getActiveSheet()->getColumnDimension('H')->setWidth(45);
		$object->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$object->getActiveSheet()->getColumnDimension('J')->setWidth(25);
		$object->getActiveSheet()->getColumnDimension('K')->setWidth(25);
		$object->getActiveSheet()->getColumnDimension('L')->setWidth(45);
		$object->getActiveSheet()->getColumnDimension('M')->setWidth(45);
		$object->getActiveSheet()->getColumnDimension('N')->setWidth(45);
		$object->getActiveSheet()->getColumnDimension('O')->setWidth(30);
		$object->getActiveSheet()->getColumnDimension('P')->setWidth(30);
		$object->getActiveSheet()->getColumnDimension('Q')->setWidth(30);
		$object->getActiveSheet()->getColumnDimension('R')->setWidth(35);
		$object->getActiveSheet()->getColumnDimension('S')->setWidth(35);
		$object->getActiveSheet()->getColumnDimension('T')->setWidth(35);

		$lastRow = 15+count($data['personil'])*2+count($data['satker']);
		$object->getActiveSheet()->getStyle('A11:T'.$lastRow.'')->applyFromArray(array(
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
		        'size'  => 20,
		        'name' => 'Arial',
		    )
	    );
	    $stylehead = array(
	        'alignment' => array(
	       		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'font'  => array(
		        'size'  => 20,
		        'name' => 'Arial',
		        'bold' => true,
		    )
	    );
	    $atasstyle = array(
	        'alignment' => array(
	       		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'font'  => array(
		        'size'  => 26,
		        'name' => 'Arial',
		    )
	    );
	    $styleArray = array(
	    	'alignment' => array(
	       		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
		    'font'  => array(
		        'bold' => true,
		        'size'  => 36,
		        'name' => 'Arial Narrow'
		    ));
	    $stylettd = array(
		    'font'  => array(
		        'bold' => true,
		        'underline'  => true,
		    ));

	    $object->getActiveSheet()->getStyle('A11:T'.$lastRow)->getAlignment()->setWrapText(true); 
	    $object->getActiveSheet()->getStyle('A15:T'.$lastRow)->applyFromArray($style);
	    $object->getActiveSheet()->getStyle('A11:T14')->applyFromArray($stylehead);
	    $object->getActiveSheet()->getStyle('A1:T3')->applyFromArray($atasstyle);
	    $object->getActiveSheet()->getStyle('J8')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('J9')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('R'.($lastRow+3).':R'.($lastRow+10))->applyFromArray($style);
	    $object->getActiveSheet()->getStyle('R'.($lastRow+9))->applyFromArray($stylettd);


	    $object->getActiveSheet()->mergeCells('A1:D1');
	    $object->getActiveSheet()->mergeCells('A2:D2');
	    $object->getActiveSheet()->mergeCells('A3:C3');
	    $object->getActiveSheet()->mergeCells('A15:B15');
		$object->getActiveSheet()->mergeCells('A11:B14');
		$object->getActiveSheet()->mergeCells('C11:C14');
		$object->getActiveSheet()->mergeCells('D11:D14');
		$object->getActiveSheet()->mergeCells('E11:E14');
		$object->getActiveSheet()->mergeCells('F11:F14');
		$object->getActiveSheet()->mergeCells('G11:I12');
		$object->getActiveSheet()->mergeCells('J11:L12');
		$object->getActiveSheet()->mergeCells('M11:O12');
		$object->getActiveSheet()->mergeCells('P11:R12');
		$object->getActiveSheet()->mergeCells('G13:G14');
		$object->getActiveSheet()->mergeCells('H13:H14');
		$object->getActiveSheet()->mergeCells('I13:I14');
		$object->getActiveSheet()->mergeCells('J13:J14');
		$object->getActiveSheet()->mergeCells('K13:K14');
		$object->getActiveSheet()->mergeCells('L13:L14');
		$object->getActiveSheet()->mergeCells('M13:M14');
		$object->getActiveSheet()->mergeCells('N13:N14');
		$object->getActiveSheet()->mergeCells('O13:O14');
		$object->getActiveSheet()->mergeCells('P13:P14');
		$object->getActiveSheet()->mergeCells('Q13:Q14');
		$object->getActiveSheet()->mergeCells('R13:R14');
		$object->getActiveSheet()->mergeCells('S11:S14');
		$object->getActiveSheet()->mergeCells('T11:T14');

		$object->getActiveSheet()->setCellValue('A1', 'KEPOLISIAN NEGARA REPUBLIK INDONESIA');
		$object->getActiveSheet()->setCellValue('A2', 'DAERAH SUMATERA SELATAN');
		$object->getActiveSheet()->setCellValue('J8', 'DATA PERSONEL POLRI DAN PNS YANG BERMASALAH S/D TAHUN ANGGARAN '.$month);

		$object->getActiveSheet()->setCellValue('A11', 'NO');
		$object->getActiveSheet()->setCellValue('C11', 'NAMA');
		$object->getActiveSheet()->setCellValue('D11', 'PANGKAT/NRP');
		$object->getActiveSheet()->setCellValue('E11', 'JENIS KASUS');
		$object->getActiveSheet()->setCellValue('F11', 'PROSES S/D HARI INI');
		$object->getActiveSheet()->setCellValue('G11', 'PROSES SIDANG ( TMT INKRACHT )');
		$object->getActiveSheet()->setCellValue('G13', 'PIDANA UMUM');
		$object->getActiveSheet()->setCellValue('H13', 'ETIK / PROFESI');
		$object->getActiveSheet()->setCellValue('I13', 'DISIPLIN');
		$object->getActiveSheet()->setCellValue('J11', 'LAMA PUTUSAN');
		$object->getActiveSheet()->setCellValue('J13', 'PIDANA UMUM');
		$object->getActiveSheet()->setCellValue('K13', 'ETIK / PROFESI');
		$object->getActiveSheet()->setCellValue('L13', 'DISIPLIN');
		$object->getActiveSheet()->setCellValue('M11', 'TEMPAT MENJALIN HUKUMAN');
		$object->getActiveSheet()->setCellValue('M13', 'PIDANA UMUM');
		$object->getActiveSheet()->setCellValue('N13', 'ETIK / PROFESI');
		$object->getActiveSheet()->setCellValue('O13', 'DISIPLIN');
		$object->getActiveSheet()->setCellValue('P11', 'PEMBAYARAN PENGHASILAN');
		$object->getActiveSheet()->setCellValue('P13', 'PENGHENTIAN SEMENTARA GAJI ( TMT )');
		$object->getActiveSheet()->setCellValue('Q13', 'PEMBAYARAN GAJI 75% ( TMT )');
		$object->getActiveSheet()->setCellValue('R13', 'PENGHENTIAN TUNKUN ( TMT )');
		$object->getActiveSheet()->setCellValue('S11', 'TPTGR');
		$object->getActiveSheet()->setCellValue('T11', 'KETERANGAN');
		$object->getActiveSheet()->setCellValue('A15', '1');
		$object->getActiveSheet()->setCellValue('C15', '2');
		$object->getActiveSheet()->setCellValue('D15', '3');
		$object->getActiveSheet()->setCellValue('E15', '4');
		$object->getActiveSheet()->setCellValue('F15', '5');
		$object->getActiveSheet()->setCellValue('G15', '8');
		$object->getActiveSheet()->setCellValue('I15', '9');
		$object->getActiveSheet()->setCellValue('J15', '10');
		$object->getActiveSheet()->setCellValue('K15', '11');
		$object->getActiveSheet()->setCellValue('L15', '12');
		$object->getActiveSheet()->setCellValue('T15', '13');
			$object->getActiveSheet()->setCellValue('R'.($lastRow+3), 'Palembang, '.$month);
			$object->getActiveSheet()->setCellValue('R'.($lastRow+4), 'KEPALA BIDANG KEUANGAN POLDA SUMSEL');
			$object->getActiveSheet()->setCellValue('R'.($lastRow+9), 'HENI KRESNOWATI SP., S.E., M.Si. 
');
			$object->getActiveSheet()->setCellValue('R'.($lastRow+10), 'KOMISARIS BESAR POLISI NRP 70060457
');	
		


		$baris = 16;
		$no = 1;
		$plus = 1;

		$no2 = 1;
            foreach ($data['satker'] as $index => $key) {
                $kata = $key->id_satker; 
                $stk = $key->satker; 
                $q= $this->db->query("SELECT * FROM tb_pyb WHERE id_satker = '$kata' and bulan like '%".$bln."%' ")->result();
                $object->getActiveSheet()->getStyle('B'.$baris.':T'.$baris)->applyFromArray(array(
			        'font'  => array(
				        'size'  => 20,
				        'name' => 'Arial',
				        'bold' => true,
				    	)
			    	)
				);
				$object->getActiveSheet()->mergeCells('B'.$baris.':C'.$baris);
				$object->getActiveSheet()->mergeCells('D'.$baris.':T'.$baris);
                $object->getActiveSheet()->setCellValue('A'.$baris, $no2++);
				$object->getActiveSheet()->setCellValue('B'.$baris, $stk);
         
				foreach ($q as $p){
					$object->getActiveSheet()->getRowDimension($baris+1)->setRowHeight(40);
					$object->getActiveSheet()->getRowDimension($baris+2)->setRowHeight(40);
					$object->getActiveSheet()->mergeCells('B'.($baris+1).':B'.($baris+2));
					$object->getActiveSheet()->mergeCells('C'.($baris+1).':C'.($baris+2));
					$object->getActiveSheet()->mergeCells('D'.($baris+1).':D'.($baris+2));
					$object->getActiveSheet()->mergeCells('E'.($baris+1).':E'.($baris+2));
					$object->getActiveSheet()->mergeCells('F'.($baris+1).':F'.($baris+2));
					$object->getActiveSheet()->mergeCells('G'.($baris+1).':G'.($baris+2));
					$object->getActiveSheet()->mergeCells('H'.($baris+1).':H'.($baris+2));
					$object->getActiveSheet()->mergeCells('I'.($baris+1).':I'.($baris+2));
					$object->getActiveSheet()->mergeCells('J'.($baris+1).':J'.($baris+2));
					$object->getActiveSheet()->mergeCells('K'.($baris+1).':K'.($baris+2));
					$object->getActiveSheet()->mergeCells('L'.($baris+1).':L'.($baris+2));
					$object->getActiveSheet()->mergeCells('M'.($baris+1).':M'.($baris+2));
					$object->getActiveSheet()->mergeCells('N'.($baris+1).':N'.($baris+2));
					$object->getActiveSheet()->mergeCells('O'.($baris+1).':O'.($baris+2));
					$object->getActiveSheet()->mergeCells('P'.($baris+1).':P'.($baris+2));
					$object->getActiveSheet()->mergeCells('Q'.($baris+1).':Q'.($baris+2));
					$object->getActiveSheet()->mergeCells('R'.($baris+1).':R'.($baris+2));
					$object->getActiveSheet()->mergeCells('S'.($baris+1).':S'.($baris+2));
					$object->getActiveSheet()->mergeCells('T'.($baris+1).':T'.($baris+2));
					$object->getActiveSheet()->setCellValue('B'.($baris+1), $no++);
					$object->getActiveSheet()->setCellValue('C'.($baris+1), $p->nama);
					$object->getActiveSheet()->setCellValue('D'.($baris+1), $p->pangkat." / ". $p->nrp);
					$object->getActiveSheet()->setCellValue('E'.($baris+1), $p->jenis_kasus);
					$object->getActiveSheet()->setCellValue('F'.($baris+1), $p->proses);
					$object->getActiveSheet()->setCellValue('G'.($baris+1), $p->pidum_ps);
					$object->getActiveSheet()->setCellValue('H'.($baris+1), $p->etikprofesi_ps);
					$object->getActiveSheet()->setCellValue('I'.($baris+1), $p->disiplin_ps);
					$object->getActiveSheet()->setCellValue('J'.($baris+1), $p->pidum_lp);
					$object->getActiveSheet()->setCellValue('K'.($baris+1), $p->etikprofesi_lp);
					$object->getActiveSheet()->setCellValue('L'.($baris+1), $p->disiplin_lp);
					$object->getActiveSheet()->setCellValue('M'.($baris+1), $p->pidum_tmh);
					$object->getActiveSheet()->setCellValue('N'.($baris+1), $p->etikprofesi_tmh);
					$object->getActiveSheet()->setCellValue('O'.($baris+1), $p->disiplin_tmh);
					$object->getActiveSheet()->setCellValue('P'.($baris+1), $p->penghentian_smntr);
					$object->getActiveSheet()->setCellValue('Q'.($baris+1), $p->byr_gj_tjhlima);
					$object->getActiveSheet()->setCellValue('R'.($baris+1), $p->penghentian_tunkun);
					$object->getActiveSheet()->setCellValue('S'.($baris+1), $p->tptgr);
					$object->getActiveSheet()->setCellValue('T'.($baris+1), $p->keterangan);

					$plus++;
					$baris+=2;
				}
				$baris++;
			}
		return $object;
	}
 
}