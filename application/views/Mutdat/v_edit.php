<?php $this->load->view('partials/header') ?>

      

    <div class="header bg-gradient-orange pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            
          </div>
          <!-- Card stats -->
         
        </div>
      </div>
    </div>


 <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
              
            <div class="card-header border-0">
              <h1 class="mb-0">Edit Mutdat</h1>
              <div class="text-right">
                <a href="<?php  echo base_url('mutdat') ?>" class="btn btn-sm btn-warning">Kembali</a>
              </div>
            </div>

        <div class="card-body">
            <?php foreach($mutdat as $p){ ?>
            <?php echo form_open_multipart('Mutdat/update') ?>
                <input type="hidden" class="form-control" name="id" value="<?php echo $p->id ?>">
                <div class="form-row">
                    <input type="hidden" class="form-control" name="satker" value="<?php echo $p->satker ?>">
                <div class="form-group col-md-5">
                    <label>BULAN:</label>
                    <input type="text" class="form-control" name="bulan"value="<?php echo $p->bulan ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>FILE :</label>
                    <input type="file" class="form-control" name="berkas">
                </div>
            </div>
                <input type="submit"  class="btn btn-primary" value="Simpan">
            </div>
            <?php echo form_close(); ?>
            <?php } ?>
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