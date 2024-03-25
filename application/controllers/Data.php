<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	function __construct(){
	 parent::__construct();
	 	//validasi jika user belum login
     $this->data['CI'] =& get_instance();
     $this->load->helper(array('form', 'url'));
     $this->load->model('M_Admin');
		if($this->session->userdata('masuk_perpus') != TRUE){
				$url=base_url('login');
				redirect($url);
		}
	}

	public function index()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['gadget'] =  $this->db->query("SELECT * FROM tbl_gadget ORDER BY id_gadget DESC");
        $this->data['title_web'] = 'Data gadget';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('gadget/gadget_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function gadgetdetail()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$count = $this->M_Admin->CountTableId('tbl_gadget','id_gadget',$this->uri->segment('3'));
		if($count > 0)
		{
			$this->data['gadget'] = $this->M_Admin->get_tableid_edit('tbl_gadget','id_gadget',$this->uri->segment('3'));
		
		}else{
			echo '<script>alert("gadget TIDAK DITEMUKAN");window.location="'.base_url('data').'"</script>';
		}

		$this->data['title_web'] = 'Data Detail Gadget';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('gadget/detail',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function gadgetedit()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$count = $this->M_Admin->CountTableId('tbl_gadget','id_gadget',$this->uri->segment('3'));
		if($count > 0)
		{
			
			$this->data['gadget'] = $this->M_Admin->get_tableid_edit('tbl_gadget','id_gadget',$this->uri->segment('3'));
	   
		}else{
			echo '<script>alert("gadget TIDAK DITEMUKAN");window.location="'.base_url('data').'"</script>';
		}

		$this->data['title_web'] = 'Data gadget Edit';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('gadget/edit_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function gadgettambah()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');

        $this->data['title_web'] = 'Tambah gadget';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('gadget/tambah_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}


	public function prosesgadget()
	{
		if($this->session->userdata('masuk_perpus') != TRUE){
			$url=base_url('login');
			redirect($url);
		}

		// hapus aksi form proses gadget
		if(!empty($this->input->get('gadget_id')))
		{
        
			$gadget = $this->M_Admin->get_tableid_edit('tbl_gadget','id_gadget',htmlentities($this->input->get('gadget_id')));
			$this->M_Admin->delete_table('tbl_gadget','id_gadget',$this->input->get('gadget_id'));
			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
					<p> Berhasil Hapus gadget !</p>
				</div></div>');
			redirect(base_url('data'));  
		}

		// tambah aksi form proses gadget
		if(!empty($this->input->post('tambah')))
		{
			$post= $this->input->post();
			$gadget_id = $this->M_Admin->buat_kode('tbl_gadget','BK','id_gadget','ORDER BY id_gadget DESC LIMIT 1'); 
			$data = array(
				'gadget_id'=>$gadget_id,
				'title'  => htmlentities($post['title']), 
				'warna'=> htmlentities($post['warna']),    
				'jml'=> htmlentities($post['jml']),  
				'tgl_masuk' => date('Y-m-d H:i:s')
			);


			$this->db->insert('tbl_gadget', $data);

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah gadget Sukses !</p>
			</div></div>');
			redirect(base_url('data')); 
		}

		// edit aksi form proses gadget
		if(!empty($this->input->post('edit')))
		{
			$post = $this->input->post();
			$data = array(
				'title'  => htmlentities($post['title']),
				'warna'=> htmlentities($post['warna']),  
				'jml'=> htmlentities($post['jml']),  
				'tgl_masuk' => date('Y-m-d H:i:s')
			);

			$this->db->where('id_gadget',htmlentities($post['edit']));
			$this->db->update('tbl_gadget', $data);

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
					<p> Edit gadget Sukses !</p>
				</div></div>');
			redirect(base_url('data')); 
		}
	}

	
}
