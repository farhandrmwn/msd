<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tampil extends CI_Controller {

	public function admin()
	{
       $data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
		$this->load->view('personil/v_tampiladmin',$data);
	}

	public function rdpolri()
	{
       $data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
		$this->load->view('rdpolri/v_tampiladmin',$data);
	}

	public function rdpnspolri()
	{
       $data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
		$this->load->view('rdpnspolri/v_tampiladmin',$data);
	}

	public function personilpolri()
	{
       $data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
		$this->load->view('personilpolri/v_tampiladmin',$data);
	}

	public function personilpns()
	{
       $data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
		$this->load->view('personilpns/v_tampiladmin',$data);
	}

	public function mutdat()
	{
       $data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
       $data['mutdat'] = $this->db->query("SELECT * FROM tb_mutdat ")->result();
		$this->load->view('mutdat/v_tampiladmin',$data);
	}

	public function rekap_personil()
	{
       $data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
		$this->load->view('rekap_personil/v_tampiladmin',$data);
	}

	public function rekap_rumdin()
	{
       $data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
		$this->load->view('rekap_rumdin/v_pilih',$data);
	}

	public function rekap_rumdin_polri()
	{
       $data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
		$this->load->view('rekap_rumdin/v_tampilpolri',$data);
	}

	public function rekap_rumdin_pns()
	{
       $data['satker'] = $this->db->query("SELECT * FROM tb_user ")->result();
		$this->load->view('rekap_rumdin/v_tampilpns',$data);
	}



}
