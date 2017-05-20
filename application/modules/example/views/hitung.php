<p>Test</p>
<!-- jQuery 2.2.3 -->
<?php

foreach ($hitung as $row) 
{
	 $a = $row->id_pelanggan;
	 $b = $row->id_produk;
	 $c = $row->total;	
}
?>

<?php echo"$a <BR>";?>
<?php echo"$b <BR>";?>
<?php echo"$c <BR>";?>

<script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>