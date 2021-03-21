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
      <h1 class="mb-0"> User</h1>
        </div>

        <div class="card-body">
          <a href="<?php echo base_url()?>/user/tambah" class="btn btn-primary" role="button">Tambah Data</a>
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered text-center mt-4">
                  <thead>
                    <tr>
                      <th scope="col" rowspan="2" class="align-middle">NO</th>
                      <th scope="col" rowspan="2" class="align-middle">ID SATKER</th>
                      <th scope="col" rowspan="2" class="align-middle">SATKER/SATWIL</th>
                      <th scope="col" rowspan="2" class="align-middle">USERNAME</th>
                      <th scope="col" rowspan="2" class="align-middle">PASSWORD</th>
                      <th scope="col" rowspan="2" class="align-middle">LEVEL</th>
                      <th scope="col" rowspan="2" class="align-middle">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php 
                        $no = 1;
                        foreach($user as $u){ 
                    ?>
               		<tr>
                    	<th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $u->id_satker ?></td>
               			<td><?php echo $u->satker ?></td>
               			<td><?php echo $u->username ?></td>
                    <td><?php echo $u->password ?></td>
               			<td><?php echo $u->level ?></td>
               			<td>
                        <a href="<?= base_url('user/hapus/'.$u->id_satker) ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Remove</a>
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