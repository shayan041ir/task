<?php $this->load->view('/templates/head.php'); ?>

<body class="main-body app sidebar-mini ltr">

    <!-- Loader -->
    <div id="global-loader">
        <img src="<?= base_url('assets/img/loaders/loader-4.svg') ?>" class="loader-img" alt="در حال بارگذاری">
    </div>
    <!-- /Loader -->
    <!-- صفحه -->
    <div class="page custom-index">

        <?php $this->load->view('/templates/main-header-app-alider.php'); ?>

        <!-- محتوای اصلی -->
        <div class="main-content app-content">

            <!-- ظرف اصلی -->
            <div class="main-container container-fluid">

                <!-- مسیر ناوبری -->
                <div class="breadcrumb-header justify-content-between">
                    <div>
                        <h4 class="content-title mb-2 mb-xl-0">داشبورد</h4>
                    </div>
                    <div class="d-flex my-auto">
                        <nav aria-label="مسیر">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">خانه</a></li>
                                <li class="breadcrumb-item active" aria-current="page">لیست کاربران</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- /مسیر ناوبری -->
                <!-- بدنه محتوای اصلی -->
                <div class="main-content-body">

                    <!-- شروع لیست کاربران -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="text-primary">لیست کاربران</h2>
                        <button class="btn btn-success" id="addUserBtn"><i class="fas fa-plus"></i> افزودن کاربر جدید</button>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <table id="usersTable" class="table table-striped table-hover table-bordered" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center" style="width: 10%;">شناسه</th>
                                        <th class="text-center" style="width: 25%;">نام</th>
                                        <th class="text-center" style="width: 30%;">ایمیل</th>
                                        <th class="text-center" style="width: 20%;">نقش</th>
                                        <th class="text-center" style="width: 15%;">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- مودال -->
                    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="userForm">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="userModalLabel"></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" id="userId">
                                        <div class="mb-3">
                                            <label for="userName" class="form-label">نام کاربر</label>
                                            <input type="text" class="form-control" name="name" id="userName" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="userEmail" class="form-label">ایمیل</label>
                                            <input type="email" class="form-control" name="email" id="userEmail" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="userRole" class="form-label">نقش</label>
                                            <select name="role" class="form-control" id="userRole">
                                                <option value="user">کاربر عادی</option>
                                                <option value="admin">مدیر</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="userPassword" class="form-label">رمز عبور (در صورت تغییر)</label>
                                            <input type="password" class="form-control" name="password" id="userPassword">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" id="saveUserBtn"></button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- فرم جداگانه برای ویرایش -->
                    <?php if(isset($mode) && $mode === 'edit' && isset($user)): ?>
                    <div class="card shadow-sm mt-4">
                        <div class="card-header bg-primary text-white">
                            <h3>ویرایش اطلاعات کاربر</h3>
                        </div>
                        <div class="card-body">
                            <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                            <?= form_open(site_url('admin/users/edit/' . $user->id), ['id' => 'editForm']); ?>
                            <div class="mb-3">
                                <label for="editName" class="form-label">نام</label>
                                <input class="form-control" type="text" name="name" id="editName" value="<?= set_value('name', $user->name); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">ایمیل</label>
                                <input class="form-control" type="email" name="email" id="editEmail" value="<?= set_value('email', $user->email); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="editRole" class="form-label">نقش</label>
                                <select name="role" class="form-control" id="editRole">
                                    <option value="user" <?= ($user->role === 'user') ? 'selected' : '' ?>>کاربر عادی</option>
                                    <option value="admin" <?= ($user->role === 'admin') ? 'selected' : '' ?>>مدیر</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editPassword" class="form-label">رمز عبور (در صورت تغییر)</label>
                                <input class="form-control" type="password" name="password" id="editPassword">
                            </div>
                            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                            <?= form_close(); ?>
                            <p class="mt-3"><a href="<?= site_url('admin/users'); ?>" class="btn btn-link">بازگشت به لیست</a></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <script>
                    $(document).ready(function(){
                        let table = $('#usersTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "<?= site_url('admin/users/list_json'); ?>",
                                type: 'GET',
                                error: function(xhr, status, error) {
                                    console.error('خطای AJAX DataTables:', xhr.responseText);
                                    alert('خطایی در بارگذاری داده‌ها رخ داده: ' + error);
                                }
                            },
                            columns: [
                                { data: 0 },
                                { data: 1 },
                                { data: 2 },
                                { data: 3 },
                                { data: 4, orderable: false, searchable: false }
                            ],
                            language: {
                                emptyTable: "هیچ کاربری یافت نشد",
                                info: "نمایش _START_ تا _END_ از _TOTAL_ کاربر",
                                infoEmpty: "نمایش 0 تا 0 از 0 کاربر",
                                infoFiltered: "(فیلتر شده از _MAX_ کاربر)",
                                lengthMenu: "نمایش _MENU_ کاربر",
                                loadingRecords: "در حال بارگذاری...",
                                processing: "در حال پردازش...",
                                search: "جستجو:",
                                zeroRecords: "هیچ نتیجه‌ای یافت نشد",
                                paginate: {
                                    first: "اولین",
                                    last: "آخرین",
                                    next: "بعدی",
                                    previous: "قبلی"
                                }
                            },
                            pageLength: 10,
                            responsive: true,
                            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                            order: [[0, 'desc']]
                        });

                        $('#addUserBtn').click(function(){
                            $('#userForm')[0].reset();
                            $('#userModalLabel').text('افزودن کاربر جدید');
                            $('#saveUserBtn').text('ایجاد کاربر');
                            $('#userId').val('');
                            $('#userModal').data('mode', 'create');
                            $('#userModal').modal('show');
                        });

                        $('#usersTable').on('click', '.btn-primary', function(e){
                            e.preventDefault();
                            let editUrl = $(this).attr('href');
                            console.log('آدرس ویرایش:', editUrl);
                            
                            $.ajax({
                                url: editUrl,
                                type: 'GET',
                                dataType: 'json',
                                success: function(res){
                                    console.log('پاسخ:', res);
                                    $('#userModalLabel').text('ویرایش اطلاعات کاربر');
                                    $('#saveUserBtn').text('ذخیره تغییرات');
                                    $('#userId').val(res.user.id);
                                    $('#userName').val(res.user.name);
                                    $('#userEmail').val(res.user.email);
                                    $('#userRole').val(res.user.role);
                                    $('#userPassword').val('');
                                    $('#userModal').data('mode', res.mode);
                                    $('#userModal').modal('show');
                                },
                                error: function(xhr, status, error) {
                                    console.error('خطا:', xhr.responseText);
                                    alert('خطایی در دریافت اطلاعات کاربر رخ داده: ' + error);
                                }
                            });
                        });

                        $('#userForm').submit(function(e){
                            e.preventDefault();
                            let id = $('#userId').val();
                            let mode = $('#userModal').data('mode');
                            let url = (mode === 'edit' && id) ? '<?= site_url("admin/users/edit/"); ?>' + id : '<?= site_url("admin/users/create"); ?>';
                            
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: $(this).serialize(),
                                dataType: 'json',
                                success: function(response) {
                                    if(response.status === 'success') {
                                        $('#userModal').modal('hide');
                                        table.ajax.reload(null, false);
                                        alert(response.message);
                                    } else {
                                        alert('خطا: ' + (response.message || 'خطای ناشناخته'));
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('خطای AJAX:', xhr.responseText);
                                    alert('خطایی در ارتباط با سرور رخ داده: ' + error);
                                }
                            });
                        });

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
                                        alert(response.message);
                                        window.location.href = '<?= site_url("admin/users"); ?>';
                                    } else {
                                        alert('خطا: ' + (response.message || 'خطای ناشناخته'));
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('خطای AJAX:', xhr.responseText);
                                    alert('خطایی در ارتباط با سرور رخ داده: ' + error);
                                }
                            });
                        });

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
                                        alert(response.message);
                                    } else {
                                        alert('خطا: ' + (response.message || 'خطای ناشناخته'));
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('خطای AJAX:', xhr.responseText);
                                    alert('خطایی در ارتباط با سرور رخ داده: ' + error);
                                }
                            });
                        });
                    });
                    </script>

                    <!-- پایان لیست کاربران -->

                </div>
                <!-- /ردیف -->

            </div>
            <!-- ظرف بسته شد -->
        </div>
        <!-- محتوای اصلی بسته شد -->

        <!-- فوتر -->
        <div class="main-footer ht-45 bg-dark text-white">
            <div class="container-fluid pd-t-0 ht-100p text-center">
                <span><a href="javascript:void(0);" class="text-white">ادمینِتو</a> - طراحی با عشق <span class="fa fa-heart text-danger"></span> توسط تیم برنامه‌نویسان ادمینِتو</span>
            </div>
        </div>
        <!-- پایان فوتر -->

    </div>
    <!-- پایان صفحه -->
<?php $this->load->view('/templates/footer.php'); ?>