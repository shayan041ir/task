<?php $this->load->view('/templates/head.php'); ?>

<body class="app sidebar-mini ltr login-img">

  <!-- Loader -->
  <div id="global-loader">
    <img src="assets/img/loaders/loader-4.svg" class="loader-img" alt="Loader">
  </div>
  <!-- /Loader -->

  <div class="square-box">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>

  <!-- page -->
  <div class="page login-img">


    <!-- main-signin-wrapper -->
    <div class="">
      <div class="my-auto page page-h">
        <div class="main-signin-wrapper">
          <div class="col-xl-3 col-lg-4 col-md-5 col-sm-8">
            <div class="text-center mb-3"> <img src="assets/img/brand/logo-white.png" class="h-8" alt=""> </div>
            <div class="card">
              <div class="card-body p-5">
                <div class="main-signin-header">
                  <h2>خوش برگشتی!</h2>
                  <h4>لطفا برای ادامه وارد شوید</h4>

                  <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                  <?= form_open('login'); ?>
                  <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="ایمیل خود را وارد کنید"
                      value="<?= set_value('email'); ?>">
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="رمز عبور خود را وارد کنید">
                  </div>
                  <button class="btn btn-primary btn-block">ورود</button>
                  <?= form_close(); ?>


                </div>
                <div class="main-signin-footer mt-3 mg-t-5">
                  <p class="btn btn-block"><a href="<?= site_url('register'); ?>">ثبت نام</a></p>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>


  </div>
  <!-- End Page -->

<?php $this->load->view('/templates/footer.php'); ?>
