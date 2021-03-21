<!DOCTYPE html>
<html>

<?php   
date_default_timezone_set('Asia/Jakarta');
 ?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>MSD BIDKEU SUMSEL</title>
  <!-- Favicon -->
  <link rel="icon" href="<?php echo base_url('Assets/img/brand/polda.png') ?>" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?php echo base_url('Assets/vendor/nucleo/css/nucleo.css') ?>" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url('Assets/vendor/@fortawesom') ?>e/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?php echo base_url('Assets/css/style.css') ?>" type="text/css">
  <style type="">
    .poto{
      width: 30px;
      height: 100px;
    }
  </style>
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left navbar-expand-xs navbar-light"  id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">

      <img src="<?php echo base_url ('Assets/img/brand/logoatas.png') ?>" width="60px" class="mt-3 mb-0"  alt="...">

        <a class="navbar-bran mt--2" href="javascript:void(0)">
          <h2 class="text-orange" style="font-family: arial">BIDKEU ONLINE</h2>
        </a>
      </div>
      <div class="navbar-inner mt-6">
        <!-- Collapse -->
        <?php if ($this->session->userdata('level') == 'admin'): ?>
        
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
           <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('Admin') ?>">
                <i class="fa fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('user/admin') ?>">
                <i class="fa fa-users text-orange"></i>
                <span class="nav-link-text">User</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('tampil/admin') ?>">
                <i class="fa fa-list text-orange"></i>
                <span class="nav-link-text">Personil Bermasalah</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('RD_polri/pilih') ?>">
               <i class="fa fa-home text-orange"></i>
                <span class="nav-link-text">Rumah Dinas</span>
              </a>
            </li>          
                <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('tampil/mutdat') ?>">
                <i class="ni ni-single-copy-04 text-orange"></i>
                <span class="nav-link-text">Mutdat</span>
              </a>
            </li>  
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('informasi/admin') ?>">
                <i class="ni ni-email-83 text-orange"></i>
                <span class="nav-link-text">Kirim Informasi</span>
              </a>
            </li> 
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('Rekap/admin') ?>">
                <i class="ni ni-email-83 text-orange"></i>
                <span class="nav-link-text">Rekap Mutdat</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('tampil/rekap_personil') ?>">
                <i class="ni ni-email-83 text-orange"></i>
                <span class="nav-link-text">Rekap Personil Bermasalah</span>
              </a>
            </li> 
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('tampil/rekap_rumdin') ?>">
                <i class="ni ni-email-83 text-orange"></i>
                <span class="nav-link-text">Rekap Rumah Dinas</span>
              </a>
            </li>  
          </ul>
        </div>        

        <?php endif ?>
        <?php if ($this->session->userdata('level') == 'satker'): ?>
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
           <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('Admin') ?>">
                <i class="fa fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo base_url()?>user/Konfigurasi/<?php echo $this->session->userdata('id_satker') ?>" >


                <i class="ni ni-tv-2 text-orange"></i>
                <span class="nav-link-text">Konfigurasi</span>
                     
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('personil/index') ?>">
                <i class="fa fa-list text-orange"></i>
                <span class="nav-link-text">Personil Bermasalah</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('RD_polri/pilih') ?>">
                <i class="fa fa-home text-orange"></i>
                <span class="nav-link-text">Rumah Dinas</span>
              </a>
            </li>          
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('mutdat/index') ?>">
                <i class="ni ni-single-copy-04 text-orange"></i>
                <span class="nav-link-text">Mutdat</span>
              </a>
            </li>  
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('informasi/index') ?>">
                <i class="ni ni-email-83 text-orange"></i>
                <span class="nav-link-text">Informasi</span>
              </a>
            </li> 
          </ul>
        </div>        
        <?php endif ?>


      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark border-bottom" style="background-image: url('<?php echo base_url()?>/Assets/img/brand/header.jpg'); background-repeat: no-repeat; background-size: cover;  background-position: center;">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
          <form class="navbar-search  form-inline mr-sm-3 mt--2" id="navbar-search-main">
            <div class="form-group mb-0">
              <div class="input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                  <span class="text-white"><?php echo date('F j, Y, g:i a') ?></span>
                </div>
                
              </div>
            </div>
            </button>
          </form>
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
            
          </ul>
          <div class="col-md-8 text-white">
          <marquee><h3 class="text-white">SELAMAT DATANG DI WEBSITE BIDKEU ONLINE SUMSEL</h3></marquee> 
          

          </div>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar rounded-circle">
                   <?php if ($this->session->userdata('level') == 'satker'): ?>
                  
                    <img alt="Image placeholder" src="<?php echo base_url('Assets/img/brand/polda.png') ?>">
                  <?php endif ?>
                  <?php if ($this->session->userdata('level') == 'admin'): ?>
                  
                    <img alt="Image placeholder" src="<?php echo base_url('Assets/img/brand/keuangan.png') ?>">
                  <?php endif ?>
                  
                  </span>
                  <div class="media-body  ml-3  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">
                  
                 
                    <?php echo  $this->session->userdata('username'); ?>
                     
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
          
                <a href="<?php echo base_url('login/logout') ?>" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
