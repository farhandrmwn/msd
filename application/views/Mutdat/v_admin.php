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
      <h1 class="mb-4"> Mutdat</h1>
        <form method="post" action="<?php echo base_url('mutdat/admin')?>">
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
                  <option>Januari</option>
                  <option>Februari</option>
                  <option>Maret</option>
                  <option>April</option>
                  <option>Mei</option>
                  <option>Juni</option>
                  <option>Juli</option>
                  <option>Agustus</option>
                  <option>September</option>
                  <option>Oktober</option>
                  <option>November</option>
                  <option>Desember</option>
             

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
                  <option>2021</option>                  
                  <option>2022</option>                  
                
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
                      <th scope="col" rowspan="2" class="align-middle">NO</th>
                      <th scope="col" rowspan="2" class="align-middle">SATKER</th>
                      <th scope="col" rowspan="2" class="align-middle">BULAN</th>
                      <th scope="col" rowspan="2" class="align-middle">FILE</th>
                      <th scope="col" rowspan="2" class="align-middle">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php 
                        $no = 1;
                        foreach($mutdat as $m){ 
                    ?>
               		<tr>
                    	<th scope="row"><?php echo $no++ ?></th>
               			<td><?php echo $m->satker ?></td>
               			<td><?php echo $m->bulan ?></td>
               			<td><?php echo $m->file ?></td>
               			<td>
                        <a href="<?php echo base_url(); ?>mutdat/download/<?php echo $m->id; ?>" class="btn btn-success">Download</a>
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