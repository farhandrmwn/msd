


<?php $this->load->view('partials/header') ?>

    <?php if ($this->session->userdata('level') == 'admin'): ?>
        <?php $this->load->view('dashboard/dashboard_admin') ?>
    <?php endif ?>    

    <?php if ($this->session->userdata('level') == 'satker'): ?>
        <?php $this->load->view('dashboard/dashboard_satker') ?>
    <?php endif ?>    
      <!-- Footer -->
<?php $this->load->view('partials/footer') ?>