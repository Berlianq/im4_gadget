<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-edit" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-edit"></i>&nbsp;  <?= $title_web;?></li>
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
																<td>Nama</td>
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
										<td colspan="3">Pemberian Gadget</td>
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
										<!-- <td>Kode Gadget</td>
										<td>:</td>
										<td>
										<?php
											
											$no =1;
											foreach($pin as $isi)
											{
												$gadget = $this->M_Admin->get_tableid_edit('tbl_gadget','gadget_id',$isi['gadget_id']);
												echo $no.'. '.$gadget->gadget_id.'<br/>';
											$no++;}

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
														<th>No</th>
														<th>Title</th>
														<th>Warna</th>
													</tr>
												</thead>
												<tbody>
												<?php 
													$pin = $this->M_Admin->get_tableid('tbl_pinjam','pinjam_id',$pinjam->pinjam_id);
													$no=1;
													foreach($pin as $isi)
													{
														$gadget = $this->M_Admin->get_tableid_edit('tbl_gadget','gadget_id',$isi['gadget_id']);
												?>
													<tr>
														<td><?= $no;?></td>
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
										<?php
										$kelengkapans = $this->db->get_where('tbl_pinjam', array('pinjam_id' => $pinjam->pinjam_id))->result();

										foreach ($kelengkapans as $isi) {
											$kelengkapan = str_replace('_', ' ', $isi->kelengkapan);
											echo $kelengkapan . '<br/>';
										}
										?>
										</td>
									</tr>

									<tr>
										<td>MAC Address</td>
										<td>:</td>
										<td>
											<?php
											$mac_addresses = $this->db->get_where('tbl_pinjam', array('pinjam_id' => $pinjam->pinjam_id))->result();

											foreach ($mac_addresses as $isi) {
												echo $isi->MAC . '<br/>';
											}
											?>
										</td>
									</tr>

								</table>
							</div>
							<div class="col-sm-4 text-center">
									<center>
										<?php
										$form = $this->db->get_where('tbl_pinjam', array('pinjam_id' => $pinjam->pinjam_id))->row();
										if ($form) {
											echo '<img src="' . base_url() . 'assets_style/image/' . $form->upd_kembali . '" style="width:3cm;height:4cm;" class="img-responsive">';
										} else {
											echo 'Form not found';
										}
										?>
									</center>
								</div>

						</div>
                        <div class="pull-right">
							<a href="<?= base_url('transaksi');?>" class="btn btn-danger btn-md">Kembali</a>
						</div>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>
