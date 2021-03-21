<?php 


class PersonilPns extends CI_Controller{

	function __construct(){
		parent::__construct();		
		$this->load->model('Model_personilpns');
		$this->load->model('Model_user');
		$this->load->helper('url');
		$this->load->model('Model_rdpnspolri');
 
	}
 
function index(){
		$waktu = $this->db->query("SELECT * FROM tb_personilpns GROUP BY bulan ")->result();
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
			$this->db->update('tb_personilpns', $data);

        }
		
		$user['user'] = $this->Model_user->tampil_data()->result();

		$b = $this->input->post('bulan');
		$t = $this->input->post('tahun');

        $data['b'] = $b;
		$data['t'] = $t;

		$data['personilpns'] = $this->db->query("SELECT * FROM tb_personilpns WHERE id_satker = '$where' AND bulan like '%".$b.$t."%' ")->result();

		$this->load->view('PersonilPns/v_tampil',$data);
	}
	
	function pilih(){
		$this->load->view('PersonilPns/v_pilih');
	}
	
	

    public function admin(){
       $data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
       	$satker = $this->input->post('satker');
		$b = $this->input->post('bulan');
		$t = $this->input->post('tahun');


		$data['personilpns'] = $this->db->query("SELECT * FROM tb_personilpns WHERE id_satker = '$satker' AND bulan like '%".$b.$t."%' ")->result();
		$this->load->view('PersonilPns/v_admin',$data);
	}
 
	function tambah(){
		$this->load->view('PersonilPns/v_input');
	}

	function hapus($id){
		$where = array('id' => $id);
		$this->Model_personilpns->hapus_data($where,'tb_personilpns');
		redirect('PersonilPns');
	}

	function edit($id){
		$where = array('id' => $id);
		$data['personilpns'] = $this->Model_personilpns->edit_data($where,'tb_personilpns')->result();
		$this->load->view('PersonilPns/v_edit',$data);
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
	 
		$this->Model_personilpns->update_data($where,$data,'tb_personilpns');
		redirect('PersonilPns');
}

    public function hapusdata($id)
	{
		$b = $this->input->post('bulan');
		$stk = $this->session->userdata('id_satker');
		$where = array('id' => $id);
		$q = $this->db->query("SELECT * FROM tb_personilpns WHERE id = '$id' AND id_satker = '$stk' AND bulan like '%".$b."%'  ")->result();
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
	 
		$this->Model_personilpns->update_data($where,$data,'tb_personilpns');
		redirect('PersonilPns/pilih');

		

	}

	function tambah_aksi(){
		$where = $this->session->userdata('id_satker');
		$nama = $this->input->post('nama');
		$nrp = $this->input->post('nrp');
		$pangkat = $this->input->post('pangkat');	
		$jabatan = $this->input->post('jabatan');
		$alamat = $this->input->post('alamat');
		$pot = $this->input->post('pot');
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

		$this->Model_personilpns->input_data($data,'tb_personilpns');
		redirect('PersonilPns');
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
		if ($this->session->userdata('level') == 'satker'){
			$where = array('id_satker' => $this->session->userdata('id_satker'));
			$data['personilpns'] = $this->Model_personilpns->tampil_data($where,'tb_personilpns')->result();
			$user['user'] = $this->Model_user->tampil_data()->result();
			$sheets = $object->setActiveSheetIndex(0);
			$sheets->setTitle("POLRI ".$month);
			$sess_data = $this->session->userdata('id_satker');
			$u = $this->db->query('SELECT * FROM tb_user WHERE id_satker = '.$sess_data)->row();
			$lastRow = 22+count($data['personilpns']);
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
			
			foreach ($data['personilpns'] as $r){
			
			
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, $r->satker);
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

			$object->getActiveSheet()->setCellValue('C'.($baris+2), $data['total_pmnkuat'] = $this->Model_personilpns->hitungpmnkuat($where,'tb_personilpns'));
			$object->getActiveSheet()->setCellValue('D'.($baris+2), 		$data['total_pmnpot'] = $this->Model_personilpns->hitungpmnpot($where,'tb_personilpns'));
			$object->getActiveSheet()->setCellValue('E'.($baris+2), 		$data['total_pmkuat'] = $this->Model_personilpns->hitungpmkuat($where,'tb_personilpns'));
			$object->getActiveSheet()->setCellValue('F'.($baris+2), 		$data['total_pmpot'] = $this->Model_personilpns->hitungpmpot($where,'tb_personilpns'));
			$object->getActiveSheet()->setCellValue('G'.($baris+2), 		$data['total_bntrkuat'] = $this->Model_personilpns->hitungbntrkuat($where,'tb_personilpns'));
			$object->getActiveSheet()->setCellValue('H'.($baris+2), 		$data['total_bntrpot'] = $this->Model_personilpns->hitungbntrpot($where,'tb_personilpns'));
			$object->getActiveSheet()->setCellValue('I'.($baris+2), 		$data['total_jmlhkuat'] = $this->Model_personilpns->hitungjmlkuat($where,'tb_personilpns'));
			$object->getActiveSheet()->setCellValue('J'.($baris+2), 		$data['total_jmlhpot'] = $this->Model_personilpns->hitungjmlpot($where,'tb_personilpns'));
		}elseif ($this->session->userdata('level') == 'admin'){
			$data['personilpns'] = $this->Model_personilpns->tampil_admin()->result();
			$sheets = $object->setActiveSheetIndex(0);
			$sheets->setTitle("PERSONIL BRMSLH ".$month);

			$lastRow = 22+count($data['personilpns']);
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


		foreach ($data['personilpns'] as $r){
			
			
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, $r->satker);
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

			$object->getActiveSheet()->setCellValue('C'.($baris+2), $data['total_pmnkuat'] = $this->Model_personilpns->hitungpmnkuatadmin());
			$object->getActiveSheet()->setCellValue('D'.($baris+2), 		$data['total_pmnpot'] = $this->Model_personilpns->hitungpmnpotadmin());
			$object->getActiveSheet()->setCellValue('E'.($baris+2), 		$data['total_pmkuat'] = $this->Model_personilpns->hitungpmkuatadmin());
			$object->getActiveSheet()->setCellValue('F'.($baris+2), 		$data['total_pmpot'] = $this->Model_personilpns->hitungpmpotadmin());
			$object->getActiveSheet()->setCellValue('G'.($baris+2), 		$data['total_bntrkuat'] = $this->Model_personilpns->hitungbntrkuatadmin());
			$object->getActiveSheet()->setCellValue('H'.($baris+2), 		$data['total_bntrpot'] = $this->Model_personilpns->hitungbntrpotadmin());
			$object->getActiveSheet()->setCellValue('I'.($baris+2), 		$data['total_jmlhkuat'] = $this->Model_personilpns->hitungjmlkuatadmin());
			$object->getActiveSheet()->setCellValue('J'.($baris+2), 		$data['total_jmlhpot'] = $this->Model_personilpns->hitungjmlpotadmin());
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

		$object->getActiveSheet()->setCellValue('A8', 'KEPOLISIAN DAERAH SUMATERA SELATAN');
		$object->getActiveSheet()->setCellValue('A13', 'LAPORAN POTONGAN SEWA RUMAH DINAS POLRI');
		$object->getActiveSheet()->setCellValue('A14', 'BULAN : '.$month);
		$object->getActiveSheet()->setCellValue('A17', 'NO');
		$object->getActiveSheet()->setCellValue('B17', 'SATKER');
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


			
		return $object;
	}

	public function pns_excel($object){
		$month = date('F, Y');
		$BULAN = date('F');
		$year = date('Y');
		if ($this->session->userdata('level') == 'satker'){
		$where = array('id_satker' => $this->session->userdata('id_satker'));
		$data['rdpnspolri'] = $this->Model_rdpnspolri->tampil_data($where , 'tb_potongan_pns')->result();
		$user['user'] = $this->Model_user->tampil_data()->result();
		$object->createSheet();
		$sheets = $object->setActiveSheetIndex(1);
		$sheets->setTitle("PNS POLRI ".$month);
		$sess_data = $this->session->userdata("id_satker");
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
			$object->getActiveSheet()->setCellValue('C'.($baris+2), $data['total_gol4kuat'] = $this->Model_rdpnspolri->hitunggol4kuat($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('D'.($baris+2), 		$data['total_gol4pot'] = $this->Model_rdpnspolri->hitunggol4pot($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('E'.($baris+2), 		$data['total_gol3kuat'] = $this->Model_rdpnspolri->hitunggol3kuat($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('F'.($baris+2), 		$data['total_gol3pot'] = $this->Model_rdpnspolri->hitunggol3pot($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('G'.($baris+2), 		$data['total_gol2kuat'] = $this->Model_rdpnspolri->hitunggol2kuat($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('H'.($baris+2), 		$data['total_gol2pot'] = $this->Model_rdpnspolri->hitunggol2pot($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('I'.($baris+2), 		$data['total_jmlhkuat'] = $this->Model_rdpnspolri->hitungjmlkuat($where,'tb_potongan_pns'));
			$object->getActiveSheet()->setCellValue('J'.($baris+2), 		$data['total_jmlhpot'] = $this->Model_rdpnspolri->hitungjmlpot($where,'tb_potongan_pns'));





		}elseif ($this->session->userdata('level') == 'admin'){
			$data['rdpnspolri'] = $this->Model_rdpnspolri->tampil_admin()->result();
			$object->createSheet();
			$sheets = $object->setActiveSheetIndex(1);
			$sheets->setTitle("PNS POLRI ".$month);

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

		$object->getActiveSheet()->setCellValue('A8', 'KEPOLISIAN DAERAH SUMATERA SELATAN');
		$object->getActiveSheet()->setCellValue('A13', 'LAPORAN POTONGAN SEWA RUMAH DINAS POLRI');
		$object->getActiveSheet()->setCellValue('A14', 'BULAN : '.$month);
		$object->getActiveSheet()->setCellValue('A17', 'NO');
		$object->getActiveSheet()->setCellValue('B17', 'SATKER');
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

		
		return $object;
	}

}

?>