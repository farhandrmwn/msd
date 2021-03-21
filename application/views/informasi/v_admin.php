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

        <div class="card-body">
            <a href="<?php echo base_url()?>/informasi/tambah" class="btn btn-primary" role="button">Tambah Data</a>
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered text-center mt-4">
                  <thead>
                    <tr>
                      <th scope="col" class="align-middle">NO</th>
                      <th scope="col" class="align-middle">SATKER</th>
                      <th scope="col" class="align-middle">JUDUL</th>
                      <th scope="col" class="align-middle">DESKRIPSI</th>
                      <th scope="col" class="align-middle">WAKTU</th>
                      <th scope="col" class="align-middle">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $no = 1;
                        foreach($informasi as $i){ 
                    ?>
                    <tr>
                      <th scope="row"><?php echo $no++ ?></th>
                      <td><?php echo $i->satker ?></td>
                      <td><?php echo $i->judul ?></td>
                      <td><?php echo $i->deskripsi ?></td>
                      <td><?php echo $i->waktu ?></td>
                      <td>
                        <a href="<?= base_url('Informasi/edit/'.$i->id) ?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a href="<?= base_url('Informasi/hapus/'.$i->id) ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Remove</a></td>
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