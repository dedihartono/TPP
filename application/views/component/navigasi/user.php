<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
         <!--
              
              Dalam Pengembangan
          
         <?php // $this->load->view('component/navigasi/message');?>

         <?php // $this->load->view('component/navigasi/notification');?>

         <?php // $this->load->view('component/navigasi/task');?>
          
          -->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo base_url()?>assets/images/<?php echo $this->session->userdata("gambar");?>" 
                      alt="<?php echo $this->session->userdata("gambar");?>" class="user-image">   
            
              <!--<img src="<?php// echo base_url('assets/dist/img/user2-160x160.jpg');?>" class="user-image" alt="User Image">-->
              <span class="hidden-xs"><?php echo $this->session->userdata("username");?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url()?>assets/images/<?php echo $this->session->userdata("gambar");?>" 
                      alt="<?php echo $this->session->userdata("gambar");?>" class="img-circle">   
                
                <!--<img src="<?php //echo base_url('assets/dist/img/user2-160x160.jpg');?>" class="img-circle" alt="User Image">
                -->
                <p>
                  <?php echo $this->session->userdata("username");?> 
                 <!-- <small>Member since Nov. 2012</small>-->
                </p>
              </li>
              <!-- Menu Body 
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>-->
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <?php echo anchor('login/logout','<button class="btn btn-default">Sign Out</button>');?>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
  </ul>
</div>