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
              <h1 class="mb-0">Tambah Data Personil PNS </h1>
                 <div class="text-right">
                <a href="<?php  echo base_url('PersonilPns/index') ?>" class="btn btn-sm btn-warning">Kembali</a>
              </div>
            </div>


        <div class="card-body">
            <form method="post" action="<?php echo base_url()?>PersonilPns/tambah_aksi">
           <div class="form-row">
                <div class="form-group col-md-6">
                    <label>NRP</label>
                    <input type="text" class="form-control" name="nrp">
                </div>
                <div class="form-group col-md-6">
                    <label>Nama</label>
                    <input type="text" class="form-control" name="nama">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Golongan</label>
                    <select name="pangkat" class="form-control">
                      <option value="2">Golongan II</option>
                      <option value="3">Golongan III</option>
                      <option value="4">Golongan IV</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Jabatan</label>
                    <input type="text" class="form-control" name="jabatan">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Alamat Rumdin</label>
                    <textarea class="form-control" rows="4" name="alamat"></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>Jumlah POT</label>
                    <input type="text" class="form-control" name="pot">
                </div>
            </div>
           
            <div class="form-group">
                <input type="submit"  class="btn btn-primary"   name="tombol_login" value="Simpan">
            </div>
            </form>
        </div>
        </div>
    </div>
</div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>




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