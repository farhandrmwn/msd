<?php 
 
 
class Personil extends CI_Controller{
 
	function __construct(){
		parent::__construct();		
		$this->load->model('Model_personil');
		$this->load->model('Model_user');
		$this->load->helper(array('url','download'));
 		
	}
 
	public function index(){
		$user['user'] = $this->Model_user->tampil_data()->result();
		$where = array('id_satker' => $this->session->userdata('id_satker'));
		$data['personil'] = $this->Model_personil->tampil_data($where,'tb_pyb')->result();
		$this->load->view('personil/v_tampil',$data);
	}

	public function admin(){
		//$data['personil'] = $this->Model_personil->tampil_admin()->result();
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
		$data['personil'] = $this->db->query("SELECT * FROM tb_pyb WHERE id_satker = '$filtersatker' AND bulan = '$bln' ")->result();
		$this->load->view('personil/v_admin',$data);
	}
 
 	private function _uploadImage()
	{
	    $config['upload_path']          = './uploads/';
	    $config['allowed_types']        = 'pdf|xlsx|xls';
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
		$this->load->view('personil/v_input');
	}

	function hapus($id){
		$where = array('id_pyb' => $id);
		$this->Model_personil->hapus_data($where,'tb_pyb');
		redirect('personil');
	}

	function edit($id){
		$where = array('id_pyb' => $id);
		$data['personil'] = $this->Model_personil->edit_data($where,'tb_pyb')->result();
		$this->load->view('personil/v_edit',$data);
	}

	function update(){
		$where = $this->session->userdata('id_satker');
		$id_pyb = $this->input->post('id_pyb');
		$nama = $this->input->post('nama');
		$pangkat = $this->input->post('pangkat');
		$nrp = $this->input->post('nrp');	
		$jenis_kasus = $this->input->post('jenis_kasus');
		$proses = $this->input->post('proses');
		$pidum_ps = $this->input->post('pidum_ps');
		$etikprofesi_ps = $this->input->post('etikprofesi_ps');
		$disiplin_ps = $this->input->post('disiplin_ps');
		$pidum_lp = $this->input->post('pidum_lp');
		$etikprofesi_lp = $this->input->post('etikprofesi_lp');
		$disiplin_lp = $this->input->post('disiplin_lp');
		$pidum_tmh = $this->input->post('pidum_tmh');
		$etikprofesi_tmh = $this->input->post('etikprofesi_tmh');
		$disiplin_tmh = $this->input->post('disiplin_tmh');
		$penghentian_smntr = $this->input->post('penghentian_smntr');
		$byr_gj_tjhlima = $this->input->post('byr_gj_tjhlima');
		$penghentian_tunkun = $this->input->post('penghentian_tunkun');
		$keterangan = $this->input->post('keterangan');
		$tptgr = $this->input->post('tptgr');
		$file = $this->_uploadImage();
		$bulan = $this->input->post('bulan');
	 
		$data = array(
			'id_satker' => $where,
			'nama' => $nama,
			'pangkat' => $pangkat,
			'nrp' => $nrp,
			'jenis_kasus' => $jenis_kasus,
			'proses' => $proses,
			'pidum_ps' => $pidum_ps,
			'etikprofesi_ps' => $etikprofesi_ps,
			'disiplin_ps' => $disiplin_ps,
			'pidum_lp' => $pidum_lp,
			'etikprofesi_lp' => $etikprofesi_lp,
			'disiplin_lp' => $disiplin_lp,
			'pidum_tmh' => $pidum_tmh,
			'etikprofesi_tmh' => $etikprofesi_tmh,
			'disiplin_tmh' => $disiplin_tmh,
			'penghentian_smntr' => $penghentian_smntr,
			'byr_gj_tjhlima' => $byr_gj_tjhlima,
			'penghentian_tunkun' => $penghentian_tunkun,
			'tptgr' => $tptgr,
			'file' => $file,
			'keterangan' => $keterangan,
			'bulan' => $bulan
			);
	 
		$where = array(
			'id_pyb' => $id_pyb
		);
	 
		$this->Model_personil->update_data($where,$data,'tb_pyb');
		redirect('personil');
}

