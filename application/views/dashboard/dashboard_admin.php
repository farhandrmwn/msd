 <!-- Header -->
    <div class="header bg-gradient-orange pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-12 col-7 text-center">
              <h6 class="h4 text-white d-inline-block mb-0 ">Selamat Datang </h6><br>
              <h5 class="h2 text-white text-uppercase d-inline-block mb-0 "><?php echo $this->session->userdata('username'); ?> </h5>
              
            </div>
          </div>
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-4 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Personil Bermasalah</h5>
                      <span class="h2 font-weight-bold mb-0">
                      <?php 
                        $query = $this->db->query("SELECT * FROM tb_pyb");

                        echo $query->num_rows();

                        ?>
                      </span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                        <i class="fa fa-check"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-nowrap mr-2"><i class="fa fa-calendar"></i></span>
                    <span class="text-nowrap"><?php 
                    function tgl_indo($tanggal){
                        $bulan = array (
                            1 =>   'Januari',
                            'Februari',
                            'Maret',
                            'April',
                            'Mei',
                            'Juni',
                            'Juli',
                            'Agustus',
                            'September',
                            'Oktober',
                            'November',
                            'Desember'
                        );
                        $pecahkan = explode('-', $tanggal);
                        
                        // variabel pecahkan 0 = tanggal
                        // variabel pecahkan 1 = bulan
                    // variabel pecahkan 2 = tahun
                 
                    return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
                        }
                 
                        $tgl = tgl_indo(date('Y-m-d')); // 21 Oktober 2017

           


                        $query = $this->db->query("SELECT * FROM tb_pyb WHERE bulan = '$tgl'");

                        echo $query->num_rows();

                        ?> Bulan ini</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Rumah Dinas Polri</h5>
                       <span class="h2 font-weight-bold mb-0">
                      <?php 
                        $query = $this->db->query("SELECT * FROM tb_potongan_polri");

                        echo $query->num_rows();

                        ?>
                      </span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                        <i class="fa fa-cogs"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-nowrap mr-2"><i class="fa fa-calendar"></i></span>
                    <span class="text-nowrap"><?php

                        $query = $this->db->query("SELECT * FROM tb_potongan_polri WHERE bulan = '$tgl'");

                        echo $query->num_rows();

                        ?> Bulan ini</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Rumah Dinas PNS Polri</h5>
                       <span class="h2 font-weight-bold mb-0">
                      <?php 
                        $query = $this->db->query("SELECT * FROM tb_potongan_pns");

                        echo $query->num_rows();

                        ?>
                      </span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                        <i class="fa fa-cogs"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-nowrap mr-2"><i class="fa fa-calendar"></i></span>
                    <span class="text-nowrap"><?php

                        $query = $this->db->query("SELECT * FROM tb_potongan_pns WHERE bulan = '$tgl'");

                        echo $query->num_rows();

                        ?> Bulan ini</span>
                </div>
              </div>
            </div>
           
          </div>
          <div class="row">
            <div class="col-xl-12 col-md-12 py-6">
              <div class="card card-stats">
                <!-- Card body -->
               
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    

    
      