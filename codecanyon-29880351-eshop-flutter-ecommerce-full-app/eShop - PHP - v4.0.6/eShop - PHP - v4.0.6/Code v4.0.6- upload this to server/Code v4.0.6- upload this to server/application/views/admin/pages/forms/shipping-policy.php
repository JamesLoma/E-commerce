<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h4>Shipping Policy</h4>
                </div>
                <div class="col-sm-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Shipping policy</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <!-- form start -->
                        <form class="form-horizontal form-submit-event" action="<?= base_url('admin/privacy_policy/update_shipping_policy_settings'); ?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body pad">
                                <label for="other_images"> Shipping Policy </label>
                                <a href="<?= base_url('admin/privacy-policy/shipping-policy-page') ?>" target='_blank' class="btn btn-primary btn-xs" title='View Shipping Policy'><i class='fa fa-eye'></i></a>
                                <div class="mb-3 mt-3">
                                    <textarea name="shipping_policy_input_description" class="textarea addr_editor" placeholder="Place some text here">  <?= output_escaping(str_replace('\r\n', '&#13;&#10;', $shipping_policy)) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button type="submit" class="btn btn-success" id="submit_btn">Shipping Policy</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="form-group" id="error_box">
                        </div>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!--/.card-->
            </div>
            <!--/.col-md-12-->
        </div>

    </section>
    <!-- /.content -->
</div>