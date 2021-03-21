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
         <h1 class="mb-0">Informasi</h1>
        </div>
         <?php foreach ($informasi as $key): ?>
        <div class="col-md-12">
          <div class="row">
              <div class="col-md-12">
                <div class="card card-profile  border border-warning rounded">
                  <div class="row"> 
                  <div class="col-md-3 text-center"> 
                      <img src="<?php echo base_url ('Assets/img/brand/logoatas.png') ?>"  alt="...">

                  </div>
                  <div class="col-md-6"> 
                      <div class="text-center mt-3">
                        <h2 class="text-orange"><?php echo $key->judul ?></h2>
                           <i class="fa fa-clock mt-0 "></i></i>&nbsp;<?php echo $key->waktu; ?>
                            <hr>
                            <h3 class=""><?php echo $key->deskripsi ?></h3>
                        </div>
                    </div>
                    <div class="col-md-3 text-center"> 
                      <img src="<?php echo base_url ('Assets/img/brand/logoatasmir.png') ?>"  alt="...">

                  </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach ?>

            </div>
        </div>
            <!-- Card footer -->
  
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