<?php $this->load->view('partials/header') ?>

  <div class="header bg-gradient-orange pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            
          </div>
          
         
        </div>
      </div>
    </div>
 <div class="container-fluid mt--6">

        <div class="card mt-0">
        <div class="card-header">
      <h1 class="mb-0">REKAP PERSONIL BERMASALAH</h1>
        </div>
        <br>
        <div class="container">
           <form method="post" action="<?php echo base_url('Rekap_personil/index')?>">
       <div class="col-md-12">
                <div class="container"> 
                <div class="row">  
                <div class="col-md-5">
                  
                </div>
                <div class="col-md-3">
                <div class="form-group">
                <h3 class="">
                  Bulan
                </h3>
                <div class="row">
                <select class="form-control col-md-10 ml-3" name="bulan">
                  <option disabled="" selected="" value="01">-pilih bulan-</option>
                  <option value="01">Januari</option>
                  <option value="02">Februari</option>
                  <option value="03">Maret</option>
                  <option value="04">April</option>
                  <option value="05">Mei</option>
                  <option value="06">Juni</option>
                  <option value="07">Juli</option>
                  <option value="08">Agustus</option>
                  <option value="09">September</option>
                  <option value="10">Oktober</option>
                  <option value="11">November</option>
                  <option value="12">Desember</option>
             

                </select>
                </div>
                  </div>
                </div>
                <div class="col-md-3">
                <div class="form-group">
                <h3 class="">
                  Tahun
                </h3>
                <div class="row">
                <select class="form-control col-md-10 ml-3" name="tahun">
                  <option value="21">2021</option>                  
                  <option value="22">2022</option>                  
                
                </select>
                </div>
                  </div>
                </div>
                <div class="col-md-1 text-left">
                  <div class="form-group">
                <h3 class="text-white">.</h3>
                <button class="btn btn-warning">Filter</button>
                    
                  </div>
                </div>
              </div>
              </div>
              </div>
        </form>
        </div>
        <div class="card-body">
            <a href="<?php echo base_url('Rekap_personil/excel?bulan='.$b.'&tahun='.$t.''); ?>" class='btn btn-success'>Export Data</a> 
           



