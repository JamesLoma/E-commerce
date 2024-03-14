<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="<?= base_url('assets/admin/vendor/fonts/boxicons.css') ?>" />

<link rel="stylesheet" href="<?= base_url('assets/admin/vendor/css/core.css" class="template-customizer-core-css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/admin/vendor/css/theme-default.css" class="template-customizer-theme-css') ?>" />


<link rel="stylesheet" href="<?= base_url('assets/admin/css/demo.css') ?>" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="<?= base_url('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />


<link rel="stylesheet" href="<?= base_url('assets/admin/vendor/css/pages/page-auth.css') ?>" />
<!-- Old admin template -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= base_url() . get_settings('favicon') ?>" type="image/gif" sizes="16x16">
    <!-- Bootstrap Switch -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/bootstrap-switch.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/all.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/ionicons.min.css') ?>">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/tempusdominus-bootstrap-4.min.css') ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/icheck-bootstrap.min.css') ?>">
    <!-- Dropzone -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/dropzone.css') ?>">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/jqvmap.min.css') ?>">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/ekko-lightbox/ekko-lightbox.css') ?>">
    <!-- Theme style
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/dist/css/adminlte.min.css') ?>"> -->
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/OverlayScrollbars.min.css') ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/daterangepicker.css') ?>">
    <!-- tinymce -->
    <script src="<?= base_url('assets/admin_old/js/tinymce.min.js') ?>"></script>
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/iziToast.min.css') ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/select2-bootstrap4.min.css') ?>">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/sweetalert2.min.css') ?>">
    <!-- Chartist -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/chartist.css') ?>">

    <!-- ion-icon -->
    <script nomodule src="<?= base_url('assets/admin_old/ionicons/dist/ionicons/ionicons.js') ?>"></script>
    <script type="module" src="<?= base_url('assets/admin_old/ionicons/dist/ionicons/ionicons.esm.js') ?>"></script>

    <!-- JS tree -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/style.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/star-rating.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/theme.css') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/fonts.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/bootstrap-table.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/jquery.fancybox.min.css') ?>" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/custom/custom.css') ?>">
    <!-- jQuery -->
    <script src="<?= base_url('assets/admin_old/js/jquery.min.js') ?>"></script>
    <!-- Star rating js -->
    <script type="text/javascript" src="<?= base_url('assets/admin_old/js/star-rating.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/admin_old/js/theme.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/admin_old/css/tagify.min.css') ?>">
    <script type="text/javascript">
        base_url = "<?= base_url() ?>";
        csrfName = "<?= $this->security->get_csrf_token_name() ?>";
        csrfHash = "<?= $this->security->get_csrf_hash() ?>";
        form_name = '<?= '#' . $main_page . '_form' ?>';
    </script>

</head>