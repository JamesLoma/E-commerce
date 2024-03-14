<div class="content-wrapper">
    <section class="content-header mt-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h4>Return Policy</h4>
                </div>
                <div class="col-sm-4 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Return Policy</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <!-- form start -->
                        <form class="form-horizontal form-submit-event" action="<?= base_url('admin/privacy_policy/update_return_policy_settings'); ?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body pad">
                                <label for="other_images"> Return Policy </label>
                                <a href="<?= base_url('admin/privacy-policy/return-policy-page') ?>" target='_blank' class="btn btn-primary btn-xs" title='View return Policy'><i class='fa fa-eye'></i></a>
                                <div class="mb-3">
                                    <textarea name="return_policy_input_description" class="textarea addr_editor" placeholder="Place some text here">  <?= output_escaping(str_replace('\r\n', '&#13;&#10;', $return_policy)) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button type="submit" class="btn btn-success" id="submit_btn">Return Policy</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="form-group" id="error_box">
                        </div>
                    </div>
                </div>
            </div>
            <!--/.card-->
        </div>
    </section>
    <!-- /.content -->
</div>