<!-- 
            <?php foreach ($satker as $index => $key) {
              $kata = $key->id_satker; 
             ?>

              <td><?php echo $kata ?>
                    <?php
                    $q= $this->db->query("SELECT * FROM tb_pyb WHERE id_satker = '$kata' and bulan like '%".$b.$t."%' ")->result(); 
                      foreach ($q as $a) {
                        echo $a->nama;
                      }
                    ?>
              </td>

             <?php } ?>
 -->

            <div class="table-responsive text-nowrap">

                <table class="table table-bordered text-center mt-4">
                  <thead>
                    <tr>
                      <th scope="col" rowspan="2" colspan="2" class="align-middle" width="10%">NO</th>
                      <th scope="col" rowspan="2" class="align-middle">NAMA</th>
                      <th scope="col" rowspan="2" class="align-middle">PANGKAT/NRP</th>
                      <th scope="col" rowspan="2" class="align-middle">JENIS KASUS</th>
                      <th scope="col" rowspan="2" class="align-middle">PROSES S/D HARI INI</th>
                      <th scope="col" colspan="3">PROSES SIDANG (TMT INKRACHT)</th>
                      <th scope="col" colspan="3">LAMA PUTUSAN</th>
                      <th scope="col" colspan="3">TEMPAT MENJALIN HUKUMAN</th>
                      <th scope="col" colspan="3">PEMBAYARAN PENGHASILAN</th>
                      <th scope="col" rowspan="2" class="align-middle">TPTGR</th>
                      <th scope="col" rowspan="2" class="align-middle">FILES</th>
                      <th scope="col" rowspan="2" class="align-middle">KETERANGAN</th>
                      <th scope="col" rowspan="2" class="align-middle">WAKTU</th>
                    </tr>
                    <tr>
                        <th scope="col">PIDANA UMUM</th>
                        <th scope="col">ETIK / PROFESI</th>
                        <th scope="col">DISIPLIN</th>
                        <th scope="col">PIDANA UMUM</th>
                        <th scope="col">ETIK / PROFESI</th>
                        <th scope="col">DISIPLIN</th>
                        <th scope="col">PIDANA UMUM</th>
                        <th scope="col">ETIK / PROFESI</th>
                        <th scope="col">DISIPLIN</th>
                        <th scope="col">PENGHENTIAN SEMENTARA GAJI ( TMT )</th>
                        <th scope="col">PEMBAYARAN GAJI 75% ( TMT )</th>
                        <th scope="col">PENGHENTIAN TUNKUN ( TMT )</th>
                    </tr>
                  </thead>
                  <tbody>

                     <?php 
                      $no2 = 1;
                     foreach ($satker as $index => $key) {
                      $kata = $key->id_satker; 
                      $stk = $key->satker; 
                      $q= $this->db->query("SELECT * FROM tb_pyb WHERE id_satker = '$kata' and bulan like '%".$b.$t."%' ")->result(); 
                      $no = 1;
                      ?>
                        <tr> 
                          <td><?php echo $no2++ ?></td>
                          <td colspan="22" align="left" class="text-uppercase" ><b><?php echo $stk; ?></b></td>
                        </tr>
                      <?php foreach ($q as $p){ 
                    ?>
                    <?php 
                        if ($p->bulan == '0121') {
                          $bulan = 'Januari 2021';
                        }elseif ($p->bulan == '0221') {
                          $bulan = 'Februari 2021';
                        }elseif ($p->bulan == '0321') {
                          $bulan = 'Maret 2021';
                        }elseif ($p->bulan == '0421') {
                          $bulan = 'April 2021';
                        }elseif ($p->bulan == '0521') {
                          $bulan = 'Mei 2021';
                        }elseif ($p->bulan == '0621') {
                          $bulan = 'Juni 2021';
                        }elseif ($p->bulan == '0721') {
                          $bulan = 'Juli 2021';
                        }elseif ($p->bulan == '0821') {
                          $bulan = 'Agustus 2021';
                        }elseif ($p->bulan == '0921') {
                          $bulan = 'September 2021';
                        }elseif ($p->bulan == '1021') {
                          $bulan = 'Oktober 2021';
                        }elseif ($p->bulan == '1121') {
                          $bulan = 'November 2021';
                        }elseif ($p->bulan == '1221') {
                          $bulan = 'Desember 2021';
                        }
                       ?>

                    <tr>
                      <th></th>
                      <th scope="row"><?php echo $no++ ?></th>
                      <td><?php echo $p->nama ?></td>
                      <td><?php echo $p->pangkat." / ".$p->nrp ?></td>
                      <td><?php echo $p->jenis_kasus ?></td>
                      <td><?php echo $p->proses ?></td>
                      <td><?php echo $p->pidum_ps ?></td>
                      <td><?php echo $p->etikprofesi_ps ?></td>
                      <td><?php echo $p->disiplin_ps ?></td>
                      <td><?php echo $p->pidum_lp ?></td>
                      <td><?php echo $p->etikprofesi_lp ?></td>
                      <td><?php echo $p->disiplin_lp ?></td>
                      <td><?php echo $p->pidum_tmh ?></td>
                      <td><?php echo $p->etikprofesi_tmh ?></td>
                      <td><?php echo $p->disiplin_tmh ?></td>
                      <td><?php echo $p->penghentian_smntr ?></td>
                      <td><?php echo $p->byr_gj_tjhlima ?></td>
                      <td><?php echo $p->penghentian_tunkun ?></td>
                      <td><?php echo $p->tptgr ?></td>
                      <td><?php echo $p->file ?></td>
                      <td><?php echo $p->keterangan ?></td>
                      <td><?php echo $bulan ?></td>
                    </tr>
                    <?php } } ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>

<?php $this->load->view('partials/footer') ?>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
<script>
   $(document).ready(function() {
      $('#example').DataTable();
  } );
</script>