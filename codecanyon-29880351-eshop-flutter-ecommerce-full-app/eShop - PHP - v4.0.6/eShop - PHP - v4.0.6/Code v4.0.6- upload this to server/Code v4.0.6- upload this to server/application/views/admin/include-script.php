<!-- Helpers -->
<!-- C:\xampp\htdocs\eshop-sneat\assets\admin\vendor\js -->
<script src="<?= base_url('assets/admin/vendor/js/helpers.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/config.js') ?>"></script>

<script src="<?= base_url('assets/admin/vendor/libs/popper/popper.js') ?>"></script>

<script src="<?= base_url('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendor/js/menu.js') ?>"></script>
<script src="<?= base_url('assets/admin/js/main.js') ?>"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>



<!-- Old admin template JS -->
<script src="<?= base_url('assets/admin_old/js/bootstrap.bundle.min.js') ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('assets/admin_old/jquery-ui/jquery-ui.min.js') ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Ekko Lightbox -->
<script src=<?= base_url('assets/admin_old/ekko-lightbox/ekko-lightbox.min.js') ?>></script>

<!-- google translate library -->
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!-- ChartJS -->
<script src="<?= base_url('assets/admin_old/chart.js/Chart.min.js') ?>"></script>
<!-- Sparkline -->
<script src="<?= base_url('assets/admin_old/js/sparkline.js') ?>"></script>
<!-- JQVMap -->
<script src="<?= base_url('assets/admin_old/js/jquery.vmap.min.js') ?>"></script>
<script src="<?= base_url('assets/admin_old/js/jquery.vmap.usa.js') ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url('assets/admin_old/js/jquery.knob.min.js') ?>"></script>
<!-- daterangepicker -->
<script src="<?= base_url('assets/admin_old/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/admin_old/js/daterangepicker.js') ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url('assets/admin_old/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<!-- Toastr -->
<script src="<?= base_url('assets/admin_old/js/iziToast.min.js') ?>"></script>
<!-- Select -->
<script src="<?= base_url('assets/admin_old/js/select2.full.min.js') ?>"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url('assets/admin_old/js/jquery.overlayScrollbars.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/admin_old/dist/js/adminlte.js') ?>"></script>
<!-- Bootstrap Switch -->
<script src="<?= base_url('assets/admin_old/js/bootstrap-switch.min.js') ?>"></script>
<!-- Bootstrap Table -->
<script src="<?= base_url('assets/admin_old/js/bootstrap-table.min.js') ?>"></script>
<script src="<?= base_url('assets/admin_old/js/tableExport.js') ?>"></script>
<script src="<?= base_url('assets/admin_old/js//bootstrap-table-export.min.js"') ?>"></script>
<!-- Jquery Fancybox -->
<script src="<?= base_url('assets/admin_old/js/jquery.fancybox.min.js') ?>"></script>
<!-- Sweeta Alert 2 -->
<script src="<?= base_url('assets/admin_old/js/sweetalert2.min.js') ?>"></script>
<!-- Block UI -->
<script src="<?= base_url('assets/admin_old/js/jquery.blockUI.js') ?>"></script>
<!-- JS tree -->
<script src="<?= base_url('assets/admin_old/js/jstree.min.js') ?>"></script>
<!-- Chartist -->
<script src="<?= base_url('assets/admin_old/js/chartist.js') ?>"></script>
<!-- Tool Tip -->
<script src="<?= base_url('assets/admin_old/js/tooltip.js') ?>"></script>
<!-- Loader Js -->
<script type="text/javascript" src="<?= base_url('assets/admin_old/js/loader.js') ?>"></script>
<!-- Dropzone -->
<script type="text/javascript" src="<?= base_url('assets/admin_old/js/dropzone.js') ?>"></script>

<script type="text/javascript" src="<?= base_url('assets/admin_old/js/tagify.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin_old/js/jquery.validate.min.js') ?>"></script>

<!-- Sortable.JS -->
<script type="text/javascript" src="<?= base_url('assets/admin_old/js/sortable.js') ?>"></script>
<!-- Sortable.min.js -->
<script type="text/javascript" src="<?= base_url('assets/admin_old/js/jquery-sortable.js') ?>"></script>

<!-- Custom -->
<script src="<?= base_url('assets/admin_old/custom/custom.js') ?>"></script>
<!-- POS js -->
<script src="<?= base_url('assets/admin_old/custom/pos.js') ?>"></script>
<!-- Demo -->
<script src="<?= base_url('assets/admin_old/dist/js/demo.js') ?>"></script>

<?php if ($this->session->flashdata('message')) { ?>
    <script>
        Swal.fire('<?= $this->session->flashdata('message_type') ?>', "<?= $this->session->flashdata('message') ?>", '<?= $this->session->flashdata('message_type') ?>');
    </script>
<?php } ?>

<?php if ($this->session->flashdata('authorize_flag')) { ?>
    <script>
        Swal.fire('Warning', "<?= $this->session->flashdata('authorize_flag') ?>", 'warning');
    </script>
<?php }
$this->session->set_flashdata('authorize_flag', "");
?>