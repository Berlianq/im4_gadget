<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Transaksi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		//validasi jika user belum login
		$this->data['CI'] = &get_instance();
		$this->load->helper(array('form', 'url'));
		$this->load->model('M_Admin');
		$this->load->library(array('cart'));
		if ($this->session->userdata('masuk_perpus') != TRUE) {
			$url = base_url('login');
			redirect($url);
		}
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{
		$this->data['title_web'] = 'Data Pemberian Gadget ';
		$this->data['idbo'] = $this->session->userdata('ses_id');

		if ($this->session->userdata('level') == 'Anggota') {
			$this->data['pinjam'] = $this->db->query(
				"SELECT DISTINCT `pinjam_id`, `NIP`, 
				`status`, `tgl_pinjam`, `tgl_kembali` ,`MAC`
				FROM tbl_pinjam WHERE status = 'Dipinjam' 
				AND NIP = ? ORDER BY pinjam_id DESC",
				array($this->session->userdata('NIP'))
			);
		} else {
			$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, `NIP`, 
				`status`, `tgl_pinjam`, `tgl_kembali` ,`MAC`
				FROM tbl_pinjam WHERE status = 'Dipinjam' ORDER BY pinjam_id DESC");
		}

		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('pinjam/pinjam_view', $this->data);
		$this->load->view('footer_view', $this->data);
	}

	public function kembali()
	{
		$this->data['title_web'] = 'Data Pengembalian Gadget ';
		$this->data['idbo'] = $this->session->userdata('ses_id');

		if ($this->session->userdata('level') == 'Anggota') {
			$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, `NIP`, 
				`status`, `tgl_pinjam`, `tgl_kembali` 
				FROM tbl_pinjam WHERE NIP = ? AND (status = 'Di Kembalikan' OR status = 'Tidak Lengkap'OR status = 'Tidak Lengka') 
				ORDER BY id_pinjam DESC", array($this->session->userdata('NIP')));
		} else {
			$this->data['pinjam'] = $this->db->query("SELECT DISTINCT  `id_pinjam`,`pinjam_id`, `NIP`, 
				`status`, `tgl_pinjam`, `tgl_kembali` 
				FROM tbl_pinjam WHERE (status = 'Di Kembalikan' OR status = 'Tidak Lengkap'OR status = 'Tidak Lengka')  ORDER BY id_pinjam DESC");
		}

		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('kembali/home', $this->data);
		$this->load->view('footer_view', $this->data);
	}

	public function penggantian()
	{
		$this->data['title_web'] = 'Data Penggantian Gadget ';
		$this->data['idbo'] = $this->session->userdata('ses_id');

		if ($this->session->userdata('level') == 'Anggota') {
			$this->data['pinjam'] = $this->db->query(
				"SELECT DISTINCT `histori_id`,`pinjam_id`, `NIP`, 
				`status`, `tgl_pinjam`, `tgl_edit`, `MAC`
				FROM tbl_historiPenggantian WHERE status = 'Dipinjam' 
				AND NIP = ? ORDER BY pinjam_id DESC",
				array($this->session->userdata('NIP'))
			);
		} else {
			$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `histori_id`,`pinjam_id`, `NIP`, 
			`status`, `tgl_pinjam`, `tgl_edit`, `MAC`
				FROM tbl_historiPenggantian WHERE status = 'Dipinjam' ORDER BY pinjam_id DESC");
		}

		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('penggantian/penggantian_view', $this->data);
		$this->load->view('footer_view', $this->data);

		if ($this->input->get('histori_id')) {
			$this->M_Admin->delete_table('tbl_historipenggantian', 'histori_id', $this->input->get('histori_id'));

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-warning">
			<p>  Hapus Transaksi Penggantian Gadget Sukses !</p>
			</div></div>');
			redirect(base_url('transaksi'));
		}
		if ($this->input->get('cetak')) {
		}
	}


	public function pinjam()
	{

		$this->data['nop'] = $this->M_Admin->buat_kode('tbl_pinjam', 'PJ', 'id_pinjam', 'ORDER BY id_pinjam DESC LIMIT 1');
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['user'] = $this->M_Admin->get_table('tbl_login');
		$this->data['gadget'] =  $this->db->query("SELECT * FROM tbl_gadget ORDER BY id_gadget DESC");

		$this->data['title_web'] = 'Tambah Pemberian Gadget ';

		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('pinjam/tambah_view', $this->data);
		$this->load->view('footer_view', $this->data);
	}

	public function detailpinjam()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');

		$id = $this->uri->segment('3');
		if ($this->session->userdata('level') == 'Anggota') {
			$count = $this->db->get_where('tbl_pinjam', [
				'pinjam_id' => $id,
				'NIP' => $this->session->userdata('NIP')
			])->num_rows();
			if ($count > 0) {
				$this->data['pinjam'] = $this->db->query(
					"SELECT DISTINCT `pinjam_id`, 
				`NIP`, `status`, 
				`tgl_pinjam`, `tgl_kembali`,'upd_form'
				FROM tbl_pinjam WHERE pinjam_id = ? 
				AND NIP =?",
					array($id, $this->session->userdata('NIP'))
				)->row();
			} else {
				echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="' . base_url('transaksi') . '"</script>';
			}
		} else {
			$count = $this->M_Admin->CountTableId('tbl_pinjam', 'pinjam_id', $id);
			if ($count > 0) {
				$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, 
				`NIP`, `status`, 
				`tgl_pinjam`, `tgl_kembali`,'upd_form' 
				FROM tbl_pinjam WHERE pinjam_id = '$id'")->row();
			} else {
				echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="' . base_url('transaksi') . '"</script>';
			}
		}
		$this->data['sidebar'] = 'kembali';
		$this->data['title_web'] = 'Detail Pemberian Gadget ';
		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('pinjam/detail', $this->data);
		$this->load->view('footer_view', $this->data);
	}

	public function detailkembali()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');

		$id = $this->uri->segment('3');
		if ($this->session->userdata('level') == 'Anggota') {
			$count = $this->db->get_where('tbl_pinjam', [
				'pinjam_id' => $id,
				'NIP' => $this->session->userdata('NIP')
			])->num_rows();
			if ($count > 0) {
				$this->data['pinjam'] = $this->db->query(
					"SELECT DISTINCT `pinjam_id`, 
				`NIP`, `status`, 
				`tgl_pinjam`, `tgl_kembali`,'upd_form'
				FROM tbl_pinjam WHERE pinjam_id = ? 
				AND NIP =?",
					array($id, $this->session->userdata('NIP'))
				)->row();
			} else {
				echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="' . base_url('transaksi') . '"</script>';
			}
		} else {
			$count = $this->M_Admin->CountTableId('tbl_pinjam', 'pinjam_id', $id);
			if ($count > 0) {
				$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, 
				`NIP`, `status`, 
				`tgl_pinjam`, `tgl_kembali`,'upd_form' 
				FROM tbl_pinjam WHERE pinjam_id = '$id'")->row();
			} else {
				echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="' . base_url('transaksi') . '"</script>';
			}
		}
		$this->data['sidebar'] = 'kembali';
		$this->data['title_web'] = 'Detail Pengembalian Gadget ';
		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('kembali/detail', $this->data);
		$this->load->view('footer_view', $this->data);
	}

	public function kembalipinjam()
	{

		$this->data['idbo'] = $this->session->userdata('ses_id');
		$id = $this->uri->segment('3');
		$count = $this->M_Admin->CountTableId('tbl_pinjam', 'pinjam_id', $id);
		if ($count > 0) {
			$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, 
			`NIP`, `status`, 
			`tgl_pinjam`, `tgl_kembali`, `kelengkapan`,`MAC`
			FROM tbl_pinjam WHERE pinjam_id = '$id'")->row();
		} else {
			echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="' . base_url('transaksi') . '"</script>';
		}


		$this->data['title_web'] = 'Pengembalian Gadget ';
		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('pinjam/kembali', $this->data);
		$this->load->view('footer_view', $this->data);
	}

	public function prosespinjam()
	{
		$post = $this->input->post();
		$mac_address = $this->input->post('MAC');
		$kelengkapan = $this->input->post('kelengkapan');


		if (!empty($post['tambah'])) {
			// Proses upload form
			$nmfile = "user_" . time();
			$config['upload_path'] = './assets_style/image/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = 500; // Ukuran maksimal dalam kilobita (KB)
			$config['file_name'] = $nmfile;

			// Load library upload
			$this->load->library('upload', $config);

			// Melakukan proses upload
			if ($this->upload->do_upload('gambar')) {
				$result1 = $this->upload->data();
				$result = array('gambar' => $result1);
				$data1 = array('upload_data' => $this->upload->data());

				// Lanjutkan dengan proses lainnya
				$tgl = $post['tgl'];
				$tgl2 = date('Y-m-d', strtotime('+' . $post['lama'] . ' days', strtotime($tgl)));

				$hasil_cart = array_values(unserialize($this->session->userdata('cart')));
				foreach ($hasil_cart as $isi) {
					$data[] = array(
						'pinjam_id' => htmlentities($post['nopinjam']),
						'NIP' => htmlentities($post['EmpID']),
						'gadget_id' => $isi['id'],
						'status' => 'Dipinjam',
						'tgl_pinjam' => htmlentities($post['tgl']),
						'tgl_kembali'  => '0',
						'MAC' => $mac_address,
						'kelengkapan' => implode(', ', $kelengkapan),
						'upd_form' => $data1['upload_data']['file_name'],
					);
				}

				$total_array = count($data);
				if ($total_array != 0) {
					$this->db->insert_batch('tbl_pinjam', $data);

					// Menghapus data dalam session 'cart'
					$cart = array_values(unserialize($this->session->userdata('cart')));
					for ($i = 0; $i < count($cart); $i++) {
						unset($cart[$i]);
					}
					$this->session->set_userdata('cart', serialize($cart));
				}

				$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
				<p> Tambah Pemberian Gadget Sukses !</p>
				</div></div>');
				redirect(base_url('transaksi'));
			} else {
				// Jika upload gagal, tampilkan pesan error
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-danger">
				 <p> Upload Gambar Gagal: ' . $error['error'] . '</p>
				 </div></div>');
				redirect(base_url('transaksi'));
			}
		}

		// ... (Sisa kode)


		if ($this->input->get('pinjam_id')) {
			$this->M_Admin->delete_table('tbl_pinjam', 'pinjam_id', $this->input->get('pinjam_id'));

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-warning">
			<p>  Hapus Data Pemberian  atau Pengembalian Gadget Sukses !</p>
			</div></div>');
			redirect(base_url('transaksi'));
		}


		if ($this->input->get('kembali')) {
			$id = $this->input->get('kembali');
			$pinjam = $this->db->query("SELECT * FROM tbl_pinjam WHERE pinjam_id = '$id'");
			$kelengkapanBaru = $this->input->post('kelengkapanbaru', TRUE);

			// Proses upload form
			$nmfile = "user_" . time();
			$config['upload_path'] = './assets_style/image/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = 500;
			$config['file_name'] = $nmfile;
			// load library upload
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('gambar')) {
				// Kesalahan upload, berikan pesan kesalahan
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-danger">
					<p> Terjadi kesalahan saat mengupload file: ' . $error['error'] . '</p>
					</div></div>');
				redirect(base_url('transaksi'));
			}

			$result1 = $this->upload->data();
			$result = array('gambar' => $result1);
			$data1 = array('upload_data' => $this->upload->data());

			// Ubah array menjadi string untuk disimpan di dalam kolom kelengkapanbaru
			$kelengkapanBaruString = implode(', ', $kelengkapanBaru);

			// Update data ke dalam tabel tbl_pinjam
			$data = array(
				'kelengkapanbaru' => $kelengkapanBaruString,
			);

			$this->db->where('pinjam_id', $this->input->get('kembali'));
			$this->db->update('tbl_pinjam', $data);

			foreach ($pinjam->result_array() as $isi) {
				$pinjam_id = $isi['pinjam_id'];
				$jml = $this->db->query("SELECT * FROM tbl_pinjam WHERE pinjam_id = '$pinjam_id'")->num_rows();
				// Pemeriksaan kelengkapan
				$kelengkapanAwal = $isi['kelengkapan'];

				if ($kelengkapanAwal !== $kelengkapanBaruString) {
					// Terdapat perbedaan antara kelengkapan awal dan yang baru disubmit

					// Update status menjadi "Tidak Lengkap" dan catat kelengkapan yang belum sesuai
					$data = array(
						'status' => 'Tidak Lengkap',
						'kelengkapan' => 'Awal: ' . $kelengkapanAwal . ', Baru: ' . $kelengkapanBaruString,
						'tgl_kembali' => date('Y-m-d'),
						'upd_kembali' => $data1['upload_data']['file_name'],
					);
				} else {
					// Tidak ada perbedaan antara kelengkapan awal dan yang baru disubmit

					// Update status menjadi "Di Kembalikan" dan catat tanggal kembali
					$data = array(
						'status' => 'Di Kembalikan',
						'tgl_kembali' => date('Y-m-d'),
						'upd_kembali' => $data1['upload_data']['file_name'],
					);
				}

				$this->db->where('pinjam_id', $this->input->get('kembali'));
				$this->db->update('tbl_pinjam', $data);
				// ... (bagian yang tidak diubah)
			}

			$total_array = count($data);
			if ($total_array != 0) {
				$this->db->where('pinjam_id', $this->input->get('kembali'));
				$this->db->update('tbl_pinjam', $data);
			}

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
				<p> Pengembalian Gadget Sukses !</p>
				</div></div>');
			redirect(base_url('transaksi'));
		} else {
			// Kesalahan pada parameter URL 'kembali', berikan pesan kesalahan
			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-danger">
				<p> Terjadi kesalahan pada permintaan pengembalian gadget.</p>
				</div></div>');
			redirect(base_url('transaksi'));
		}
	}






	public function result()
	{

		$user = $this->M_Admin->get_tableid_edit('tbl_karyawan', 'EmpID', $this->input->post('kode_anggota'));
		error_reporting(0);
		if ($user->InternalDisplayName != null) {
			echo '<table class="table table-striped">
						<tr>
							<td>Nama</td>
							<td>:</td>
							<td>' . $user->InternalDisplayName . '</td>
						</tr>
						<tr>
							<td>Jabatan</td>
							<td>:</td>
							<td>' . $user->Position . '</td>
						</tr>
						<tr>
							<td>Departemen</td>
							<td>:</td>
							<td>' . $user->Department . '</td>
						</tr>
						<tr>
							<td>Divisi</td>
							<td>:</td>
							<td>' . $user->CostCenter . '</td>
						</tr>
						
					</table>';
		} else {
			echo 'Anggota Tidak Ditemukan !';
		}
	}

	public function gadget()
	{
		$id = $this->input->post('kode_gadget');
		$row = $this->db->query("SELECT * FROM tbl_gadget WHERE gadget_id ='$id'");

		if ($row->num_rows() > 0) {
			$tes = $row->row();
			$item = array(
				'id'      => $id,
				'qty'     => 1,
				'price'   => '1000',
				'name'    => $tes->title,
				'options' => array('isbn' => $tes->isbn, 'thn' => $tes->thn_gadget, 'warna' => $tes->warna)
			);
			if (!$this->session->has_userdata('cart')) {
				$cart = array($item);
				$this->session->set_userdata('cart', serialize($cart));
			} else {
				$index = $this->exists($id);
				$cart = array_values(unserialize($this->session->userdata('cart')));
				if ($index == -1) {
					array_push($cart, $item);
					$this->session->set_userdata('cart', serialize($cart));
				} else {
					$cart[$index]['quantity']++;
					$this->session->set_userdata('cart', serialize($cart));
				}
			}
		} else {
		}
	}

	public function gadget_list()
	{
?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Title</th>
					<th>Warna</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1;
				$cartData = unserialize($this->session->userdata('cart'));

				if (is_array($cartData)) {
					foreach (array_values($cartData) as $items) {
				?>
						<tr>
							<td><?= $no; ?></td>
							<td><?= $items['name']; ?></td>
							<td><?= $items['options']['warna']; ?></td>
							<td style="width:17%">
								<a href="javascript:void(0)" id="delete_gadget<?= $no; ?>" data_<?= $no; ?>="<?= $items['id']; ?>" class="btn btn-danger btn-sm">
									<i class="fa fa-trash"></i></a>
							</td>
						</tr>
						<script>
							$(document).ready(function() {
								$("#delete_gadget<?= $no; ?>").click(function(e) {
									$.ajax({
										type: "POST",
										url: "<?php echo base_url('transaksi/del_cart'); ?>",
										data: 'kode_gadget=' + $(this).attr("data_<?= $no; ?>"),
										beforeSend: function() {},
										success: function(html) {
											$("#tampil").html(html);
										},
										error: function(xhr, status, error) {
											// Menampilkan pesan kesalahan dan "Klik Ulang"
											$("#tampil").html('<p style="color:red;">Terjadi kesalahan. Silakan refresh halaman.</p>');
										}
									});
								});
							});
						</script>
				<?php
						$no++;
					}
				} else {
					// Menampilkan pesan kesalahan dan "Klik Ulang"
					echo '<tr><td colspan="4"><p style="color:red;">Terjadi kesalahan. Silakan refresh halaman.</p></td></tr>';
				}
				?>

			</tbody>
		</table>

		<div id="tampil"></div>
<?php
	}

	public function del_cart()
	{
		error_reporting(0);
		$id = $this->input->post('gadget_id');
		$index = $this->exists($id);
		$cart = array_values(unserialize($this->session->userdata('cart')));
		unset($cart[$index]);
		$this->session->set_userdata('cart', serialize($cart));
		// redirect('jual/tambah');
		echo '<script>$("#result_gadget").load("' . base_url('transaksi/gadget_list') . '");</script>';
	}
	public function del_all_cart()
	{
		// Menghapus semua item dari keranjang belanja
		$this->session->unset_userdata('cart');

		// Memuat ulang tampilan daftar gadget pada halaman
		echo '<script>$("#result_gadget").load("' . base_url('transaksi/gadget_list') . '");</script>';
	}


	private function exists($id)
	{
		$cart = array_values(unserialize($this->session->userdata('cart')));
		for ($i = 0; $i < count($cart); $i++) {
			if ($cart[$i]['gadget_id'] == $id) {
				return $i;
			}
		}
		return -1;
	}
	public function cetak()
	{

		$pinjam_id = $this->uri->segment('3');

		$query = $this->db->select('tbl_pinjam.*, tbl_karyawan.*, tbl_gadget.*')
			->from('tbl_pinjam')
			->join('tbl_karyawan', 'tbl_pinjam.NIP = tbl_karyawan.EmpID')
			->join('tbl_gadget', 'tbl_pinjam.gadget_id = tbl_gadget.gadget_id')
			->where('tbl_pinjam.pinjam_id', $pinjam_id)
			->get();

		$this->data['pinjamm'] = $query->row();

		if ($this->session->userdata('level') == 'Petugas') {
			if ($this->uri->segment('3') == '') {
				echo '<script>alert("halaman tidak ditemukan");window.location="' . base_url('user') . '";</script>';
			}
			$this->data['idbo'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_pinjam', 'pinjam_id', $this->uri->segment('3'));
			if ($count > 0) {
				$this->data['pinjam'] = $this->M_Admin->get_tableid_edit('tbl_pinjam', 'pinjam_id', $this->uri->segment('3'));
			} else {
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('user') . '"</script>';
			}
		} elseif ($this->session->userdata('level') == 'Anggota') {
			$this->data['idbo'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_pinjam', 'pinjam_id', $this->session->userdata('ses_id'));
			if ($count > 0) {
				$this->data['pinjam'] = $this->M_Admin->get_tableid_edit('tbl_pinjam', 'pinjam_id', $this->session->userdata('ses_id'));
			} else {
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('user') . '"</script>';
			}
		}


		$this->data['title_web'] = 'Print Kartu Anggota ';
		$this->load->view('pinjam/cetak', $this->data);
	}
	public function cetakkembali()
	{

		if ($this->session->userdata('level') == 'Petugas') {
			if ($this->uri->segment('3') == '') {
				echo '<script>alert("halaman tidak ditemukan");window.location="' . base_url('user') . '";</script>';
			}
			$this->data['idbo'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_pinjam', 'pinjam_id', $this->uri->segment('3'));
			if ($count > 0) {
				$this->data['pinjam'] = $this->M_Admin->get_tableid_edit('tbl_pinjam', 'pinjam_id', $this->uri->segment('3'));
			} else {
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('transaksi') . '"</script>';
			}
		} elseif ($this->session->userdata('level') == 'Anggota') {
			$this->data['idbo'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_pinjam', 'pinjam_id', $this->session->userdata('ses_id'));
			if ($count > 0) {
				$this->data['pinjam'] = $this->M_Admin->get_tableid_edit('tbl_pinjam', 'pinjam_id', $this->session->userdata('ses_id'));
			} else {
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('user') . '"</script>';
			}
		}
		$this->data['title_web'] = 'Print Kartu Anggota ';
		$this->load->view('pinjam/cetakkembali', $this->data);
	}
	public function cetakpenggantian()
	{
		$pinjam_id = $this->uri->segment('3');

		$query = $this->db->select('tbl_historipenggantian.*, tbl_karyawan.*, tbl_gadget.*')
			->from('tbl_historipenggantian')
			->join('tbl_karyawan', 'tbl_historipenggantian.NIP = tbl_karyawan.EmpID')
			->join('tbl_gadget', 'tbl_historipenggantian.gadget_id = tbl_gadget.gadget_id')
			->where('tbl_historipenggantian.histori_id', $pinjam_id)
			->get();

		$this->data['pinjamm'] = $query->row();

		if ($this->session->userdata('level') == 'Petugas') {
			if ($this->uri->segment('3') == '') {
				echo '<script>alert("halaman tidak ditemukan");window.location="' . base_url('user') . '";</script>';
			}
			$this->data['idbo'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_historipenggantian', 'histori_id', $this->uri->segment('3'));
			if ($count > 0) {
				$this->data['pinjam'] = $this->M_Admin->get_tableid_edit('tbl_historipenggantian', 'histori_id', $this->uri->segment('3'));
			} else {
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('user') . '"</script>';
			}
		} elseif ($this->session->userdata('level') == 'Anggota') {
			$this->data['idbo'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_historipenggantian', 'histori_id', $this->session->userdata('ses_id'));
			if ($count > 0) {
				$this->data['pinjam'] = $this->M_Admin->get_tableid_edit('tbl_historipenggantian', 'histori_id', $this->session->userdata('ses_id'));
			} else {
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('user') . '"</script>';
			}
		}

		$this->data['title_web'] = 'Print Kartu Anggota ';
		$this->load->view('penggantian/cetak', $this->data);
	}
	public function edit()
	{
		$this->data['gadget'] =  $this->db->query("SELECT * FROM tbl_gadget ORDER BY id_gadget DESC");
		if ($this->session->userdata('level') == 'Petugas') {
			if ($this->uri->segment('3') == '') {
				echo '<script>alert("halaman tidak ditemukan");window.location="' . base_url('user') . '";</script>';
			}
			$this->data['idbo'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_pinjam', 'pinjam_id', $this->uri->segment('3'));
			if ($count > 0) {
				$this->data['pinjam'] = $this->M_Admin->get_tableid_edit('tbl_pinjam', 'pinjam_id', $this->uri->segment('3'));
			} else {
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('pinjam') . '"</script>';
			}
		} elseif ($this->session->userdata('level') == 'Anggota') {
			$this->data['idbo'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_pinjam', 'pinjam_id', $this->uri->segment('3'));
			if ($count > 0) {
				$this->data['pinjam'] = $this->M_Admin->get_tableid_edit('tbl_pinjam', 'pinjam_id', $this->session->userdata('ses_id'));
			} else {
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('pinjam') . '"</script>';
			}
		}
		$this->data['title_web'] = 'Pergantian Gadget ';
		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('pinjam/edit_penggantian', $this->data);
		$this->load->view('footer_view', $this->data);
	}

	public function updpj()
	{
		$pinjamID = htmlentities($this->input->post('pinjam_id', TRUE));
		$kodegadget = htmlentities($this->input->post('gadget_id', TRUE));
		$kelengkapan = $this->input->post('kelengkapan', TRUE);
		$MAC = htmlentities($this->input->post('MAC'));

		// Pemeriksaan apakah gadget_id kosong atau tidak
		if (empty($kodegadget)) {
			// Jika gadget_id kosong, ambil nilai gadget_id dari data yang sudah ada
			$pinjamData = $this->M_Admin->get_tableid_edit('tbl_pinjam', 'pinjam_id', $pinjamID);
			$kodegadget = $pinjamData->gadget_id;
		}

		// setting konfigurasi upload
		$nmfile = "user_" . time();
		$config['upload_path'] = './assets_style/image/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = 500;
		$config['file_name'] = $nmfile;
		// load library upload
		$this->load->library('upload', $config);

		if ($this->upload->do_upload('gambar')) {
			$result1 = $this->upload->data();
			$result = array('gambar' => $result1);
			$data1 = array('upload_data' => $this->upload->data());

			// Hapus gambar lama jika ada
			if ($this->input->post('upd_form')) {
				unlink('./assets_style/image/' . $this->input->post('upd_form'));
			}

			// Data untuk update dengan mengganti gambar
			$data = array(
				'gadget_id' => $kodegadget,
				'kelengkapan' => implode(',', $kelengkapan),
				'MAC' => $MAC,
				'upd_form' => $data1['upload_data']['file_name'],
				// ...
			);
		} else {
			// Gagal upload
			$error_message = $this->upload->display_errors();
			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-danger">
        <p> Gagal edit gambar: ' . $error_message . '</p>
        </div></div>');
			redirect(base_url('transaksi'));
			return;
		}

		$this->M_Admin->update_table('tbl_pinjam', 'pinjam_id', $pinjamID, $data);

		// Handle sesuai kebutuhan Anda
		if ($this->session->userdata('level') == 'Petugas') {
			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
        <p> Berhasil Update pinjamm : ' . $pinjamID . ' !</p>
        </div></div>');
			redirect(base_url('transaksi'));
		}
	}


	public function detailpenggantian()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');

		$id = $this->uri->segment('3');
		if ($this->session->userdata('level') == 'Anggota') {
			$count = $this->db->get_where('tbl_historipenggantian', [
				'histori_id' => $id,
				'NIP' => $this->session->userdata('NIP')
			])->num_rows();
			if ($count > 0) {
				$this->data['pinjam'] = $this->db->query(
					"SELECT DISTINCT `pinjam_id`, 
				`NIP`, `status`, 
				`tgl_pinjam`, `MAC`, 
				`tgl_edit`, `kelengkapan`,'upd_form'
				FROM tbl_historipenggantian WHERE histori_id = ? 
				AND NIP =?",
					array($id, $this->session->userdata('NIP'))
				)->row();
			} else {
				echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="' . base_url('transaksi') . '"</script>';
			}
		} else {
			$count = $this->M_Admin->CountTableId('tbl_historipenggantian', 'histori_id', $id);
			if ($count > 0) {
				$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, 
				`NIP`, `status`, 
				`tgl_pinjam`, `MAC`, 
				`tgl_edit`, `kelengkapan`,'upd_form' 
				FROM tbl_historipenggantian WHERE histori_id = '$id'")->row();
			} else {
				echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="' . base_url('transaksi') . '"</script>';
			}
		}
		$this->data['sidebar'] = 'kembali';
		$this->data['title_web'] = 'Detail Penggantian Gadget ';
		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('penggantian/detail', $this->data);
		$this->load->view('footer_view', $this->data);
	}
}
