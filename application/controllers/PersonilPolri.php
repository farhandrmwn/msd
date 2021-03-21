<?php 


class PersonilPolri extends CI_Controller{

	function __construct(){
		parent::__construct();		
		$this->load->model('Model_personilpolri');
		$this->load->model('Model_user');
		$this->load->helper('url');
		$this->load->model('Model_rdpnspolri');
 
	}
 
	function index(){
		$waktu = $this->db->query("SELECT * FROM tb_personilpolri GROUP BY bulan ")->result();
             foreach ($waktu as $a) {
              $cek =  $a->bulan;
			  $s = substr($cek, -4,4);
             }
        $bulan = date('my');

        $where = $this->session->userdata('id_satker');
		$bulan = date('my');
 
		@$data = array(
			'id_satker' => $where,
			'bulan' => $cek.', '.$bulan
			);

        @$int = (int)$s;
        $skg = (int)$bulan;

        if ($int < $skg) {

        	@$array = array('id_satker' => $where, 'bulan like' => '%'.$s.'%');
			$this->db->where($array); 
			$this->db->update('tb_personilpolri', $data);

        }
		
		$user['user'] = $this->Model_user->tampil_data()->result();

		$b = $this->input->post('bulan');
		$t = $this->input->post('tahun');

        $data['b'] = $b;
		$data['t'] = $t;
		$data['PersonilPolri'] = $this->db->query("SELECT * FROM tb_personilpolri,tb_pangkat WHERE tb_personilpolri.id_satker = '$where' AND tb_pangkat.id_pangkat = tb_personilpolri.pangkat AND tb_personilpolri.bulan like '%".$b.$t."%' ")->result();

		$this->load->view('PersonilPolri/v_tampil',$data);
	}

	public function admin(){
       	$data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
       	$satker = $this->input->post('satker');
		$b = $this->input->post('bulan');
		$t = $this->input->post('tahun');

		$data['PersonilPolri'] = $this->db->query("SELECT * FROM tb_personilpolri,tb_pangkat WHERE tb_personilpolri.id_satker = '$satker' AND tb_pangkat.id_pangkat = tb_personilpolri.pangkat AND tb_personilpolri.bulan like '%".$b.$t."%' ")->result();
		$this->load->view('PersonilPolri/v_admin',$data);
	}

	function pilih(){
		$this->load->view('PersonilPolri/v_pilih');
	}
 
	function tambah(){
		$where = $this->session->userdata('id_satker');
		$data['pangkat'] = $this->db->query("SELECT * FROM tb_pangkat")->result();
		$data['satker'] = $this->db->query("SELECT * FROM tb_user WHERE id_satker = '$where' ")->result();
		$this->load->view('PersonilPolri/v_input', $data) ;
	}

	function hapus($id){
		$where = array('id' => $id);
		$this->Model_personilpolri->hapus_data($where,'tb_personilpolri');
		redirect('PersonilPolri');
	}

	function edit($id){
		$where = array('id' => $id);
		$data['PersonilPolri'] = $this->Model_personilpolri->edit_data($where,'tb_personilpolri')->result();
		$this->load->view('PersonilPolri/v_edit',$data);
	}
	function update(){
		$id = $this->input->post('id');
		$where = $this->session->userdata('id_satker');
		$nama = $this->input->post('nama');
		$nrp = $this->input->post('nrp');
		$pangkat = $this->input->post('pangkat');	
		$jabatan = $this->input->post('jabatan');
		$alamat = $this->input->post('alamat');
		$pot = $this->input->post('pot');
 
		$data = array(
			'id_satker' => $where,
			'nama' => $nama,
			'nrp' => $nrp,
			'pangkat' => $pangkat,
			'jabatan' => $jabatan,
			'alamat' => $alamat,
			'pot' => $pot
			);
	 
		$where = array(
			'id' => $id
		);
	 
		$this->Model_personilpolri->update_data($where,$data,'tb_personilpolri');
		redirect('PersonilPolri');
}

