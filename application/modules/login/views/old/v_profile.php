
<div class="profile_pic">
    <img src="<?php echo base_url()?>assets/images/users/<?php echo $this->session->userdata("gambar");?>" 
            alt="<?php echo $this->session->userdata("gambar");?>" class="img-circle profile_img">   
</div>

<div class="profile_info">
    <span>Selamat Datang,</span>
        <h2><?php echo $this->session->userdata("nama_lengkap");?></h2>
</div>