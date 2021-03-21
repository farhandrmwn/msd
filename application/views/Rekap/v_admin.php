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
      <h1 class="mb-0"> Rekap Mutdat</h1>
        </div>

        <div class="card-body">
          <a href="<?php echo base_url()?>rekap/tambah" class="btn btn-primary" role="button">Tambah Data</a>
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered text-center mt-4">
                  <thead>
                    <tr>
                      <th scope="col" rowspan="2" class="align-middle">NO</th>
                      <th scope="col" rowspan="2" class="align-middle">WAKTU</th>
                      <th scope="col" rowspan="2" class="align-middle">FILE</th>
                      <th scope="col" rowspan="2" class="align-middle">KETERANGAN</th>
                      <th scope="col" rowspan="2" class="align-middle">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php 
                        $no = 1;
                        foreach($rekap as $m){ 
                    ?>
               		<tr>
                    	<th scope="row"><?php echo $no++ ?></th>
               			<td><?php echo $m->waktu ?></td>
               			<td><?php echo $m->file ?></td>
               			<td><?php echo $m->keterangan ?></td>
               			<td>
                        <a href="<?= base_url('rekap/edit/'.$m->id_rekap) ?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a href="<?= base_url('rekap/hapus/'.$m->id_rekap) ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Remove</a>
                        <a href="<?php echo base_url(); ?>rekap/download/<?php echo $m->id_rekap; ?>" class="btn btn-success">Download</a>
                     </td>
               		</tr>
               	<?php } ?>
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