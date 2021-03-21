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
              <h1 class="mb-0">Edit Data Personil Bermasalah</h1>
              <div class="text-right">
                <a href="<?php  echo base_url('personil') ?>" class="btn btn-sm btn-warning">Kembali</a>
              </div>
            </div>


        <div class="card-body">
            <?php foreach($informasi as $i){ ?>
            <form method="post" action="<?php echo base_url()?>Informasi/update">
                <input type="hidden" class="form-control" name="id" value="<?php echo $i->id ?>">
                <div class="form-row">
                <div class="form-group col-md-5">
                    <label>SATKER:</label>
                    <select name="satker" id="inputState" class="form-control" value="<?php echo $i->id_satker ?>">
                      <option value="">--Dimohon memilih Satker--</option>
                      <?php 
                        foreach($user as $u){ 
                    ?>
                      <option value="<?php echo $u->satker ?>"><?php echo $u->satker ?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label>JUDUL:</label>
                    <input type="text" class="form-control" name="judul" value="<?php echo $i->judul ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>DESKRIPSI :</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="deskripsi" rows="3"><?php echo $i->deskripsi ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <input type="submit"  class="btn btn-primary" value="Update">
            </div>
            </form>
            <?php } ?>
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