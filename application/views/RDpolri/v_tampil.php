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
      <h1 class="mb-0"> RUMAH DINAS POLRI</h1>
           <div class="text-right">
                <a href="<?php  echo base_url('RD_polri/pilih') ?>" class="btn btn-sm btn-warning">Kembali</a>
              </div>
        </div>
         <form method="post" action="<?php echo base_url('RD_polri/index')?>">
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

        <div class="card-body">
            <?php foreach($rdpolri as $p){ 
              $cek = $p->bulan;
            $s = substr($cek, -4,4);}?>
            <form method="POST" action="<?php echo base_url('RD_polri/excel?$bulan='.$s.''); ?>">
            <input type="hidden" name="bulan" value="<?php echo $s ?>">
            <button class='btn btn-success'> Export Data</button>      
            </form>
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered text-center mt-4">
                  <thead>
                    <tr>
                      <th scope="col" rowspan="3" class="align-middle">NO</th>
                      <th scope="col" rowspan="3" class="align-middle">BULAN</th>
                      <th scope="col" colspan="6" class="align-middle">PANGKAT</th>
                      <th scope="col" rowspan="2" colspan="2" class="align-middle">JUMLAH</th>
                      <th scope="col" rowspan="3" class="align-middle">KETERANGAN</th>
                      <th scope="col" rowspan="3" class="align-middle">AKSI</th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="2">PAMEN</th>
                        <th scope="col" colspan="2">PAMA</th>
                        <th scope="col" colspan="2">BINTARA</th>
                    </tr>
                    <tr>
                        <th scope="col">KUAT</th>
                        <th scope="col">POT</th>
                        <th scope="col">KUAT</th>
                        <th scope="col">POT</th>
                        <th scope="col">KUAT</th>
                        <th scope="col">POT</th>
                        <th scope="col">KUAT</th>
                        <th scope="col">POT</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $no = 1;
                        foreach($rdpolri as $r){ 
                    ?>
                    <?php 
                        if ($r->bulan == '0121') {
                          $bulan = 'Januari 2021';
                        }elseif ($r->bulan == '0221') {
                          $bulan = 'Februari 2021';
                        }elseif ($r->bulan == '0321') {
                          $bulan = 'Maret 2021';
                        }elseif ($r->bulan == '0421') {
                          $bulan = 'April 2021';
                        }elseif ($r->bulan == '0521') {
                          $bulan = 'Mei 2021';
                        }elseif ($r->bulan == '0621') {
                          $bulan = 'Juni 2021';
                        }elseif ($r->bulan == '0721') {
                          $bulan = 'Juli 2021';
                        }elseif ($r->bulan == '0821') {
                          $bulan = 'Agustus 2021';
                        }elseif ($r->bulan == '0921') {
                          $bulan = 'September 2021';
                        }elseif ($r->bulan == '1021') {
                          $bulan = 'Oktober 2021';
                        }elseif ($r->bulan == '1121') {
                          $bulan = 'November 2021';
                        }elseif ($r->bulan == '1221') {
                          $bulan = 'Desember 2021';
                        }
                       ?>
                    <tr>
                      <th scope="row"><?= $no++ ?></th>
                      <td><?= $bulan ?></td>
                      <td id="pmn_kuat"><?= $r->pamen_kuat ?></td>
                      <td><?= $r->pamen_pot ?></td>
                      <td><?= $r->pama_kuat ?></td>
                      <td><?= $r->pama_pot ?></td>
                      <td><?= $r->bintara_kuat ?></td>
                      <td><?= $r->bintara_pot ?></td>
                      <td><?= $r->jml_kuat ?></td>
                      <td> <?=  $r->jml_pot ?></td>
                      <td><?= $r->ket ?></td>
                      <td>
                        <a href="<?= base_url('rd_polri/edit/'.$r->id) ?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a href="<?= base_url('rd_polri/hapus/'.$r->id) ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Remove</a>
                     </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                  <tbody>
                          <th colspan="2">JUMLAH</th>
                          <td id="tot"><?= $total_pmnkuat ?></td>
                          <td><?= $total_pmnpot ?></td>
                          <td><?= $total_pmkuat ?></td>
                          <td><?= $total_pmpot ?></td>
                          <td><?= $total_bntrkuat ?></td>
                          <td><?= $total_bntrpot ?></td>
                          <td><?= $total_jmlkuat ?></td>
                          <td><?= $total_jmlhpot ?></td>
                  </tbody>
                </table>
            </div>
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