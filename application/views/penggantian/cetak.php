<?php
error_reporting(0);
    if(!empty($_GET['download'] == 'doc')){
        header("Content-Type: application/vnd.ms-word");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=".date('d-m-Y')."_laporan_rekam_medis.doc");
    }
    if(!empty($_GET['download'] == 'xls')){
        header("Content-Type: application/force-download");
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header("content-disposition: attachment;filename=".date('d-m-Y')."_laporan_rekam_medis.xls");
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML Form Example</title>
	<style>
    form {
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 5px;
        border: 1px solid #ccc;
    }

    th {
        background-color: #f2f2f2;
    }

    input[type="text"],
    input[type="date"],
    input[type="submit"] {
        width: 100%;
        padding: 5px;
        box-sizing: border-box;
    }

    input[type="checkbox"] {
        margin-right: 5px;
    }
</style>
</head>
<body>
<div class="container">
            <br/> 
            <div class="pull-left">
               Preview HTML to DOC [ size paper A4 ]
            </div>
            <div class="pull-right"> 
            <button type="button" class="btn btn-success btn-md" onclick="printDiv('printableArea')">
                <i class="fa fa-print"> </i> Print File
            </button>
            </div>
        </div>
<form id="printableArea">
    <table>
        <thead>
		<tr>
                <th colspan="9"><h1>BUKTI TERIMA PENGGANTIAN GADGET IM4</h1></th>
            </tr>
            <tr>
                <th colspan="9">INDONESIA</th>
            </tr>
        </thead>
		<tbody>
	<tr>
        <td colspan="2">NIP</td>
        	<td colspan="7">	
			<?= $pinjam->NIP;?>
        </td>
    </tr>
	<tr>
        <td colspan="2">Nama</td>
        	<td colspan="7">	
			<?= $pinjamm->InternalDisplayName;?>
        </td>
    </tr>
    <tr>
        <td colspan="2">Jabatan</td>
        	<td colspan="7">	
			<?= $pinjamm->Position;?>
        </td>
    </tr>
    <tr>
        <td colspan="2">Divisi</td>
        	<td colspan="7">	
			<?= $pinjamm->CostCenter;?>
        </td>
    </tr>
	<tr>
        <td colspan="2">Tipe Gadget</td>
        	<td colspan="7">	
			<?= $pinjamm->title;?>
        </td>
    </tr>
    <tr>
        <td colspan="2">Kelengkapan</td>
        	<td colspan="7">	
			<?= $pinjamm->kelengkapan;?>
        </td>
    </tr>
    <tr>
        <td colspan="2">Tanggal Diterima</td>
        	<td colspan="7">	
			<?= $pinjamm->tgl_pinjam;?>
        </td>
    </tr>
    <tr>
        <td colspan="2">Mac Address</td>
        <td colspan="7">
		<?= $pinjamm->MAC;?>
        </td>
    </tr>
    <tr>
        <td colspan="2">Diketahui</td>
        <td colspan="7">
            <input type="text" id="diketahui" name="diketahui">
        </td>
    </tr>
    <tr>
        <td colspan="9">
            <input type="submit" value="Diterima">
        </td>
    </tr>
</tbody>
    </table>
</form>
</body>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
  </script>
</html>
