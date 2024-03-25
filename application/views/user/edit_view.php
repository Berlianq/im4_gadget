<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-edit" style="color:green"> </i>  Update User - <?= $user->InternalDisplayName;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-edit"></i>&nbsp; Update User - <?= $user->InternalDisplayName;?></li>
    </ol>
  </section>
  <section class="content">
	<div class="row">
	    <div class="col-md-12">	
			<?php if(!empty($this->session->flashdata())){ echo $this->session->flashdata('pesan');}?>

	        <div class="box box-primary">
                <div class="box-header with-border">
                </div>
			    <!-- /.box-header -->
			    <div class="box-body">
                    <form action="<?php echo base_url('user/upd');?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <input type="hidden" class="form-control" value="<?= $user->No; ?>" name="No">
                                    <label>NIP</label>
                                    <input type="text" class="form-control" value="<?= $user->EmpID;?>" name="EmpID" required="required" placeholder="Nama Pengguna">
                                </div>
                                <div class="form-group">
                                    <label>Nama Pengguna</label>
                                    <input type="text" class="form-control" value="<?= $user->InternalDisplayName;?>" name="InternalDisplayName" required="required" placeholder="Nama Pengguna">
                                </div>
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" class="form-control" name="Position" value="<?= $user->Position;?>" required="required" placeholder="Contoh : Bekasi">
                                </div>
                                <div class="form-group">
                                    <label>Departemen</label>
                                    <input type="text" class="form-control" value="<?= $user->Department;?>" name="Department" required="required" placeholder="Nama Pengguna">
                                </div>
                                <div class="form-group">
                                    <label>Divisi</label>
                                    <input type="text" class="form-control" value="<?= $user->CostCenter;?>" name="CostCenter" required="required" placeholder="Nama Pengguna">
                                </div>
                               
                       
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-md">Edit Data</button> 
					</form>
						<?php if($this->session->userdata('level') == 'Petugas'){?>
							<a href="<?= base_url('user');?>" class="btn btn-danger btn-md">Kembali</a>
						<?php }elseif($this->session->userdata('level') == 'Anggota'){?>
							<a href="<?= base_url('transaksi');?>" class="btn btn-danger btn-md">Kembali</a>
						<?php }?>
                        </div>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>
