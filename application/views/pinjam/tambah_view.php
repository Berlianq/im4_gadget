<?php if (!defined('BASEPATH')) exit('No direct script acess allowed'); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<i class="fa fa-plus" style="color:green"> </i> <?= $title_web; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-plus"></i>&nbsp; <?= $title_web; ?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form action="<?php echo base_url('transaksi/prosespinjam/prosespinjamhp'); ?>" method="POST" enctype="multipart/form-data">

							<div class="row">
								<div class="col-sm-5">
									<table class="table table-striped">
										<tr style="background:yellowgreen">
											<td colspan="3">Data Karyawan</td>
										</tr>
										<tr>
											<td>No Peminjaman</td>
											<td>:</td>
											<td>
												<input type="text" name="nopinjam" value="<?= $nop; ?>" readonly class="form-control">
											</td>
										</tr>
										<tr>
											<td>Tgl Peminjaman</td>
											<td>:</td>
											<td>
												<input type="date" value="<?= date('Y-m-d'); ?>" name="tgl" class="form-control">
											</td>
										</tr>
										<tr>
											<td>NIP Karyawan</td>
											<td>:</td>
											<td>
												<div class="input-group">
													<input type="text" class="form-control" required autocomplete="off" name="EmpID" id="search-box" placeholder="Contoh NIP : 10392****" type="text" value="">
													<span class="input-group-btn">
														<a data-toggle="modal" data-target="#TableAnggota" class="btn btn-primary"><i class="fa fa-search"></i></a>
													</span>
												</div>
											</td>
										</tr>
										<tr>
											<td>Biodata</td>
											<td>:</td>
											<td>
												<div id="result_tunggu">
													<p style="color:red">* Belum Ada Hasil</p>
												</div>
												<div id="result"></div>
											</td>
										</tr>
										<!-- <tr>
										<td>Lama Peminjaman</td>
										<td>:</td>
										<td>
											<input type="number" required placeholder="Lama Pinjam Contoh : 2 Hari (2)" name="lama" class="form-control">
										</td>
									</tr> -->
									</table>
								</div>
								<div class="col-sm-7">
									<table class="table table-striped">
										<tr style="background:yellowgreen">
											<td colspan="3">Pinjam Gadget</td>
										</tr>
										<tr>
											<td>Kode Gadget</td>
											<td>:</td>
											<td>
												<div class="input-group">
													<input hidden type="text" name="gadget_id">
													<span class="input-group-btn">
														<button data-toggle="modal" data-target="#Tablegadget" class="btn btn-primary" type="button"><i class="fa fa-list"></i></button>
													</span>
												</div>


											</td>

										</tr>
										<tr>
											<td>Data Gadget</td>
											<td>:</td>
											<td>
												<div id="result_tunggu_gadget">
													<p style="color:red">* Belum Ada Hasil</p>
												</div>
												<div id="result_gadget"></div>
											</td>
										</tr>
										<tr>
											<td>Kelengkapan</td>
											<td>:</td>
											<td>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" name="kelengkapan[]" id="Hp" value="Hp">
													<label class="form-check-label" for="Hp">Hp</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" name="kelengkapan[]" id="kabel_data" value="kabel_data">
													<label class="form-check-label" for="kabel_data">Kabel Data</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" name="kelengkapan[]" id="charger" value="charger">
													<label class="form-check-label" for="charger">Charger</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" name="kelengkapan[]" id="DusBook" value="DusBook">
													<label class="form-check-label" for="DusBook">DusBook</label>
												</div>

											</td>
										</tr>
										<!-- <tr>
										<td>Serial Number</td>
										<td>:</td>
										<td>
											<input type="text" class="form-control" autocomplete="off" name="serial_number" placeholder="Masukkan Serial Number">
										</td>
									</tr> -->
										<tr>
											<td>MAC Address</td>
											<td>:</td>
											<td>
												<input type="text" class="form-control" autocomplete="off" name="MAC" placeholder="Masukkan MAC Address" id="macInput">

											</td>
										</tr>
										<tr>
											<td>Upload Form</td>
											<td>:</td>
											<td>
												<div class="form-group">
													<input type="file" accept=".jpg, .jpeg, .png" name="gambar" id="gambar" required>
													<small class="text-muted">File harus berupa gambar (.jpg, .jpeg, .png) dengan ukuran maksimal 500KB.</small>
												</div>
											</td>

										</tr>
									</table>
								</div>
							</div>
							<div class="pull-right">
								<input type="hidden" name="tambah" value="tambah">
								<button type="submit" class="btn btn-primary btn-md">Submit</button>
						</form>
						<a href="<?= base_url('transaksi'); ?>" class="btn btn-danger btn-md">Kembali</a>
					</div>
				</div>
			</div>
		</div>
