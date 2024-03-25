<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
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
        $this->data['user'] = $this->M_Admin->get_table('tbl_karyawan');

        $this->data['title_web'] = 'Data User ';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('user/user_view',$this->data);
        $this->load->view('footer_view',$this->data);
    }

	public function historikaryawan_view()
    {	
        $this->data['idbo'] = $this->session->userdata('ses_id');
        $this->data['user'] = $this->M_Admin->get_table('tbl_historikaryawan');

        $this->data['title_web'] = 'Data Histori Karyawan ';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('historiKaryawan/user_view',$this->data);
        $this->load->view('footer_view',$this->data);
    }

    public function tambah()
    {	
        $this->data['idbo'] = $this->session->userdata('ses_id');
        $this->data['user'] = $this->M_Admin->get_table('tbl_karyawan');
        
        $this->data['title_web'] = 'Tambah User ';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('user/tambah_view',$this->data);
        $this->load->view('footer_view',$this->data);
    }

	public function add()
    {
		// format tabel / kode baru 3 hurup / id tabel / order by limit ngambil data terakhir
		
		
		$id = htmlentities($this->input->post('EmpID',TRUE));
        $nama = htmlentities($this->input->post('InternalDisplayName',TRUE));
		$position = htmlentities($this->input->post('Position',TRUE));
        $department = htmlentities($this->input->post('Department',TRUE));
        $divisi = htmlentities($this->input->post('CostCenter',TRUE));
	
		
		$dd = $this->db->query("SELECT * FROM tbl_karyawan WHERE EmpID = '$id'"); 
		
            $data = array(
				'EmpID' => $id,
                'InternalDisplayName'=>$nama,
                'Position'=>$position,
                'Department'=>$department,
                'CostCenter'=>$divisi,
                'tgl_bergabung'=>date('Y-m-d')
            );
			$this->db->insert('tbl_karyawan',$data);
			
            $this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
            <p> Daftar User telah berhasil !</p>
            </div></div>');
			redirect(base_url('user'));
		    
      
    }


    public function edit()
    {	
		if($this->session->userdata('level') == 'Petugas'){
			if($this->uri->segment('3') == ''){ echo '<script>alert("halaman tidak ditemukan");window.location="'.base_url('user').'";</script>';}
			$this->data['idbo'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_karyawan','EmpID',$this->uri->segment('3'));
			if($count > 0)
			{			
				$this->data['user'] = $this->M_Admin->get_tableid_edit('tbl_karyawan','EmpID',$this->uri->segment('3'));
			}else{
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="'.base_url('user').'"</script>';
			}
			
		}elseif($this->session->userdata('level') == 'Anggota'){
			$this->data['idbo'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_karyawan','EmpID',$this->uri->segment('3'));
			if($count > 0)
			{			
				$this->data['user'] = $this->M_Admin->get_tableid_edit('tbl_karyawan','EmpID',$this->session->userdata('ses_id'));
			}else{
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="'.base_url('user').'"</script>';
			}
		}
        $this->data['title_web'] = 'Edit User ';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('user/edit_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}
	
	public function detail()
    {	
		if($this->session->userdata('level') == 'Petugas'){
			if($this->uri->segment('3') == ''){ echo '<script>alert("halaman tidak ditemukan");window.location="'.base_url('user').'";</script>';}
			$this->data['idbo'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_karyawan','EmpID',$this->uri->segment('3'));
			if($count > 0)
			{			
				$this->data['user'] = $this->M_Admin->get_tableid_edit('tbl_karyawan','EmpID',$this->uri->segment('3'));
			}else{
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="'.base_url('user').'"</script>';
			}		
		}elseif($this->session->userdata('level') == 'Anggota'){
			$this->data['idbo'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_karyawan','EmpID',$this->session->userdata('ses_id'));
			if($count > 0)
			{			
				$this->data['user'] = $this->M_Admin->get_tableid_edit('tbl_karyawan','EmpID',$this->session->userdata('ses_id'));
			}else{
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="'.base_url('user').'"</script>';
			}
		}
        $this->data['title_web'] = 'Print Kartu Anggota ';
        $this->load->view('user/detail',$this->data);
    }

   
	public function upd()
	{
		$EmpID = htmlentities($this->input->post('EmpID', TRUE));
		$nama = htmlentities($this->input->post('InternalDisplayName', TRUE));
		$position = htmlentities($this->input->post('Position', TRUE));
		$department = htmlentities($this->input->post('Department'));
		$divisi = htmlentities($this->input->post('CostCenter', TRUE));
	
		$data = array(
			'EmpID' => $EmpID,
			'InternalDisplayName' => $nama,
			'Position' => $position,
			'Department' => $department,
			'CostCenter' => $divisi,
		);
	
		var_dump($EmpID, $nama, $position, $department, $divisi);
	
		$result_update = $this->M_Admin->update_table('tbl_karyawan', 'No', $this->input->post('No', TRUE), $data);
	
		echo $this->db->last_query(); 
    if ($result_update) {
        $success_message = 'Berhasil Update User: ' . $nama . ' !';
        $level = $this->session->userdata('level');

        $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
            <p>' . $success_message . '</p>
        </div></div>');

        if ($level == 'Petugas') {
            redirect(base_url('user'));
        } elseif ($level == 'Anggota') {
            redirect(base_url('user/edit/' . $this->input->post('Nomor', TRUE)));
        }
    } else {
        $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-danger">
            <p>Gagal melakukan pembaruan data.</p>
        </div></div>');
        redirect(base_url('user'));
    }
}


    public function del()
    {
        if($this->uri->segment('3') == ''){ echo '<script>alert("halaman tidak ditemukan");window.location="'.base_url('user').'";</script>';}
        
        $user = $this->M_Admin->get_tableid_edit('tbl_karyawan','EmpID',$this->uri->segment('3'));
        unlink('./assets_style/image/'.$user->foto);
		$this->M_Admin->delete_table('tbl_karyawan','EmpID',$this->uri->segment('3'));
		
		$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
		<p> Berhasil Hapus User !</p>
		</div></div>');
		redirect(base_url('user'));  
    }
	public function delhistori()
    {
        if($this->uri->segment('3') == ''){ echo '<script>alert("halaman tidak ditemukan");window.location="'.base_url('user').'";</script>';}
        
        $user = $this->M_Admin->get_tableid_edit('tbl_karyawan','EmpID',$this->uri->segment('3'));
        unlink('./assets_style/image/'.$user->foto);
		$this->M_Admin->delete_table('tbl_historikaryawan','EmpID',$this->uri->segment('3'));
		
		$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
		<p> Berhasil Hapus Data Histori Karyawan !</p>
		</div></div>');
		redirect(base_url('user'));  
    }

	
}
