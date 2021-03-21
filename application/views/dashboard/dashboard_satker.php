 <!-- Header -->

<?php
//ubah timezone menjadi jakarta
date_default_timezone_set("Asia/Jakarta");

//ambil jam dan menit
$jam = date('H:i');

//atur salam menggunakan IF
if ($jam > '05:30' && $jam < '10:00') {
    $salam = 'Pagi';
} elseif ($jam >= '10:00' && $jam < '15:00') {
    $salam = 'Siang';
} elseif ($jam < '18:00') {
    $salam = 'Sore';
} else {
    $salam = 'Malam';
}

//tampilkan pesan


?>
    <div class="header bg-gradient-orange pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-md-12 text-center">
              <h6 class="h2 text-white d-inline-block mb-0">Selamat <?php  echo $salam ?>, </h6><br> 
              <h5  class="h1 text-white  d-inline-block mb-0">  <?php echo $this->session->userdata('username') ?></h5><br>  
                      <img src="<?php echo base_url ('Assets/img/brand/logoatas.png') ?>"  width="160px" alt="...">
              
            </div>
          </div>
          <!-- Card stats -->
         
        </div>
      </div>
    </div>
    <!-- Page content -->
    
      