<?php $this->load->view('admin/header'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>کاربران</h2>
  <button class="btn btn-success" id="addUserBtn">➕ افزودن کاربر</button>
</div>

<table id="usersTable" class="display table table-striped" style="width:100%">
  <thead>
    <tr>
      <th>ID</th><th>نام</th><th>ایمیل</th><th>نقش</th><th>عملیات</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="userForm">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="userId">
          <div class="mb-2">
            <label>نام</label>
            <input type="text" class="form-control" name="name" id="userName" required>
          </div>
          <div class="mb-2">
            <label>ایمیل</label>
            <input type="email" class="form-control" name="email" id="userEmail" required>
          </div>
          <div class="mb-2">
            <label>نقش</label>
            <select name="role" class="form-control" id="userRole">
              <option value="user">کاربر</option>
              <option value="admin">ادمین</option>
            </select>
          </div>
          <div class="mb-2">
            <label>رمز عبور (در صورت تغییر)</label>
            <input type="password" class="form-control" name="password" id="userPassword">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="saveUserBtn"></button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- فرم جداگانه برای ویرایش (اگر از کنترلر mode دریافت شود) -->
<?php if(isset($mode) && $mode === 'edit' && isset($user)): ?>
<div class="card p-4 mt-4">
  <h3>ویرایش کاربر</h3>
  <?= validation_errors('<div class="alert alert-danger">','</div>'); ?>
  
  <?= form_open(site_url('admin/users/edit/'.$user->id), ['id'=>'editForm']); ?>
    <div class="mb-2">
      <label>نام</label>
      <input class="form-control" type="text" name="name" value="<?= set_value('name', $user->name); ?>">
    </div>
    
    <div class="mb-2">
      <label>ایمیل</label>
      <input class="form-control" type="email" name="email" value="<?= set_value('email', $user->email); ?>">
    </div>
    
    <div class="mb-2">
      <label>نقش</label>
      <select name="role" class="form-control">
        <option value="user" <?= ($user->role === 'user') ? 'selected' : '' ?>>کاربر</option>
        <option value="admin" <?= ($user->role === 'admin') ? 'selected' : '' ?>>ادمین</option>
      </select>
    </div>
    
    <div class="mb-2">
      <label>رمز عبور (در صورت تغییر)</label>
      <input class="form-control" type="password" name="password">
    </div>
    
    <button type="submit" class="btn btn-primary">بروزرسانی</button>
  <?= form_close(); ?>
  <p class="mt-2"><a href="<?= site_url('admin/users');?>">بازگشت به لیست</a></p>
</div>
<?php endif; ?>

<script>
$(document).ready(function(){
  let table = $('#usersTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "<?= site_url('admin/users/list_json');?>",
    columns: [
      { data: 0 },
      { data: 1 },
      { data: 2 },
      { data: 3 },
      { data: 4, orderable: false, searchable: false }
    ]
  });

  // دکمه افزودن کاربر
  $('#addUserBtn').click(function(){
    $('#userForm')[0].reset();
    $('#userModalLabel').text('افزودن کاربر');
    $('#saveUserBtn').text('ایجاد');
    $('#userId').val('');
    $('#userModal').data('mode', 'create');
    $('#userModal').modal('show');
  });

  // دکمه ویرایش در جدول
  $('#usersTable').on('click', '.btn-primary', function(e){
    e.preventDefault();
    let editUrl = $(this).attr('href');
    console.log('Edit URL:', editUrl);
    
    $.ajax({
      url: editUrl,
      type: 'GET',
      dataType: 'json',
      success: function(res){
        console.log('Response:', res);
        $('#userModalLabel').text('ویرایش کاربر');
        $('#saveUserBtn').text('بروزرسانی');
        $('#userId').val(res.user.id);
        $('#userName').val(res.user.name);
        $('#userEmail').val(res.user.email);
        $('#userRole').val(res.user.role);
        $('#userPassword').val('');
        $('#userModal').data('mode', res.mode);
        $('#userModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error('Error:', xhr.responseText);
        console.error('Status:', status);
        console.error('Error:', error);
        alert('خطا در دریافت اطلاعات کاربر: ' + error + '\nStatus: ' + status);
      }
    });
  });

  // ارسال فرم مودال
  $('#userForm').submit(function(e){
    e.preventDefault();
    let id = $('#userId').val();
    let mode = $('#userModal').data('mode');
    let url = (mode === 'edit' && id) ? '<?= site_url("admin/users/edit/");?>'+id : '<?= site_url("admin/users/create");?>';
    
    $.ajax({
      url: url,
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response) {
        if(response.status === 'success') {
          $('#userModal').modal('hide');
          table.ajax.reload(null, false);
          alert('عملیات با موفقیت انجام شد');
        } else {
          alert('خطا در انجام عملیات: ' + (response.message || 'خطای نامشخص'));
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error:', xhr.responseText);
        alert('خطا در ارتباط با سرور: ' + error);
      }
    });
  });

  // ارسال فرم جداگانه (اگر از کنترلر mode دریافت شود)
  $('#editForm').submit(function(e){
    e.preventDefault();
    let form = $(this);
    
    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      data: form.serialize(),
      dataType: 'json',
      success: function(response) {
        if(response.status === 'success') {
          alert('کاربر با موفقیت به‌روزرسانی شد');
          window.location.href = '<?= site_url("admin/users"); ?>';
        } else {
          alert('خطا در به‌روزرسانی: ' + (response.message || 'خطای نامشخص'));
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error:', xhr.responseText);
        alert('خطا در ارتباط با سرور: ' + error);
      }
    });
  });

  // دکمه حذف
  $('#usersTable').on('click', '.btn-danger', function(e){
    e.preventDefault();
    if(!confirm('آیا مطمئن هستید که می‌خواهید این کاربر را حذف کنید؟')) return;
    
    $.ajax({
      url: $(this).attr('href'),
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if(response.status === 'success') {
          table.ajax.reload(null, false);
          alert('کاربر با موفقیت حذف شد');
        } else {
          alert('خطا در حذف کاربر: ' + (response.message || 'خطای نامشخص'));
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error:', xhr.responseText);
        alert('خطا در ارتباط با سرور: ' + error);
      }
    });
  });
});
</script>

<?php $this->load->view('admin/footer'); ?>