<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Login - BIDKEU ONLINE SUMSEL</title>
  <!-- Favicon -->
  <link rel="icon" href="<?php echo base_url('Assets/img/brand/polda.png') ?>" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?php echo base_url('Assets/vendor/nucleo/css/nucleo.css') ?>" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url('Assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>" type="text/css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?php echo base_url('Assets/css/argon.css?v=1.2.0') ?>" type="text/css">
   <style type="">
              .judul{
                 -webkit-text-stroke: 1px black;
                 font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
                 font-weight: 100;
                 font-size: 3.5vh;
                   color: black;
                  text-shadow:
                   -1px -1px 0 black,  
                    1px -1px 0 black,
                    -1px 1px 0 black,
                     1px 1px 0 black;
                              }
                              .gambar{
                                
                  -webkit-filter: drop-shadow(5px 5px 5px #222);
                  filter: drop-shadow(5px 5px 5px #222);
                              }

                .box { position: relative; z-index: 1; }
                .box .back {
                    position: absolute; z-index: 1;
                    top: 0; left: 0; width: 100%; height: 100%;
                    background: white; opacity: 0.75;
                }
                .box .text { position: relative; z-index: 2; }

                body.browser-ie8 .box .back { filter: alpha(opacity=75); }


              input[type=text] {
                  border: 1px solid blue;
                  border-radius: 4px;
                  width: 100%;
                  height: 30px;
                }
                 input[type=password] {
                  border: 1px solid blue;
                  border-radius: 4px;
                  width: 100%;
                  height: 30px;
                }
                            </style>
</head>

<body class="" style="background-image: url('<?php echo base_url()?>/Assets/img/brand/login3.jpg'); background-repeat: no-repeat; background-position: top;">
  <!-- Navbar -->
  <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
    
  </nav>
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header py-4 ">
      <div class="container">
          <div class="header-body text-center mb-0">
          <br><br>
        </div>
      </div>
      
    </div>
    <!-- Page content -->
    <div class="container">
      
    
      <div class="row mt-7">
        <div class="col-md-3">
          
        </div>
    <div class="col-md-6">
         <div class="box">
                <div class="back rounded">
              
                </div>
                <div class="text  ">
                  <div class="row mb-3">
                    
                  </div>
                   <div class="text-center text-muted ">
                      <img src="<?php echo base_url('Assets/img/brand/keuangan.png') ?>" class="gambar mb-3" width="70px">
                      <h2 >LOGIN KEUANGAN MANG PEDEKA</h2>
                </div>
                    <div class="ml-5 mt-4 mr-5">
                     <form action="<?php echo base_url('login/loginact') ?>" method="POST">
                        <div class="form-group mb-3">
                        <label>
                          <h3 class="mb--3">Username</h3>
                          </label>
                          <input class="form-control" name="username" type="text">
                       </div>
                      <div class="form-group mb-3">
                        <label>
                          <h3>Password</h3>
                          </label>
                          <input class="form-control mt--3" name="password" type="password">
                       </div>
                         <div class="form-group mb-3">
                          <?php if($message = $this->session->flashdata('message')): ?>
                              <div class="alert alert-danger alert-sm alert-block">
                              <button type="button" class="close" data-dismiss="alert">x</button>
                                <?= $message ?>
                              </div>
                            <?php endif ?>
                             <?php if($message = $this->session->flashdata('sukses')): ?>
                              <div class="alert alert-success alert-sm alert-block">
                              <button type="button" class="close" data-dismiss="alert">x</button>
                                <?= $message ?>
                              </div>
                            <?php endif ?>
                        </div>
                         <div class="text-center">
                        <button class="btn btn-primary btn-block mt-2 my-4">Login</button>
                        </div>
                        <div class="row mb-4">
                          
                        </div>
                      </form>

                    </div>
                </div>
          </div>
        
        
        <!--  <div class="card browser-ie8  der-0 mb-0 mt-4  mb-5  ">
            <div class="card-body px-lg-5 py-lg-5 ">
              <div class="text-center text-muted mb-4 ">
                <h2>Login</h2>
                <h3>MSD BIDKEU SUMSEL</h3>
              </div>
               <form action="<?php echo base_url('login/loginact') ?>" method="POST">
                <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" placeholder="Email" name="username" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Password" name="password" type="password">
                  </div>
                </div>
                <div class="form-group">
                  <?php if($message = $this->session->flashdata('message')): ?>
                      <div class="alert alert-danger alert-sm alert-block">
                      <button type="button" class="close" data-dismiss="alert">x</button>
                        <?= $message ?>
                      </div>
                    <?php endif ?>
                     <?php if($message = $this->session->flashdata('sukses')): ?>
                      <div class="alert alert-success alert-sm alert-block">
                      <button type="button" class="close" data-dismiss="alert">x</button>
                        <?= $message ?>
                      </div>
                    <?php endif ?>
                </div>
                  
                <div class="text-center">
                  <button class="btn btn-warning btn-block mt-2 my-4">Sign in</button>
                </div>
              </form>
            <!-- <form method="post" action="<?php echo base_url()?>login">
                <div class="form-group">
                    <?php if (validation_errors())
                        {?>
                        <div class="alert alert-danger alert-sm alert-block">
                      <button type="button" class="close" data-dismiss="alert">x</button>
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php
                    } ?>
                    <?php echo $this->session->flashdata('pemberitahuan'); ?>
                </div>
              
                <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input type="text" class="form-control" name="username" placeholder="Masukan Username">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                <input type="password" class="form-control" name="password" placeholder="Masukan Password">
                    
                  </div>
                </div>
                  
                <div class="text-center">
                
                <input type="submit"  class="btn btn-warning btn-block mt-2 my-4"   name="tombol_login" value="Login">

                </div>
              </form> -->
          <div class="row mt-3">
            
            
          </div>
            </div>
          </div>
        </div>   -->
    </div>    
    

  </div>
  <!-- Footer -->
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="<?php echo base_url('Assets/vendor/jquery/dist/jquery.min.js') ?>"></script>
  <script src="<?php echo base_url('Assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?php echo base_url('Assets/vendor/js-cookie/js.cookie.js') ?>"></script>
  <script src="<?php echo base_url('Assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') ?>"></script>
  <script src="<?php echo base_url('Assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') ?>"></script>
  <!-- Argon JS -->
  <script src="<?php echo base_url('Assets/js/argon.js?v=1.2.0') ?>"></script>
</body>
<!-- <body>
    <div class="container">
            <h2>Login</h2><br>
        <?php if (validation_errors())
        {?>
        <div class="alert alert-danger">
            <?php echo validation_errors(); ?>
        </div>
        <?php
        } ?>
        <?php echo $this->session->flashdata('pemberitahuan'); ?>
        <form method="post" action="<?php echo base_url()?>login">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" class="form-control" name="username" placeholder="Masukan Username">
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" class="form-control" name="password" placeholder="Masukan Password">
        </div>
        <div class="form-group">
            <input type="submit"  class="btn btn-primary"   name="tombol_login" value="Login">
        </div>
        </form>
    </div>
</body> -->
</html>