</div>
</section>
</div>
<!--modal import -->
<div class="modal fade" id="Tablegadget">
	<div class="modal-dialog" style="width:80%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Gadget</h4>
			</div>
			<div id="modal_body" class="modal-body fileSelection1">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Jenis Gadget</th>
							<th>Warna</th>
							<th>Stok Gadget</th>
							<th>Dipinjam</th>
							<th>Sisa</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($gadget->result_array() as $isi) { ?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= $isi['title']; ?></td>
								<td><?= $isi['warna']; ?></td>
								<td><?= $isi['jml']; ?></td>
								<td>
									<?php
									$id = $isi['gadget_id'];
									$dd = $this->db->query("SELECT * FROM tbl_pinjam WHERE gadget_id= '$id' AND status = 'Dipinjam'");
									if ($dd->num_rows() > 0) {
										echo $dd->num_rows();
									} else {
										echo '0';
									}
									?>
								</td>
								<td>
									<?php
									$id = $isi['gadget_id'];
									$total_gadget = $this->db->query("SELECT * FROM tbl_gadget WHERE gadget_id = '$id'")->row()->jml;
									$dipinjam = $this->db->query("SELECT * FROM tbl_pinjam WHERE gadget_id= '$id' AND status = 'Dipinjam'")->num_rows();
									$stok_sisa = $total_gadget - $dipinjam;

									echo $stok_sisa;
									?>
								</td>
								<td style="width:17%">
									<button class="btn btn-primary" id="Select_File2" data_id="<?= $isi['gadget_id']; ?>">
										<i class="fa fa-check"> </i> Pilih
									</button>
									<a href="<?= base_url('data/gadgetdetail/' . $isi['id_gadget']); ?>" target="_blank">
										<button class="btn btn-success"><i class="fa fa-sign-in"></i> Detail</button></a>
								</td>
							</tr>
						<?php $no++;
						} ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
	var lastClickedgadgetId = ''; // Variabel untuk menyimpan ID gadget yang terakhir di-klik

	$(".fileSelection1 #Select_File2").click(function(e) {
		// Menghapus semua nilai dalam session 'cart'

		// Hanya menghapus nilai sebelumnya jika ada input baru
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('transaksi/del_all_cart'); ?>",
			beforeSend: function() {
				// Sebelum penghapusan, lakukan sesuatu jika diperlukan
			},
			success: function(response) {
				console.log("Semua nilai dalam session 'cart' dihapus dari server");
				// Tambahkan logika atau perbarui tampilan jika diperlukan
				$("#tampil").html(response);
			}
		});


		// Mengupdate nilai yang terakhir di-klik
		lastClickedgadgetId = $(this).attr("data_id");

		// Mengubah nilai input
		document.getElementsByName('gadget_id')[0].value = lastClickedgadgetId;

		// Menutup Modal
		$('#Tablegadget').modal('hide');

		// Melakukan AJAX Request Lainnya
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('transaksi/gadget'); ?>",
			data: 'kode_gadget=' + lastClickedgadgetId,
			beforeSend: function() {
				$("#result_gadget").html("");
				$("#result_tunggu_gadget").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
			},
			success: function(html) {
				$("#result_gadget").load("<?= base_url('transaksi/gadget_list'); ?>");
				$("#result_tunggu_gadget").html('');
			}
		});
	});
</script>


<script>
	// AJAX call for autocomplete 
	$(document).ready(function() {
		$("#gadget-dropdown").keyup(function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('transaksi/gadget'); ?>",
				data: 'kode_gadget=' + $(this).val(),
				beforeSend: function() {
					$("#result_tunggu_gadget").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
				},
				success: function(html) {
					$("#result_gadget").load("<?= base_url('transaksi/gadget_list'); ?>");
					$("#result_tunggu_gadget").html('');
				}
			});
		});
	});
</script>

<!-- /.modal -->
<script>
	$(".fileSelection1 #Select_File1").click(function(e) {
		document.getElementsByName('NIP')[0].value = $(this).attr("data_id");
		$('#TableAnggota').modal('hide');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('transaksi/result'); ?>",
			data: 'kode_anggota=' + $(this).attr("data_id"),
			beforeSend: function() {
				$("#result").html("");
				$("#result_tunggu").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
			},
			success: function(html) {
				$("#result").html(html);
				$("#result_tunggu").html('');
			}
		});
	});
</script>

<script>
	// AJAX call for autocomplete 
	$(document).ready(function() {
		$("#search-box").keyup(function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('transaksi/result'); ?>",
				data: 'kode_anggota=' + $(this).val(),
				beforeSend: function() {
					$("#result").html("");
					$("#result_tunggu").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
				},
				success: function(html) {
					$("#result").html(html);
					$("#result_tunggu").html('');
				}
			});
		});
	});
</script>
<script>
	$(document).ready(function() {
		$('#macInput').on('input', function() {
			var macValue = $(this).val();
			macValue = macValue.replace(/[^a-fA-F0-9]/g, ''); // Hapus karakter selain hex
			var formattedMac = formatMacAddress(macValue);
			$(this).val(formattedMac);
		});

		function formatMacAddress(mac) {
			var formattedMac = '';
			for (var i = 0; i < mac.length; i += 2) {
				formattedMac += mac.substr(i, 2) + ':';
			}
			return formattedMac.slice(0, -1); // Hilangkan titik dua terakhir
		}
	});
</script>