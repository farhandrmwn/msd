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
      <h1 class="mb-0"> RUMAH DINAS PNS</h1>
        <div class="text-right">
           <a href="<?php  echo base_url('Tampil/rekap_rumdin') ?>" class="btn btn-sm btn-warning">Kembali</a>
              </div>
    </div>
    <br>
    <form method="post" action="<?php echo base_url('Rekap_Rumdin_Pns/index')?>">
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
                        <th scope="col" colspan="2">GOL-IV</th>
                        <th scope="col" colspan="2">GOL-III</th>
                        <th scope="col" colspan="2">GOL-II</th>
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
                        foreach($rdpnspolri as $r){ 
                    ?>
                    <tr>
                      
                      <th scope="row"><?= $no++ ?></th>
                      <td align="left"><?= $r->satker ?></td>
                      <td><?= $r->gol4_kuat ?></td>
                      <td><?= $r->gol4_pot ?></td>
                      <td><?= $r->gol3_kuat ?></td>
                      <td><?= $r->gol3_pot ?></td>
                      <td><?= $r->gol2_kuat ?></td>
                      <td><?= $r->gol2_pot ?></td>
                      <td><?= $r->jml_kuat ?></td>
                      <td><?=  $r->jml_pot ?></td>
                      <td><?= $r->ket ?></td>
                      <td>
                        <a href="<?= base_url('rd_pns_polri/edit/'.$r->id) ?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a href="<?= base_url('rd_pns_polri/hapus/'.$r->id) ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Remove</a>
                     </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                  <tbody>
                          <th colspan="2">JUMLAH</th>
                          <td><?= $total_gol4kuat ?></td>
                          <td><?= $total_gol4pot ?></td>
                          <td><?= $total_gol3kuat ?></td>
                          <td><?= $total_gol3pot ?></td>
                          <td><?= $total_gol2kuat ?></td>
                          <td><?= $total_gol2pot ?></td>
                          <td><?= $total_jmlhkuat ?></td>
                          <td><?= $total_jmlhpot ?></td>
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