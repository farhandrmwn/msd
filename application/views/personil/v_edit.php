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
            <?php foreach($personil as $p){ ?>
            <?php echo form_open_multipart('Personil/update') ?>
            <div class="form-row">
                <input type="hidden" class="form-control" name="id_pyb" value="<?php echo $p->id_pyb ?>">
                <div class="form-group col-md-6">
                    <label>NAMA:</label>
                    <input type="text" class="form-control" name="nama" value="<?php echo $p->nama ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>PANGKAT:</label>
                    <input type="text" class="form-control" name="pangkat" value="<?php echo $p->pangkat ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>NRP :</label>
                    <input type="text" class="form-control" name="nrp" value="<?php echo $p->nrp ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>JENIS KASUS:</label>
                    <input type="text" class="form-control" name="jenis_kasus" value="<?php echo $p->jenis_kasus ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>PROSES S/D HARI INI:</label>
                    <input type="text" class="form-control" name="proses" value="<?php echo $p->proses ?>">
                </div>
            </div>
            <div class="card text-center card-header card text-white bg-secondary">PROSES SIDANG ( TMT INKRACHT )</div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>PIDANA UMUM:</label>
                    <input type="text" class="form-control" name="pidum_ps" value="<?php echo $p->pidum_ps ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>ETIK / PROFESI:</label>
                    <input type="text" class="form-control" name="etikprofesi_ps" value="<?php echo $p->etikprofesi_ps ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>DISIPLIN:</label>
                    <input type="text" class="form-control" name="disiplin_ps" value="<?php echo $p->disiplin_ps ?>">
                </div>
            </div>
            <div class="card text-center card-header card text-white bg-secondary">LAMA PUTUSAN</div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>PIDANA UMUM:</label>
                    <input type="text" class="form-control" name="pidum_lp" value="<?php echo $p->pidum_lp ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>ETIK / PROFESI:</label>
                    <input type="text" class="form-control" name="etikprofesi_lp" value="<?php echo $p->etikprofesi_lp ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>DISIPLIN:</label>
                    <input type="text" class="form-control" name="disiplin_lp" value="<?php echo $p->disiplin_lp ?>">
                </div>
            </div>
            <div class="card text-center card-header card text-white bg-secondary">TEMPAT MENJALIN HUKUMAN</div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>PIDANA UMUM:</label>
                    <input type="text" class="form-control" name="pidum_tmh" value="<?php echo $p->pidum_tmh ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>ETIK / PROFESI:</label>
                    <input type="text" class="form-control" name="etikprofesi_tmh" value="<?php echo $p->etikprofesi_tmh ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>DISIPLIN:</label>
                    <input type="text" class="form-control" name="disiplin_tmh" value="<?php echo $p->disiplin_tmh ?>">
                </div>
            </div>
            <div class="card text-center card-header card text-white bg-secondary">PEMBAYARAN PENGHASILAN</div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>PENGHENTIAN SEMENTARA GAJI ( TMT ):</label>
                    <input type="text" class="form-control" name="penghentian_smntr" value="<?php echo $p->penghentian_smntr ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>PEMBAYARAN GAJI 75% ( TMT ):</label>
                    <input type="text" class="form-control" name="byr_gj_tjhlima" value="<?php echo $p->byr_gj_tjhlima ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>PENGHENTIAN TUNKUN ( TMT ):</label>
                    <input type="text" class="form-control" name="penghentian_tunkun" value="<?php echo $p->penghentian_tunkun ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>TPTGR:</label>
                    <input type="text" class="form-control" name="tptgr" value="<?php echo $p->tptgr ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>KETERANGAN:</label>
                    <input type="text" class="form-control" name="keterangan" value="<?php echo $p->keterangan ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>WAKTU:</label>
                    <input type="text" class="form-control" name="bulan" value="<?php echo $p->bulan ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>FILE :</label><br>
                    <input type="file" name="berkas" lang="en">
                </div>
            </div>
            <div class="form-group">
                <input type="submit"  class="btn btn-primary" value="Simpan">
            </div>
            <?php echo form_close(); ?>
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