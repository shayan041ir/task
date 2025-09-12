<div class="card p-4">
  <h3>پروفایل</h3>
  <p>نام: <?= html_escape($user->name); ?></p>
  <p>ایمیل: <?= html_escape($user->email); ?></p>
  <p>نقش: <?= html_escape($user->role); ?></p>
  <a href="<?= site_url('logout');?>" class="btn btn-secondary">خروج</a>
</div>