	function tambah_aksi(){
		$where = $this->session->userdata('id_satker');
		$nama = $this->input->post('nama');
		$pangkat = $this->input->post('pangkat');
		$nrp = $this->input->post('nrp');	
		$jenis_kasus = $this->input->post('jenis_kasus');
		$proses = $this->input->post('proses');
		$pidum_ps = $this->input->post('pidum_ps');
		$etikprofesi_ps = $this->input->post('etikprofesi_ps');
		$disiplin_ps = $this->input->post('disiplin_ps');
		$pidum_lp = $this->input->post('pidum_lp');
		$etikprofesi_lp = $this->input->post('etikprofesi_lp');
		$disiplin_lp = $this->input->post('disiplin_lp');
		$pidum_tmh = $this->input->post('pidum_tmh');
		$etikprofesi_tmh = $this->input->post('etikprofesi_tmh');
		$disiplin_tmh = $this->input->post('disiplin_tmh');
		$penghentian_smntr = $this->input->post('penghentian_smntr');
		$byr_gj_tjhlima = $this->input->post('byr_gj_tjhlima');
		$penghentian_tunkun = $this->input->post('penghentian_tunkun');
		$keterangan = $this->input->post('keterangan');
		$tptgr = $this->input->post('tptgr');
		$file = $this->_uploadImage();
		$bulan = $this->input->post('bulan');
 
		$data = array(
			'id_satker' => $where,
			'nama' => $nama,
			'pangkat' => $pangkat,
			'nrp' => $nrp,
			'jenis_kasus' => $jenis_kasus,
			'proses' => $proses,
			'pidum_ps' => $pidum_ps,
			'etikprofesi_ps' => $etikprofesi_ps,
			'disiplin_ps' => $disiplin_ps,
			'pidum_lp' => $pidum_lp,
			'etikprofesi_lp' => $etikprofesi_lp,
			'disiplin_lp' => $disiplin_lp,
			'pidum_tmh' => $pidum_tmh,
			'etikprofesi_tmh' => $etikprofesi_tmh,
			'disiplin_tmh' => $disiplin_tmh,
			'penghentian_smntr' => $penghentian_smntr,
			'byr_gj_tjhlima' => $byr_gj_tjhlima,
			'penghentian_tunkun' => $penghentian_tunkun,
			'keterangan' => $keterangan,
			'tptgr' => $tptgr,
			'file' => $file,
			'bulan' => $bulan
			);
		$this->Model_personil->input_data($data,'tb_pyb');
		redirect('Personil');
	}

