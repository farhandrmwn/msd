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
              <h1 class="mb-0">Edit Data Personil</h1>
              <div class="text-right">
                <a href="<?php  echo base_url('RD_pns_polri') ?>" class="btn btn-sm btn-warning">Kembali</a>
              </div>
            </div>


        <div class="card-body">
        <?php foreach($rdpnspolri as $rd) { ?>
            <form method="post" action="<?php echo base_url()?>RD_pns_polri/update">
            <div class="form-row">
            <input type="hidden" class="form-control" name="id" value="<?php echo $rd->id ?>">
                <div class="form-group col-md-6">
                    <label>SATKER:</label>
                    <input type="text" class="form-control" name="satker" value="<?= $rd->satker ?>">
                </div>
            </div>
            <div class="card text-center card-header card text-orange bg-secondary">GOL-IV</div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>KUAT:</label>
                    <input type="text" class="form-control" name="gol4_kuat" id="gol4_kuat" value="<?= $rd->gol4_kuat ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>POT:</label>
                    <input type="text" class="form-control" name="gol4_pot" id="gol4_pot" value="<?= $rd->gol4_pot ?>">
                </div>
            </div>
            <div class="card text-center card-header card text-orange bg-secondary">GOL-III</div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>KUAT:</label>
                    <input type="text" class="form-control" name="gol3_kuat" id="gol3_kuat" value="<?= $rd->gol3_kuat ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>POT:</label>
                    <input type="text" class="form-control" name="gol3_pot" id="gol3_pot" value="<?= $rd->gol3_pot ?>">
                </div>
            </div>
            <div class="card text-center card-header card text-orange bg-secondary">GOL-II</div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>KUAT:</label>
                    <input type="text" class="form-control" name="gol2_kuat" id="gol2_kuat" value="<?= $rd->gol2_kuat ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>POT:</label>
                    <input type="text" class="form-control" name="gol2_pot" id="gol2_pot" value="<?= $rd->gol2_pot ?>">
                </div>
            </div>
            <div class="card text-center card-header card text-orange bg-secondary">JUMLAH</div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>KUAT:</label>
                    <input type="text" class="form-control" name="jml_kuat" id="jml" readonly="readonly" value="<?= $rd->jml_kuat ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>POT:</label>
                    <input type="text" class="form-control" name="jml_pot" id="jml_pot" readonly="readonly" value="<?= $rd->jml_pot ?>">
                </div>
            </div>
            
            <div class="form-group">
            	<div class="form-group col-md-13">
                    <label>KETERANGAN:</label>
                    <input type="text" class="form-control" name="ket" value="<?= $rd->ket ?>">
                </div>
            </div>
            <div class="form-group">
                <input type="submit"  class="btn btn-primary" value="Simpan">
            </div>
            </form>
        <?php } ?>
        </div>
        </div>
    </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#gol4_kuat, #gol3_kuat, #gol2_kuat").on('input',function() {
            var gol4_kuat  = $("#gol4_kuat").val();
            var gol3_kuat = $("#gol3_kuat").val();
            var gol2_kuat = $("#gol2_kuat").val();

            var jml = parseInt(gol4_kuat) + parseInt(gol3_kuat) + parseInt(gol2_kuat);
            $("#jml").val(jml);
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#gol4_pot, #gol3_pot, #gol2_pot").on('input',function() {
            var gol4_pot  = $("#gol4_pot").val();
            var gol3_pot = $("#gol3_pot").val();
            var gol2_pot = $("#gol2_pot").val();

            var jml_pot = parseInt(gol4_pot) + parseInt(gol3_pot) + parseInt(gol2_pot);
            $("#jml_pot").val(jml_pot);
        });
    });
</script>


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