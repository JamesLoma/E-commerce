<div class="login-box">
    <!-- /.login-logo -->
    <div class="authentication-wrapper authentication-cover">
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
                <div class="d-flex justify-content-center" style="max-width:65%; margin:0 auto;">
                    <img src="<?= base_url('assets/admin/img/backgrounds/Login_IMG.png') ?>" class="img-fluid" alt="Login image" width="700" data-app-dark-img="illustrations/boy-with-rocket-dark.png" data-app-light-img="illustrations/boy-with-rocket-light.png">
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->

            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4 login-background-color">

                <div class="w-px-400 mx-auto">
                    <?php if (ALLOW_MODIFICATION == 0) { ?>
                        <div class="alert alert-warning">
                            Note: If you cannot login here, please close the codecanyon frame by clicking on x Remove Frame button from top right corner on the page or <a href="<?= base_url('/admin') ?>" target="_blank" class="text-danger">>> Click here <<< /a>
                        </div>
                    <?php } ?>
                    <!-- Logo -->
                    <div class="login-logo">

                        <a href="<?= base_url() . 'delivery_boy/login' ?>"><img src="<?= base_url() . $logo ?>"></a>
                    </div>
                    <!-- /Logo -->

                    <h4>
                        <p class="login-box-msg">Sign in to start your session</p>
                    </h4>

                    <form action="<?= base_url('delivery_boy/login/auth') ?>" class='form-submit-event' method="post">
                        <input type='hidden' name='<?= $this->security->get_csrf_token_name() ?>' value='<?= $this->security->get_csrf_hash() ?>'>
                        <div class="input-group mb-3">
                            <input type="<?= $identity_column ?>" class="form-control" name="identity" placeholder="<?= ucfirst($identity_column)  ?>" <?= (ALLOW_MODIFICATION == 0) ? 'value="1234567890"' : ""; ?>>

                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" <?= (ALLOW_MODIFICATION == 0) ? 'value="12345678"' : ""; ?>>

                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" name="remember" id="remember">
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-12 mt-4">
                                <button type="submit" id="submit_btn" class="btn btn-primary btn-block col-md-12">Sign In</button>
                            </div>
                            <div class="mt-2 col-md-12 text-center">
                                <div class="form-group" id="error_box">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /Login -->
        </div>
    </div>
</div>
<!-- /.login-box -->