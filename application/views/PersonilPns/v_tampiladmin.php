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
      <h1 class="mb-0"> PERSONIL  PNS</h1>
           <div class="text-right">
                <a href="<?php  echo base_url('RD_polri/pilih') ?>" class="btn btn-sm btn-warning">Kembali</a>
              </div>
        </div>
        <br>
        <div class="container">
    <form method="post" action="<?php echo base_url('PersonilPns/admin')?>">
       <div class="col-md-12">
                <div class="row">   
                <div class="col-md-3">
                <div class="form-group">
                <h3 class="">
                  Pilih Satker/Satwil
                </h3>
                <div class="row">
                <select class="form-control col-md-10 ml-3" name="satker">
                  <?php 
                  foreach ($satker as $key) { ?>
                    <option value="<?php echo $key->id_satker ?>"><?php echo $key->satker ?></option>
                  <?php } ?>
                </select>
                </div>
                  </div>
                </div>
                  <div class="col-md-3">
                <div class="form-group">
                <h3 class="">
                  Bulan
                </h3>
                <div class="row">
                <select class="form-control col-md-10 ml-3" name="bulan">
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
                <div class="col-md-1">
                  <div class="form-group">
                <h3 class="text-white">.</h3>
                <button class="btn btn-warning">Filter</button>
                    
                  </div>
                </div>
              </div>
              </div>
        </form>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered text-center mt-4">
                  <thead>
                
                    <tr>
                        <th>No</th>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Golongan</th>
                        <th>Jabatan</th>
                        <th>Alamat Rumdin</th>
                        <th>Jumlah POT</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                 
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