	public function hapusdata($id)
	{
		$b = $this->input->post('bulan');
		$stk = $this->session->userdata('id_satker');
		$where = array('id' => $id);
		$q = $this->db->query("SELECT * FROM tb_personilpolri WHERE id = '$id' AND id_satker = '$stk' AND bulan like '%".$b."%'  ")->result();
        foreach ($q as $as) {
        	$bln = $as->bulan;
        }
        $a = "/".$b."/";
        $hasil=preg_replace($a,"", $bln);
		$data = array(
			'bulan' => $hasil
			);

		$where = array(
			'id' => $id
		);
	 
		$this->Model_personilpolri->update_data($where,$data,'tb_personilpolri');
		redirect('PersonilPolri/pilih');

		

	}


	function tambah_aksi(){
		$where = $this->session->userdata('id_satker');
		$nama = $this->input->post('nama');
		$nrp = $this->input->post('nrp');
		$pangkat = $this->input->post('pangkat');	
		$jabatan = $this->input->post('jabatan');
		$alamat = $this->input->post('alamat');
		$pot = $this->input->post('pot');
		$satker = $this->input->post('satker');
		$bulan = date('my');
 
		$data = array(
			'id_satker' => $where,
			'nama' => $nama,
			'nrp' => $nrp,
			'pangkat' => $pangkat,
			'jabatan' => $jabatan,
			'alamat' => $alamat,
			'pot' => $pot,
			'bulan' => $bulan

			);

		// Kalau data kosong

		$pamen_kuat = $this->db->query("SELECT * FROM tb_personilpolri WHERE pangkat IN ('10','11','12') ")->num_rows(); 
		$pama_kuat = $this->db->query("SELECT * FROM tb_personilpolri WHERE pangkat IN ('7','8','9') ")->num_rows(); 
		$bintara_kuat = $this->db->query("SELECT * FROM tb_personilpolri WHERE pangkat IN ('1','2','3','4','5','6') ")->num_rows(); 
		


		$data2 = array(
			'id_satker' => $where,
			'satker' => $satker,
			'pamen_kuat' => $pamen_kuat,
			'pamen_pot' => 0,
			'pama_kuat' => $pama_kuat,
			'pama_pot' => 0,
			'bintara_kuat' => $bintara_kuat,
			'bintara_pot' => 0,
			'jml_kuat' => 0,
			'jml_pot' => 0,
			'tot_kuat' => 0,
			'tot_pot' => 0,
			'ket' => 0,
			'bulan' => 0
		);



		$this->Model_personilpolri->input_data($data,'tb_personilpolri');


		redirect('PersonilPolri');
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

		$filename = "LIST PERSONIL SEWA RUMDIN POLRES BLN ".$month.".xlsx";

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
		if ($this->session->userdata('level') == 'satker'){
			$where = $this->session->userdata('id_satker');
			$data['PersonilPolri'] = $this->db->query("SELECT * FROM tb_personilpolri,tb_pangkat WHERE tb_personilpolri.id_satker = '$where' AND tb_pangkat.id_pangkat = tb_personilpolri.pangkat AND tb_personilpolri.bulan like '%".$b."%' ")->result();
			$user['user'] = $this->Model_user->tampil_data()->result();
			$sheets = $object->setActiveSheetIndex(0);
			$sheets->setTitle("PERSONIL RUMDIN".$month);
			$sess_data = $this->session->userdata('id_satker');
			$u = $this->db->query('SELECT * FROM tb_user WHERE id_satker = '.$sess_data)->row();
			$lastRow = 19+count($data['PersonilPolri']);
			$baris = 18;
			$no = 1;

			$object->getActiveSheet()->getStyle('A17:G'.$lastRow.'')->applyFromArray(array(
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

			$object->getActiveSheet()->setCellValue('A9', 'RESORT '.$u->satker);
			$object->getActiveSheet()->setCellValue('A10', $u->alamat);
			$object->getActiveSheet()->setCellValue('C'.($lastRow+3), 'MENGETAHUI');
			$object->getActiveSheet()->setCellValue('C'.($lastRow+4), 'KEPALA KEPOLISIAN RESORT');
			$object->getActiveSheet()->setCellValue('C'.($lastRow+5), $u->satker);
			$object->getActiveSheet()->setCellValue('C'.($lastRow+9), $u->nama_kepala);
			$object->getActiveSheet()->setCellValue('C'.($lastRow+10), $u->jabatan_kepala.' NRP '.$u->nrp_kepala);
			$object->getActiveSheet()->setCellValue('F'.($lastRow+3), 'MENGETAHUI');
			$object->getActiveSheet()->setCellValue('F'.($lastRow+4), 'KEPALA SEKSI KEUANGAN');
			$object->getActiveSheet()->setCellValue('F'.($lastRow+5), $u->satker);
			$object->getActiveSheet()->setCellValue('F'.($lastRow+9), $u->nama_keuangan);
			$object->getActiveSheet()->setCellValue('F'.($lastRow+10), $u->jabatan_keuangan.' NRP '.$u->nrp_keuangan);
			
			foreach ($data['PersonilPolri'] as $r){
			
			
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, $r->nama);
			$object->getActiveSheet()->setCellValue('C'.$baris, $r->pangkat.' / '.$r->nrp);
			$object->getActiveSheet()->setCellValue('D'.$baris, $r->jabatan);
			$object->getActiveSheet()->setCellValue('E'.$baris, $r->alamat);
			$object->getActiveSheet()->setCellValue('F'.$baris, $r->pot);
			// $object->getActiveSheet()->setCellValue('G'.$baris, $r->ket);
			

			$baris++;
		}
		 	$object->getActiveSheet()->getStyle('B'.($baris+2).':J'.($baris+2))->applyFromArray($styleArray);
		 	$object->getActiveSheet()->getStyle('C'.($lastRow+9))->applyFromArray($stylettd);
	    	$object->getActiveSheet()->getStyle('F'.($lastRow+9))->applyFromArray($stylettd);
		 	$object->getActiveSheet()->getStyle('A'.($lastRow+3).':F'.($lastRow+10))->applyFromArray($style);
			
		}elseif ($this->session->userdata('level') == 'admin'){
			$data['PersonilPolri'] = $this->Model_personilpolri->tampil_admin()->result();
			$sheets = $object->setActiveSheetIndex(0);
			$sheets->setTitle("PERSONIL BRMSLH ".$month);

			$lastRow = 19+count($data['PersonilPolri']);
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
			$object->getActiveSheet()->getStyle('A1')->applyFromArray(array(
			        'alignment' => array(
		       		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
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


		foreach ($data['PersonilPolri'] as $r){
			
			
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, $r->nama);
			$object->getActiveSheet()->setCellValue('C'.$baris, $r->pangkat.' / '.$r->nrp);
			$object->getActiveSheet()->setCellValue('D'.$baris, $r->jabatan);
			$object->getActiveSheet()->setCellValue('E'.$baris, $r->alamat);
			$object->getActiveSheet()->setCellValue('F'.$baris, $r->pot);
			// $object->getActiveSheet()->setCellValue('G'.$baris, $r->ket);
			

			$baris++;
		}
		 // 	$object->getActiveSheet()->getStyle('B'.($baris+2).':J'.($baris+2))->applyFromArray($styleArray);
		 // 	$object->getActiveSheet()->getStyle('C'.($lastRow+9))->applyFromArray($stylettd);
	  //   	$object->getActiveSheet()->getStyle('I'.($lastRow+9))->applyFromArray($stylettd);
		 // 	$object->getActiveSheet()->getStyle('A'.($lastRow+3).':I'.($lastRow+10))->applyFromArray($style);
			// $object->getActiveSheet()->setCellValue('B'.($baris+2), 'JUMLAH');

			// $object->getActiveSheet()->setCellValue('C'.($baris+2), $data['total_pmnkuat'] = $this->Model_personilpolri->hitungpmnkuatadmin());
			// $object->getActiveSheet()->setCellValue('D'.($baris+2), 		$data['total_pmnpot'] = $this->Model_personilpolri->hitungpmnpotadmin());
			// $object->getActiveSheet()->setCellValue('E'.($baris+2), 		$data['total_pmkuat'] = $this->Model_personilpolri->hitungpmkuatadmin());
			// $object->getActiveSheet()->setCellValue('F'.($baris+2), 		$data['total_pmpot'] = $this->Model_personilpolri->hitungpmpotadmin());
			// $object->getActiveSheet()->setCellValue('G'.($baris+2), 		$data['total_bntrkuat'] = $this->Model_personilpolri->hitungbntrkuatadmin());
			// $object->getActiveSheet()->setCellValue('H'.($baris+2), 		$data['total_bntrpot'] = $this->Model_personilpolri->hitungbntrpotadmin());
			// $object->getActiveSheet()->setCellValue('I'.($baris+2), 		$data['total_jmlhkuat'] = $this->Model_personilpolri->hitungjmlkuatadmin());
			// $object->getActiveSheet()->setCellValue('J'.($baris+2), 		$data['total_jmlhpot'] = $this->Model_personilpolri->hitungjmlpotadmin());
		}	

		$object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$object->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$object->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$object->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('G')->setWidth(30);

		

	    $object->getActiveSheet()->getStyle('A1:R'.$lastRow)->applyFromArray($style);
	    $object->getActiveSheet()->getStyle('A17:G17')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('A13')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('A14')->applyFromArray($stylettd);
	    $object->getActiveSheet()->getStyle('A10')->getFont()->setUnderline(true);


		$object->getActiveSheet()->mergeCells('A1:C7');
		$object->getActiveSheet()->mergeCells('A8:C8');
		$object->getActiveSheet()->mergeCells('A9:C9');
		$object->getActiveSheet()->mergeCells('A10:C10');
		$object->getActiveSheet()->mergeCells('A13:G13');
		$object->getActiveSheet()->mergeCells('A14:G14');

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
		$object->getActiveSheet()->setCellValue('A13', 'LIST ANGGOTA RUMAH DINAS PORLI');
		$object->getActiveSheet()->setCellValue('A14', 'BULAN : '.$month);
		$object->getActiveSheet()->setCellValue('A17', 'NO');
		$object->getActiveSheet()->setCellValue('B17', 'NAMA');
		$object->getActiveSheet()->setCellValue('C17', 'PANGKAT / NRP');
		$object->getActiveSheet()->setCellValue('D17', 'JABATAN');
		$object->getActiveSheet()->setCellValue('E17', 'ALAMAT');
		$object->getActiveSheet()->setCellValue('F17', 'POT');
		$object->getActiveSheet()->setCellValue('G17', 'KETERANGAN');
		$object->getActiveSheet()->setCellValue('G16', '(POLRI)');


			
		return $object;
	}

	public function pns_excel($object){
		$month = date('F, Y');
		$BULAN = date('F');
		$year = date('Y');
		$b = $this->input->post('bulan');
		if ($this->session->userdata('level') == 'satker'){
			$where = $this->session->userdata('id_satker');
			$data['PersonilPns'] = $this->db->query("SELECT * FROM tb_personilpns,tb_pangkat WHERE tb_personilpns.id_satker = $where AND tb_pangkat.id_pangkat = tb_personilpns.pangkat AND tb_personilpns.bulan like '%".$b."%' ")->result();
			$user['user'] = $this->Model_user->tampil_data()->result();
			$object->createSheet();
			$sheets = $object->setActiveSheetIndex(1);
			$sheets->setTitle("PERSONIL RD PNS".$month);
			$sess_data = $this->session->userdata('id_satker');
			$u = $this->db->query('SELECT * FROM tb_user WHERE id_satker = '.$sess_data)->row();
			$lastRow = 19+count($data['PersonilPns']);
			$baris = 18;
			$no = 1;

			$object->getActiveSheet()->getStyle('A17:G'.$lastRow.'')->applyFromArray(array(
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

			$object->getActiveSheet()->setCellValue('A9', 'RESORT '.$u->satker);
			$object->getActiveSheet()->setCellValue('A10', $u->alamat);
			$object->getActiveSheet()->setCellValue('C'.($lastRow+3), 'MENGETAHUI');
			$object->getActiveSheet()->setCellValue('C'.($lastRow+4), 'KEPALA KEPOLISIAN RESORT');
			$object->getActiveSheet()->setCellValue('C'.($lastRow+5), $u->satker);
			$object->getActiveSheet()->setCellValue('C'.($lastRow+9), $u->nama_kepala);
			$object->getActiveSheet()->setCellValue('C'.($lastRow+10), $u->jabatan_kepala.' NRP '.$u->nrp_kepala);
			$object->getActiveSheet()->setCellValue('F'.($lastRow+3), 'MENGETAHUI');
			$object->getActiveSheet()->setCellValue('F'.($lastRow+4), 'KEPALA SEKSI KEUANGAN');
			$object->getActiveSheet()->setCellValue('F'.($lastRow+5), $u->satker);
			$object->getActiveSheet()->setCellValue('F'.($lastRow+9), $u->nama_keuangan);
			$object->getActiveSheet()->setCellValue('F'.($lastRow+10), $u->jabatan_keuangan.' NRP '.$u->nrp_keuangan);
			
			foreach ($data['PersonilPns'] as $r){
			
			
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, $r->nama);
			$object->getActiveSheet()->setCellValue('C'.$baris, $r->pangkat.' / '.$r->nrp);
			$object->getActiveSheet()->setCellValue('D'.$baris, $r->jabatan);
			$object->getActiveSheet()->setCellValue('E'.$baris, $r->alamat);
			$object->getActiveSheet()->setCellValue('F'.$baris, $r->pot);
			// $object->getActiveSheet()->setCellValue('G'.$baris, $r->ket);
			

			$baris++;
		}
		 	$object->getActiveSheet()->getStyle('B'.($baris+2).':J'.($baris+2))->applyFromArray($styleArray);
		 	$object->getActiveSheet()->getStyle('C'.($lastRow+9))->applyFromArray($stylettd);
	    	$object->getActiveSheet()->getStyle('F'.($lastRow+9))->applyFromArray($stylettd);
		 	$object->getActiveSheet()->getStyle('A'.($lastRow+3).':F'.($lastRow+10))->applyFromArray($style);
			
		}elseif ($this->session->userdata('level') == 'admin'){
			$where = array('id_satker' => $this->session->userdata('id_satker'));
			$data['PersonilPns'] = $this->db->query("SELECT * FROM tb_personilpns,tb_pangkat WHERE tb_personilpns.id_satker = $where AND tb_pangkat.id_pangkat = tb_personilpns.pangkat AND tb_personilpns.bulan like '%".$b."%' ")->result();
			$sheets = $object->setActiveSheetIndex(0);
			$sheets->setTitle("PERSONIL BRMSLH ".$month);

			$lastRow = 19+count($data['PersonilPns']);
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
			$object->getActiveSheet()->getStyle('A1')->applyFromArray(array(
			        'alignment' => array(
		       		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
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


		foreach ($data['PersonilPns'] as $r){
			
			
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, $r->nama);
			$object->getActiveSheet()->setCellValue('C'.$baris, $r->pangkat.' / '.$r->pangkat);
			$object->getActiveSheet()->setCellValue('D'.$baris, $r->jabatan);
			$object->getActiveSheet()->setCellValue('E'.$baris, $r->alamat);
			$object->getActiveSheet()->setCellValue('F'.$baris, $r->pot);
			// $object->getActiveSheet()->setCellValue('G'.$baris, $r->ket);
			

			$baris++;
		}
		 // 	$object->getActiveSheet()->getStyle('B'.($baris+2).':J'.($baris+2))->applyFromArray($styleArray);
		 // 	$object->getActiveSheet()->getStyle('C'.($lastRow+9))->applyFromArray($stylettd);
	  //   	$object->getActiveSheet()->getStyle('I'.($lastRow+9))->applyFromArray($stylettd);
		 // 	$object->getActiveSheet()->getStyle('A'.($lastRow+3).':I'.($lastRow+10))->applyFromArray($style);
			// $object->getActiveSheet()->setCellValue('B'.($baris+2), 'JUMLAH');

			// $object->getActiveSheet()->setCellValue('C'.($baris+2), $data['total_pmnkuat'] = $this->Model_personilpolri->hitungpmnkuatadmin());
			// $object->getActiveSheet()->setCellValue('D'.($baris+2), 		$data['total_pmnpot'] = $this->Model_personilpolri->hitungpmnpotadmin());
			// $object->getActiveSheet()->setCellValue('E'.($baris+2), 		$data['total_pmkuat'] = $this->Model_personilpolri->hitungpmkuatadmin());
			// $object->getActiveSheet()->setCellValue('F'.($baris+2), 		$data['total_pmpot'] = $this->Model_personilpolri->hitungpmpotadmin());
			// $object->getActiveSheet()->setCellValue('G'.($baris+2), 		$data['total_bntrkuat'] = $this->Model_personilpolri->hitungbntrkuatadmin());
			// $object->getActiveSheet()->setCellValue('H'.($baris+2), 		$data['total_bntrpot'] = $this->Model_personilpolri->hitungbntrpotadmin());
			// $object->getActiveSheet()->setCellValue('I'.($baris+2), 		$data['total_jmlhkuat'] = $this->Model_personilpolri->hitungjmlkuatadmin());
			// $object->getActiveSheet()->setCellValue('J'.($baris+2), 		$data['total_jmlhpot'] = $this->Model_personilpolri->hitungjmlpotadmin());
		}	

		$object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$object->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$object->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$object->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('G')->setWidth(30);

		

	    $object->getActiveSheet()->getStyle('A1:R'.$lastRow)->applyFromArray($style);
	    $object->getActiveSheet()->getStyle('A17:G17')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('A13')->applyFromArray($styleArray);
	    $object->getActiveSheet()->getStyle('A14')->applyFromArray($stylettd);
	    $object->getActiveSheet()->getStyle('A10')->getFont()->setUnderline(true);


		$object->getActiveSheet()->mergeCells('A1:C7');
		$object->getActiveSheet()->mergeCells('A8:C8');
		$object->getActiveSheet()->mergeCells('A9:C9');
		$object->getActiveSheet()->mergeCells('A10:C10');
		$object->getActiveSheet()->mergeCells('A13:G13');
		$object->getActiveSheet()->mergeCells('A14:G14');

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
		$object->getActiveSheet()->setCellValue('A13', 'LIST ANGGOTA RUMAH DINAS PNS');
		$object->getActiveSheet()->setCellValue('A14', 'BULAN : '.$month);
		$object->getActiveSheet()->setCellValue('A17', 'NO');
		$object->getActiveSheet()->setCellValue('B17', 'NAMA');
		$object->getActiveSheet()->setCellValue('C17', 'PANGKAT / NRP');
		$object->getActiveSheet()->setCellValue('D17', 'JABATAN');
		$object->getActiveSheet()->setCellValue('E17', 'ALAMAT');
		$object->getActiveSheet()->setCellValue('F17', 'POT');
		$object->getActiveSheet()->setCellValue('G17', 'KETERANGAN');
		$object->getActiveSheet()->setCellValue('G16', '(PNS)');


			
		return $object;
	}

}

?>