    <div class="card p-4">
  <h3>ثبت نام</h3>
  <?= validation_errors('<div class="alert alert-danger">','</div>'); ?>
  <?= form_open('register'); ?>
  <!-- <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
       value="<?= $this->security->get_csrf_hash(); ?>" /> -->
    <div class="mb-2">
      <input class="form-control" type="text" name="name" placeholder="نام" value="<?= set_value('name'); ?>">
    </div>
    <div class="mb-2">
      <input class="form-control" type="email" name="email" placeholder="ایمیل" value="<?= set_value('email'); ?>">
    </div>
    <div class="mb-2">
      <input class="form-control" type="password" name="password" placeholder="رمز عبور">
    </div>
    <div class="mb-2">
      <input class="form-control" type="password" name="passconf" placeholder="تکرار رمز">
    </div>
    <div class="mb-2">
    <select class="form-control" name="role">
        <option value="user" <?= set_select('role','user', true) ?>>کاربر معمولی</option>
        <option value="admin" <?= set_select('role','admin') ?>>ادمین</option>
    </select>
</div>

    <button class="btn btn-primary">ثبت نام</button>
  <?= form_close(); ?>
  <p class="mt-2"><a href="<?= site_url('login');?>">ورود</a></p>
</div>
