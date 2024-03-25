<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-sign-out" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-sign-out"></i>&nbsp;  <?= $title_web;?></li>
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
				<form action="<?= base_url('transaksi/prosespinjam?kembali='.$pinjam->pinjam_id);?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-5">
								<table class="table table-striped">
									<tr style="background:yellowgreen">
										<td colspan="3">Data Transaksi</td>
									</tr>
									<tr>
										<td>No Peminjaman</td>
										<td>:</td>
										<td>
											<?= $pinjam->pinjam_id;?>
										</td>
									</tr>
									<tr>
										<td>Tgl Peminjaman</td>
										<td>:</td>
										<td>
											<?= $pinjam->tgl_pinjam;?>
										</td>
									</tr>
									<tr>
										<td>ID Anggota</td>
										<td>:</td>
										<td>
											<?= $pinjam->NIP;?>
										</td>
									</tr>
									<tr>
										<td>Biodata</td>
										<td>:</td>
										<td>
											<?php
											$user = $this->M_Admin->get_tableid_edit('tbl_karyawan','EmpID',$pinjam->NIP);
											error_reporting(0);
											if($user->InternalDisplayName != null)
											{
												echo '<table class="table table-striped">
															<tr>
																<td>Nama Karyawan</td>
																<td>:</td>
																<td>'.$user->InternalDisplayName.'</td>
															</tr>
															<tr>
																<td>Jabatan</td>
																<td>:</td>
																<td>'.$user->Position.'</td>
															</tr>
															<tr>
																<td>Departemen</td>
																<td>:</td>
																<td>'.$user->Department.'</td>
															</tr>
															<tr>
																<td>Divisi</td>
																<td>:</td>
																<td>'.$user->CostCenter.'</td>
															</tr>
														</table>';
											}else{
												echo 'Anggota Tidak Ditemukan !';
											}
											?>
										</td>
									</tr>
								</table>
							</div>
							<div class="col-sm-7">
								<table class="table table-striped">
									<tr style="background:yellowgreen">
										<td colspan="3">Pinjam gadget</td>
									</tr>
									<tr>
										<td>Status</td>
										<td>:</td>
										<td>
											<?= $pinjam->status;?>
										</td>
									</tr>
									<!-- <tr>
										<td>Tgl Kembali</td>
										<td>:</td>
										<td>
											<?php 
												if($pinjam->tgl_kembali == '0')
												{
													echo '<p style="color:red;">belum dikembalikan</p>';
												}else{
													echo $pinjam->tgl_kembali;
												}
											
											?>
										</td>
									</tr> -->
									<tr>
										<td>Data Gadget</td>
										<td>:</td>
										<td>
											<table class="table table-striped">
												<thead>
													<tr>
														<th>Jenis Gadget</th>
														<th>Warna</th>														
													</tr>
												</thead>
												<tbody>
												<?php 
													$pin = $this->M_Admin->get_tableid('tbl_pinjam','pinjam_id',$pinjam->pinjam_id);
													foreach($pin as $isi)
													{
														$gadget = $this->M_Admin->get_tableid_edit('tbl_gadget','gadget_id',$isi['gadget_id']);
												?>
													<tr>														
														<td><?= $gadget->title;?></td>
														<td><?= $gadget->warna;?></td>
													</tr>
												<?php $no++;}?>
												</tbody>
											</table>
										</td>
									</tr>
									
									<tr>
										<td>Kelengkapan</td>
										<td>:</td>
										<td>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="checkbox" name="kelengkapanbaru[]" id="Hp" value="Hp"
												<?php if(stripos($pinjam->kelengkapan, 'Hp') !== false) { echo 'checked'; } ?>>
												<label class="form-check-label" for="Hp">Hp</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="checkbox" name="kelengkapanbaru[]" id="kabel_data" value="kabel_data"
												<?php if(stripos($pinjam->kelengkapan, 'kabel_data') !== false) { echo 'checked'; } ?>>
												<label class="form-check-label" for="kabel_data">Kabel Data</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="checkbox" name="kelengkapanbaru[]" id="charger" value="charger"
												<?php if(stripos($pinjam->kelengkapan, 'charger') !== false) { echo 'checked'; } ?>>
												<label class="form-check-label" for="charger">Charger</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="checkbox" name="kelengkapanbaru[]" id="DusBook" value="DusBook"
												<?php if(stripos($pinjam->kelengkapan, 'DusBook') !== false) { echo 'checked'; } ?>>
												<label class="form-check-label" for="DusBook">DusBook</label>
											</div>
											
										</td>
									</tr>
									<tr>
										<td>MAC Address</td>
										<td>:</td>
										<td>
										<?= $pinjam->MAC;?>
										</td>
									</tr>
									<tr>
									<td>Upload Form</td>
									<td>:</td>
									<td>
										<div class="form-group">
											<input type="file" accept=".jpg, .jpeg, .png" name="gambar" required>
											<small class="form-text text-muted">Hanya menerima file dengan format .jpg, .jpeg, atau .png</small>
										</div>
									</td>

									</tr>
								</table>
							</div>
						</div>
						<div class="pull-right">
							
							<button type="submit" class="btn btn-primary"> Proses Pengembalian</button>
							</form>
							<a href="<?= base_url('transaksi');?>" class="btn btn-danger btn-md">Kembali</a>
						</div>
                        <!-- <div class="pull-right">
							<a data-toggle="modal" data-target="#TableDenda" class="btn btn-primary btn-md" style="margin-left:1pc;">
								<i class="fa fa-sign-in"></i> Kembalikan</a>
							<a href="<?= base_url('transaksi');?>" class="btn btn-danger btn-md">Kembali</a>
						</div> -->
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>
