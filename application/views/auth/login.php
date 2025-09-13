<div class="card p-4">
  <h3>ورود</h3>
  <?= validation_errors('<div class="alert alert-danger">','</div>'); ?>
  <?= form_open('login'); ?>
    <div class="mb-2"><input class="form-control" type="email" name="email" placeholder="ایمیل" value="<?= set_value('email'); ?>"></div>
    <div class="mb-2"><input class="form-control" type="password" name="password" placeholder="رمز"></div>
    <button class="btn btn-primary">ورود</button>
  <?= form_close(); ?>
  <p class="mt-2"><a href="<?= site_url('register');?>">ثبت نام</a></p>
</div>




<!-- <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
       value="<?= $this->security->get_csrf_hash(); ?>" /> -->

