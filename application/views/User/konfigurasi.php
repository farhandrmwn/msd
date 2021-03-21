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
      <h1 class="mb-0">KONFIGURASI</h1>
        </div>


        <div class="card-body">
        <?php foreach($konfigurasi as $p){ ?>
            <form method="post" action="<?php echo base_url()?>User/update">
            <div class="form-row">
                    <input type="hidden" class="form-control" name="id_satker" value="<?php echo $p->id_satker ?>">
                <div class="form-group col-md-4">
                    <label>Nama Kabag:</label>
                    <input type="text" class="form-control" name="nama_kabag">
                </div>
                <div class="form-group col-md-4">
                    <label>Pangkat:</label>
                    <input type="text" class="form-control" name="jabatan_kabag">
                </div>
                <div class="form-group col-md-4">
                    <label>NRP Kabag:</label>
                    <input type="text" class="form-control" name="nrp_kabag">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Nama Kasikeu:</label>
                    <input type="text" class="form-control" name="nama_kasikeu">
                </div>
                <div class="form-group col-md-4">
                    <label>Pangkat:</label>
                    <input type="text" class="form-control" name="jabatan_kasikeu">
                </div>
                <div class="form-group col-md-4">
                    <label>NRP Kasikeu:</label>
                    <input type="text" class="form-control" name="nrp_kasikeu">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Nama Kasi:</label>
                    <input type="text" class="form-control" name="nama_kasi">
                </div>
                <div class="form-group col-md-4">
                    <label>Pangkat:</label>
                    <input type="text" class="form-control" name="jabatan_kasi">
                </div>
                <div class="form-group col-md-4">
                    <label>NRP Kasi:</label>
                    <input type="text" class="form-control" name="nrp_kasi">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Nama Kepala Kepolisian:</label>
                    <input type="text" class="form-control" name="nama_kepala">
                </div>
                <div class="form-group col-md-4">
                    <label>Pangkat:</label>
                    <input type="text" class="form-control" name="jabatan_kepala">
                </div>
                <div class="form-group col-md-4">
                    <label>NRP Kepala Kepolisian:</label>
                    <input type="text" class="form-control" name="nrp_kepala">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Nama Kepala Keuangan:</label>
                    <input type="text" class="form-control" name="nama_keuangan">
                </div>
                <div class="form-group col-md-4">
                    <label>Pangkat:</label>
                    <input type="text" class="form-control" name="jabatan_keuangan">
                </div>
                <div class="form-group col-md-4">
                    <label>NRP Kepala Keuangan:</label>
                    <input type="text" class="form-control" name="nrp_keuangan">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Alamat:</label>
                    <input type="text" class="form-control" name="alamat">
                </div>
            </div>
            
            <div class="form-group">
                <input type="submit"  class="btn btn-primary"   value="Simpan">
            </div>
            </form>
        <?php } ?>
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