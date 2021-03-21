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
      <h1 class="mb-0"> RUMAH DINAS</h1>
        </div>
        <?php if ($this->session->userdata('level') == 'admin'): ?>
        <div class="card-body text-center mb--5">
           <a href="<?php echo base_url()?>tampil/personilpolri" role="button"> <img class="rounded-circle" alt="150x150" src="<?php echo base_url('Assets/img/brand/personilpolri.png') ?>" width = "220px" data-holder-rendered="true">
         </a>
          <a href="<?php echo base_url()?>tampil/rdpolri" role="button"> <img class="rounded-circle" alt="150x150" src="<?php echo base_url('Assets/img/brand/rdpolri.png') ?>" width = "220px" data-holder-rendered="true">
         </a>
          <a href="<?php echo base_url()?>tampil/personilpns" role="button"> <img class="rounded-circle" alt="150x150" src="<?php echo base_url('Assets/img/brand/personilpns.png') ?>" width = "220px" data-holder-rendered="true">
         </a>
          <a href="<?php echo base_url()?>tampil/rdpnspolri" role="button"> <img class="rounded-circle" alt="150x150" src="<?php echo base_url('Assets/img/brand/rdpns.png') ?>" width = "220px" data-holder-rendered="true">
         </a>
          
              <div class="mb-3"> </div>
            <hr class="mt--1">  
        </div>
      <?php endif ?>
        <?php if ($this->session->userdata('level') == 'satker'): ?>
        <div class="card-body text-center mb--5">
           <a href="<?php echo base_url()?>/PersonilPolri/pilih" role="button"> <img class="rounded-circle" alt="150x150" src="<?php echo base_url('Assets/img/brand/personilpolri.png') ?>" width = "220px" data-holder-rendered="true">
         </a>
          <a href="<?php echo base_url()?>/RD_polri/pilihan" role="button"> <img class="rounded-circle" alt="150x150" src="<?php echo base_url('Assets/img/brand/rdpolri.png') ?>" width = "220px" data-holder-rendered="true">
         </a>
          <a href="<?php echo base_url()?>/PersonilPns/pilih" role="button"> <img class="rounded-circle" alt="150x150" src="<?php echo base_url('Assets/img/brand/personilpns.png') ?>" width = "220px" data-holder-rendered="true">
         </a>
          <a href="<?php echo base_url()?>/RD_pns_polri/pilih" role="button"> <img class="rounded-circle" alt="150x150" src="<?php echo base_url('Assets/img/brand/rdpns.png') ?>" width = "220px" data-holder-rendered="true">
         </a>
          
              <div class="mb-3"> </div>
            <hr class="mt--1">  
        </div>
      <?php endif ?>