	function download($id_pyb)
	{
		$data = $this->db->get_where('tb_pyb',['id_pyb'=>$id_pyb])->row();
		force_download('uploads/'.$data->file,NULL);
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
		$month = date('F, Y');
		$year = date('Y');
		$filtersatker = $this->input->get('satker');
		$bulan = $this->input->get('bulan');
		$tahun = $this->input->get('tahun');
		$bln = $bulan.' '.$tahun;
		if ($this->session->userdata('level') == 'admin'){
			$query = "SELECT * FROM tb_pyb WHERE id_satker = '$filtersatker' AND bulan = '$bln'";
			$data['personil'] = $this->db->query($query)->result();
			$user['user'] = $this->Model_user->tampil_data()->result();
			$sheets = $object->setActiveSheetIndex(0);
			$sheets->setTitle("PERSONIL BRMSLH ".$month);
			$u = $this->db->query('SELECT * FROM tb_user WHERE id_satker = '.$filtersatker)->row();

			$object->getActiveSheet()->setCellValue('A3', $u->satker);
			$object->getActiveSheet()->setCellValue('H9', 'SATKER : '.$u->satker);
			$object->getActiveSheet()->setCellValue('C24', 'KABAG SUMDA '.$u->satker);
			$object->getActiveSheet()->setCellValue('C29', $u->nama_kabag);
			$object->getActiveSheet()->setCellValue('C30', $u->jabatan_kabag.' NRP '.$u->nrp_kabag);
			$object->getActiveSheet()->setCellValue('H24', 'KASIKEU '.$u->satker);
			$object->getActiveSheet()->setCellValue('H29', $u->nama_kasikeu);
			$object->getActiveSheet()->setCellValue('H30', $u->jabatan_kasikeu.' NRP '.$u->nrp_kasikeu);
			$object->getActiveSheet()->setCellValue('Q24', 'KASI PROPAM '.$u->satker);
			$object->getActiveSheet()->setCellValue('Q29', $u->nama_kasi);
			$object->getActiveSheet()->setCellValue('Q30', $u->jabatan_kasi.' NRP '.$u->nrp_kasi);
			$object->getActiveSheet()->setCellValue('H33', 'MENGETAHUI');
			$object->getActiveSheet()->setCellValue('H34', 'KEPALA KEPOLISIAN RESORT');
			$object->getActiveSheet()->setCellValue('H35', $u->satker);
			$object->getActiveSheet()->setCellValue('H40', $u->nama_kepala);
			$object->getActiveSheet()->setCellValue('H41', $u->jabatan_kepala.' NRP '.$u->nrp_kepala);
		}elseif ($this->session->userdata('level') == 'satker') {
			$where = array('id_satker' => $this->session->userdata('id_satker'));
			$data['personil'] = $this->Model_personil->tampil_data($where,'tb_pyb')->result();
			$user['user'] = $this->Model_user->tampil_data()->result();
			$sheets = $object->setActiveSheetIndex(0);
			$sheets->setTitle("POLRI ".$month);
			$sess_data = $this->session->userdata('id_satker');
			$u = $this->db->query('SELECT * FROM tb_user WHERE id_satker = '.$sess_data)->row();
			$object->getActiveSheet()->setCellValue('A3', $u->satker);
			$object->getActiveSheet()->setCellValue('H9', 'SATKER : '.$u->satker);
			$object->getActiveSheet()->setCellValue('C24', 'KABAG SUMDA '.$u->satker);
			$object->getActiveSheet()->setCellValue('C29', $u->nama_kabag);
			$object->getActiveSheet()->setCellValue('C30', $u->jabatan_kabag.' NRP '.$u->nrp_kabag);
			$object->getActiveSheet()->setCellValue('H24', 'KASIKEU '.$u->satker);
			$object->getActiveSheet()->setCellValue('H29', $u->nama_kasikeu);
			$object->getActiveSheet()->setCellValue('H30', $u->jabatan_kasikeu.' NRP '.$u->nrp_kasikeu);
			$object->getActiveSheet()->setCellValue('Q24', 'KASI PROPAM '.$u->satker);
			$object->getActiveSheet()->setCellValue('Q29', $u->nama_kasi);
			$object->getActiveSheet()->setCellValue('Q30', $u->jabatan_kasi.' NRP '.$u->nrp_kasi);
			$object->getActiveSheet()->setCellValue('H33', 'MENGETAHUI');
			$object->getActiveSheet()->setCellValue('H34', 'KEPALA KEPOLISIAN RESORT');
			$object->getActiveSheet()->setCellValue('H35', $u->satker);
			$object->getActiveSheet()->setCellValue('H40', $u->nama_kepala);
			$object->getActiveSheet()->setCellValue('H41', $u->jabatan_kepala.' NRP '.$u->nrp_kepala);
		}

			


		$object->getActiveSheet()->getRowDimension('13')->setRowHeight(30);
		$object->getActiveSheet()->getRowDimension('14')->setRowHeight(30);
		$object->getActiveSheet()->getStyle('A11:S18')->getAlignment()->setWrapText(true); 

		$object->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('B')->setWidth(50);
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

		$lastRow = 15+count($data['personil'])*2;
		$object->getActiveSheet()->getStyle('A11:S'.$lastRow.'')->applyFromArray(array(
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

	    $object->getActiveSheet()->getStyle('A15:S'.$lastRow)->applyFromArray($style);
	    $object->getActiveSheet()->getStyle('A11:S14')->applyFromArray($stylehead);
	    $object->getActiveSheet()->getStyle('A1:S3')->applyFromArray($atasstyle);
	    $object->getActiveSheet()->getStyle('H8')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('H9')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('A24:Q41')->applyFromArray($style);
	    $object->getActiveSheet()->getStyle('C29')->applyFromArray($stylettd);
	    $object->getActiveSheet()->getStyle('H29')->applyFromArray($stylettd);
	    $object->getActiveSheet()->getStyle('Q29')->applyFromArray($stylettd);
	    $object->getActiveSheet()->getStyle('H40')->applyFromArray($stylettd);


	    $object->getActiveSheet()->mergeCells('A1:C1');
	    $object->getActiveSheet()->mergeCells('A2:C2');
	    $object->getActiveSheet()->mergeCells('A3:C3');
		$object->getActiveSheet()->mergeCells('A11:A14');
		$object->getActiveSheet()->mergeCells('B11:B14');
		$object->getActiveSheet()->mergeCells('C11:C14');
		$object->getActiveSheet()->mergeCells('D11:D14');
		$object->getActiveSheet()->mergeCells('E11:E14');
		$object->getActiveSheet()->mergeCells('F11:H12');
		$object->getActiveSheet()->mergeCells('I11:K12');
		$object->getActiveSheet()->mergeCells('L11:N12');
		$object->getActiveSheet()->mergeCells('O11:Q12');
		$object->getActiveSheet()->mergeCells('F13:F14');
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
		$object->getActiveSheet()->mergeCells('R11:R14');
		$object->getActiveSheet()->mergeCells('S11:S14');

		$object->getActiveSheet()->setCellValue('A1', 'KEPOLISIAN NEGARA REPUBLIK INDONESIA');
		$object->getActiveSheet()->setCellValue('A2', 'DAERAH SUMATERA SELATAN');
		$object->getActiveSheet()->setCellValue('H8', 'DATA PERSONEL POLRI DAN PNS YANG BERMASALAH S/D TAHUN ANGGARAN'.$year);

		$object->getActiveSheet()->setCellValue('A11', 'NO');
		$object->getActiveSheet()->setCellValue('B11', 'NAMA');
		$object->getActiveSheet()->setCellValue('C11', 'PANGKAT/NRP');
		$object->getActiveSheet()->setCellValue('D11', 'JENIS KASUS');
		$object->getActiveSheet()->setCellValue('E11', 'PROSES S/D HARI INI');
		$object->getActiveSheet()->setCellValue('F11', 'PROSES SIDANG ( TMT INKRACHT )');
		$object->getActiveSheet()->setCellValue('F13', 'PIDANA UMUM');
		$object->getActiveSheet()->setCellValue('G13', 'ETIK / PROFESI');
		$object->getActiveSheet()->setCellValue('H13', 'DISIPLIN');
		$object->getActiveSheet()->setCellValue('I11', 'LAMA PUTUSAN');
		$object->getActiveSheet()->setCellValue('I13', 'PIDANA UMUM');
		$object->getActiveSheet()->setCellValue('J13', 'ETIK / PROFESI');
		$object->getActiveSheet()->setCellValue('K13', 'DISIPLIN');
		$object->getActiveSheet()->setCellValue('L11', 'TEMPAT MENJALIN HUKUMAN');
		$object->getActiveSheet()->setCellValue('L13', 'PIDANA UMUM');
		$object->getActiveSheet()->setCellValue('M13', 'ETIK / PROFESI');
		$object->getActiveSheet()->setCellValue('N13', 'DISIPLIN');
		$object->getActiveSheet()->setCellValue('O11', 'PEMBAYARAN PENGHASILAN');
		$object->getActiveSheet()->setCellValue('O13', 'PENGHENTIAN SEMENTARA GAJI ( TMT )');
		$object->getActiveSheet()->setCellValue('P13', 'PEMBAYARAN GAJI 75% ( TMT )');
		$object->getActiveSheet()->setCellValue('Q13', 'PENGHENTIAN TUNKUN ( TMT )');
		$object->getActiveSheet()->setCellValue('R11', 'TPTGR');
		$object->getActiveSheet()->setCellValue('S11', 'KETERANGAN');
		$object->getActiveSheet()->setCellValue('A15', '1');
		$object->getActiveSheet()->setCellValue('B15', '2');
		$object->getActiveSheet()->setCellValue('C15', '3');
		$object->getActiveSheet()->setCellValue('D15', '4');
		$object->getActiveSheet()->setCellValue('E15', '5');
		$object->getActiveSheet()->setCellValue('G15', '8');
		$object->getActiveSheet()->setCellValue('H15', '9');
		$object->getActiveSheet()->setCellValue('I15', '10');
		$object->getActiveSheet()->setCellValue('J15', '11');
		$object->getActiveSheet()->setCellValue('K15', '12');
		$object->getActiveSheet()->setCellValue('S15', '13');
		


		$baris = 16;
		$no = 1;
		$plus = 1;


		foreach ($data['personil'] as $p){
			$object->getActiveSheet()->getRowDimension($baris)->setRowHeight(40);
			$object->getActiveSheet()->getRowDimension($baris+1)->setRowHeight(40);
			$object->getActiveSheet()->mergeCells('A'.$baris.':A'.($baris+1));
			$object->getActiveSheet()->mergeCells('B'.$baris.':B'.($baris+1));
			$object->getActiveSheet()->mergeCells('C'.$baris.':C'.($baris+1));
			$object->getActiveSheet()->mergeCells('D'.$baris.':D'.($baris+1));
			$object->getActiveSheet()->mergeCells('E'.$baris.':E'.($baris+1));
			$object->getActiveSheet()->mergeCells('F'.$baris.':F'.($baris+1));
			$object->getActiveSheet()->mergeCells('G'.$baris.':G'.($baris+1));
			$object->getActiveSheet()->mergeCells('H'.$baris.':H'.($baris+1));
			$object->getActiveSheet()->mergeCells('I'.$baris.':I'.($baris+1));
			$object->getActiveSheet()->mergeCells('J'.$baris.':J'.($baris+1));
			$object->getActiveSheet()->mergeCells('K'.$baris.':K'.($baris+1));
			$object->getActiveSheet()->mergeCells('L'.$baris.':L'.($baris+1));
			$object->getActiveSheet()->mergeCells('M'.$baris.':M'.($baris+1));
			$object->getActiveSheet()->mergeCells('N'.$baris.':N'.($baris+1));
			$object->getActiveSheet()->mergeCells('O'.$baris.':O'.($baris+1));
			$object->getActiveSheet()->mergeCells('P'.$baris.':P'.($baris+1));
			$object->getActiveSheet()->mergeCells('Q'.$baris.':Q'.($baris+1));
			$object->getActiveSheet()->mergeCells('R'.$baris.':R'.($baris+1));
			$object->getActiveSheet()->mergeCells('S'.$baris.':S'.($baris+1));
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, $p->nama);
			$object->getActiveSheet()->setCellValue('C'.$baris, $p->pangkat." / ". $p->nrp);
			$object->getActiveSheet()->setCellValue('D'.$baris, $p->jenis_kasus);
			$object->getActiveSheet()->setCellValue('E'.$baris, $p->proses);
			$object->getActiveSheet()->setCellValue('F'.$baris, $p->pidum_ps);
			$object->getActiveSheet()->setCellValue('G'.$baris, $p->etikprofesi_ps);
			$object->getActiveSheet()->setCellValue('H'.$baris, $p->disiplin_ps);
			$object->getActiveSheet()->setCellValue('I'.$baris, $p->pidum_lp);
			$object->getActiveSheet()->setCellValue('J'.$baris, $p->etikprofesi_lp);
			$object->getActiveSheet()->setCellValue('K'.$baris, $p->disiplin_lp);
			$object->getActiveSheet()->setCellValue('L'.$baris, $p->pidum_tmh);
			$object->getActiveSheet()->setCellValue('M'.$baris, $p->etikprofesi_tmh);
			$object->getActiveSheet()->setCellValue('N'.$baris, $p->disiplin_tmh);
			$object->getActiveSheet()->setCellValue('O'.$baris, $p->penghentian_smntr);
			$object->getActiveSheet()->setCellValue('P'.$baris, $p->byr_gj_tjhlima);
			$object->getActiveSheet()->setCellValue('Q'.$baris, $p->penghentian_tunkun);
			$object->getActiveSheet()->setCellValue('R'.$baris, $p->tptgr);
			$object->getActiveSheet()->setCellValue('S'.$baris, $p->keterangan);

			$plus++;
			$baris+=2;
		}
		return $object;
	}
}