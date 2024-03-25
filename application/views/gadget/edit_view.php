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
                    <form action="<?php echo base_url('data/prosesgadget');?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
								<!-- <div class="form-group">
									<label>Kategori</label>
									<select class="form-control select2" required="required"  name="kategori">
										<option disabled selected value> -- Pilih Kategori -- </option>
										<?php foreach($kats as $isi){?>
											<option value="<?= $isi['id_kategori'];?>" <?php if($isi['id_kategori'] == $gadget->id_kategori){ echo 'selected';}?>><?= $isi['nama_kategori'];?></option>
										<?php }?>
									</select>
								</div>
                                <div class="form-group">
                                    <label>Rak / Lokasi</label>
                                    <select name="rak" class="form-control select2" required="required">
										<option disabled selected value> -- Pilih Rak / Lokasi -- </option>
										<?php foreach($rakgadget as $isi){?>
											<option value="<?= $isi['id_rak'];?>" <?php if($isi['id_rak'] == $gadget->id_rak){ echo 'selected';}?>><?= $isi['nama_rak'];?></option>
										<?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>ISBN</label>
                                    <input type="text" class="form-control" value="<?= $gadget->isbn;?>" name="isbn"  placeholder="Contoh ISBN : 978-602-8123-35-8">
                                </div> -->
                                <div class="form-group">
                                    <label>Judul gadget</label>
                                    <input type="text" class="form-control" value="<?= $gadget->title;?>" name="title" placeholder="Contoh : Cara Cepat Belajar Pemrograman Web">
                                <!-- </div>
                                <div class="form-group">
                                    <label>Nama Pengarang</label>
                                    <input type="text" class="form-control" value="<?= $gadget->pengarang;?>" name="pengarang" placeholder="Nama Pengarang">
                                </div> -->
                                <div class="form-group">
                                    <label>Warna</label>
                                    <input type="text" class="form-control" value="<?= $gadget->warna;?>" name="warna" placeholder="Nama Penerbit">
                                </div>
                                <!-- <div class="form-group">
                                    <label>Tahun gadget</label>
                                    <input type="number" class="form-control" value="<?= $gadget->thn_gadget;?>" name="thn" placeholder="Tahun gadget : 2019">
                                </div> -->
								
                            </div>
                            </div>
                            <div class="col-sm-6">
								
								<div class="form-group">
                                    <label>Jumlah gadget</label>
                                    <input type="number" class="form-control" value="<?= $gadget->jml;?>" name="jml" placeholder="Jumlah gadget : 12">
								</div>
                                
                                <!-- <div class="form-group">
								<label>Lampiran gadget <small style="color:green">(pdf) * ganti opsional</small></label>
                                    <input type="file" accept="application/pdf" name="lampiran">
                                    <br>
									 if(!empty($gadget->lampiran !== "0")){?>
									<a href="<?= base_url('assets_style/image/gadget/'.$gadget->lampiran);?>" class="btn btn-primary btn-md" target="_blank">
										<i class="fa fa-download"></i> Sample gadget
									</a>
									 }else{ echo '<br/><p style="color:red">* Tidak ada Lampiran</p>';}?>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan Lainnya</label>
                                    <textarea class="form-control" name="ket" id="summernotehal" style="height:120px"><?= $gadget->isi;?></textarea>
                                </div> -->
                            </div>
                        </div>
                        <div class="pull-right">
							<input type="hidden" name="gmbr" value="<?= $gadget->sampul;?>">
							<!-- <input type="hidden" name="lamp" value="<?= $gadget->lampiran;?>"> -->
							<input type="hidden" name="edit" value="<?= $gadget->id_gadget;?>">
                            <button type="submit" class="btn btn-primary btn-md">Submit</button> 
                    </form>
                            <a href="<?= base_url('data');?>" class="btn btn-danger btn-md">Kembali</a>
                        </div>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>
