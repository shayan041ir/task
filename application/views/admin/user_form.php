<div class="card p-4">
  <h3><?= ($mode === 'edit') ? 'ویرایش کاربر' : 'افزودن کاربر'; ?></h3>
  <?= validation_errors('<div class="alert alert-danger">','</div>'); ?>

  <?php
    $action = ($mode === 'edit') ? site_url('admin/users/edit/'.$user->id) : site_url('admin/users/create');
  ?>
  <?= form_open($action, ['id'=>'userForm']); ?>

    <div class="mb-2">
      <label>نام</label>
      <input class="form-control" type="text" name="name" value="<?= set_value('name', isset($user) ? $user->name : ''); ?>">
    </div>

    <div class="mb-2">
      <label>ایمیل</label>
      <input class="form-control" type="email" name="email" value="<?= set_value('email', isset($user) ? $user->email : ''); ?>">
    </div>

    <div class="mb-2">
      <label>نقش</label>
      <select name="role" class="form-control">
        <option value="user" <?= (isset($user) && $user->role==='user') ? 'selected' : '' ?>>کاربر</option>
        <option value="admin" <?= (isset($user) && $user->role==='admin') ? 'selected' : '' ?>>ادمین</option>
      </select>
    </div>

    <div class="mb-2">
      <label>رمز عبور (در صورت تغییر)</label>
      <input class="form-control" type="password" name="password">
    </div>

    <button class="btn btn-primary"><?= ($mode === 'edit') ? 'بروزرسانی' : 'ایجاد' ?></button>
  <?= form_close(); ?>
  <p class="mt-2"><a href="<?= site_url('admin/users');?>">بازگشت</a></p>
</div>

<script>
    $('#userForm').submit(function(e){
    e.preventDefault(); // جلوگیری از رفرش صفحه
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(), // این شامل CSRF token هم هست
        dataType: 'json',
        success: function(resp){
            if(resp.status === 'success'){
                $('#userModal').modal('hide');
                $('#usersTable').DataTable().ajax.reload(); // بروزرسانی جدول بدون رفرش
            } else {
                alert('خطا در عملیات');
            }
        }
    });
});

</script>
