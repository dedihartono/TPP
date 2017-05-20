 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
  
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <?php 
      $level=$this->session->userdata('level');
        if($level=="1")
      {
      ?>
      <ul class="sidebar-menu">
      <li><?php echo anchor('dashboard','<i class="fa fa-dashboard"></i> <span>Dashboard</span>');?></li>
        <li class="header">DATA MASTER</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span>Data Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><?php echo anchor('master/uptd','<i class="fa fa-users"></i>Data UPTD');?></li>
            <li><?php echo anchor('master/sekolah','<i class="fa fa-users"></i>Data Sekolah');?></li>
            <li><?php echo anchor('master/pegawai','<i class="fa fa-users"></i>Data pegawai');?></li>
            <li><?php echo anchor('master/jabatan','<i class="fa fa-users"></i>Data Jabatan');?></li>
            <li><?php echo anchor('master/golongan','<i class="fa fa-users"></i>Data Golongan');?></li>
          </ul>
        </li>
      <?php }
       elseif($level=="2"){ ?>
       <ul class="sidebar-menu">
        <li class="header">TRANSAKSI</li>
        <li><?php echo anchor('transaksi/hitung','<i class="fa fa-circle-o text-red"></i>Data Perhitungan');?></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Data Sekolah</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i>Data Jabatan</a></li>
          </ul>
        </li>
      
      <li class="header">PENGATURAN</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Data Pengguna</span></a></li>
        <li><?php echo anchor('example','<i class="fa fa-users"></i>Latihan');?></li>
      </ul>
      <?php };?>      
    </section>
    <!-- /.sidebar -->
  </aside>
