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
      <h1 class="mb-0">PERSONIL BERMASALAH</h1>
        </div>

        <div class="card-body">
            <a href="<?php echo base_url()?>/personil/tambah" class="btn btn-primary" role="button">Tambah Data</a>
            <a href="<?php echo base_url('personil/excel'); ?>" class='btn btn-success'>Export Data</a>
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered text-center mt-4">
                  <thead>
                    <tr>
                      <th scope="col" rowspan="2" class="align-middle">NO</th>
                      <th scope="col" rowspan="2" class="align-middle">NAMA</th>
                      <th scope="col" rowspan="2" class="align-middle">PANGKAT/NRP</th>
                      <th scope="col" rowspan="2" class="align-middle">JENIS KASUS</th>
                      <th scope="col" rowspan="2" class="align-middle">PROSES S/D HARI INI</th>
                      <th scope="col" colspan="3">PROSES SIDANG (TMT INKRACHT)</th>
                      <th scope="col" colspan="3">LAMA PUTUSAN</th>
                      <th scope="col" colspan="3">TEMPAT MENJALIN HUKUMAN</th>
                      <th scope="col" colspan="3">PEMBAYARAN PENGHASILAN</th>
                      <th scope="col" rowspan="2" class="align-middle">TPTGR</th>
                      <th scope="col" rowspan="2" class="align-middle">FILES</th>
                      <th scope="col" rowspan="2" class="align-middle">KETERANGAN</th>
                      <th scope="col" rowspan="2" class="align-middle">WAKTU</th>
                      <th scope="col" rowspan="2" class="align-middle">ACTION</th>
                    </tr>
                    <tr>
                        <th scope="col">PIDANA UMUM</th>
                        <th scope="col">ETIK / PROFESI</th>
                        <th scope="col">DISIPLIN</th>
                        <th scope="col">PIDANA UMUM</th>
                        <th scope="col">ETIK / PROFESI</th>
                        <th scope="col">DISIPLIN</th>
                        <th scope="col">PIDANA UMUM</th>
                        <th scope="col">ETIK / PROFESI</th>
                        <th scope="col">DISIPLIN</th>
                        <th scope="col">PENGHENTIAN SEMENTARA GAJI ( TMT )</th>
                        <th scope="col">PEMBAYARAN GAJI 75% ( TMT )</th>
                        <th scope="col">PENGHENTIAN TUNKUN ( TMT )</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $no = 1;
                        foreach($personil as $p){ 
                    ?>
                    <tr>
                      <th scope="row"><?php echo $no++ ?></th>
                      <td><?php echo $p->nama ?></td>
                      <td><?php echo $p->pangkat." / ".$p->nrp ?></td>
                      <td><?php echo $p->jenis_kasus ?></td>
                      <td><?php echo $p->proses ?></td>
                      <td><?php echo $p->pidum_ps ?></td>
                      <td><?php echo $p->etikprofesi_ps ?></td>
                      <td><?php echo $p->disiplin_ps ?></td>
                      <td><?php echo $p->pidum_lp ?></td>
                      <td><?php echo $p->etikprofesi_lp ?></td>
                      <td><?php echo $p->disiplin_lp ?></td>
                      <td><?php echo $p->pidum_tmh ?></td>
                      <td><?php echo $p->etikprofesi_tmh ?></td>
                      <td><?php echo $p->disiplin_tmh ?></td>
                      <td><?php echo $p->penghentian_smntr ?></td>
                      <td><?php echo $p->byr_gj_tjhlima ?></td>
                      <td><?php echo $p->penghentian_tunkun ?></td>
                      <td><?php echo $p->tptgr ?></td>
                      <td><?php echo $p->file ?></td>
                      <td><?php echo $p->keterangan ?></td>
                      <td><?php echo $p->bulan ?></td>
                      <td>
                        <a href="<?= base_url('personil/edit/'.$p->id_pyb) ?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a href="<?= base_url('personil/hapus/'.$p->id_pyb) ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Remove</a>
                        <a href="<?php echo base_url(); ?>personil/download/<?php echo $p->id_pyb; ?>" class="btn btn-success">Download</a>
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