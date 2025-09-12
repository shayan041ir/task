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

  $('#addUserBtn').click(function(){
    $('#userForm')[0].reset();
    $('#userModalLabel').text('افزودن کاربر');
    $('#saveUserBtn').text('ایجاد');
    $('#userId').val('');
    $('#userModal').modal('show');
  });

  $('#usersTable').on('click', '.btn-primary', function(e){
    e.preventDefault();
    $.get($(this).attr('href'), function(res){
      $('#userModalLabel').text('ویرایش کاربر');
      $('#saveUserBtn').text('بروزرسانی');
      $('#userId').val(res.id);
      $('#userName').val(res.name);
      $('#userEmail').val(res.email);
      $('#userRole').val(res.role);
      $('#userPassword').val('');
      $('#userModal').modal('show');
    });
  });

  $('#userForm').submit(function(e){
    e.preventDefault();
    let id = $('#userId').val();
    let url = id ? '<?= site_url("admin/users/edit/");?>'+id : '<?= site_url("admin/users/create");?>';
    $.post(url, $(this).serialize(), function(){
      $('#userModal').modal('hide');
      table.ajax.reload(null, false);
    });
  });

  $('#usersTable').on('click', '.btn-danger', function(e){
    e.preventDefault();
    if(!confirm('آیا مطمئن هستید؟')) return;
    $.get($(this).attr('href'), function(){
      table.ajax.reload(null, false);
    });
  });
});
</script>

<?php $this->load->view('admin/footer'); ?>
