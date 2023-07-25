<?php include './views/admin_page/layout_header.php'; ?>
<?php include './views/admin_page/layout_nav.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="/admin/users"><i class="fas fa-chevron-left"></i>&nbsp;Back</a>
            <br>
            <h1>Edit User</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- form start -->
              <form id="formAddUser" method="POST" action="/admin/user/edit">
                <div class="card-body">
                  <input type="hidden" name="id" value="<?=$user['id']?>">
                  <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Enter full name" value="<?=$user['fullname']?>" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="<?=$user['email']?>" <?= !in_array($this->user['role'], ['Owner', 'Super Admin']) ? 'readonly' : '' ?> required>
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="re-password">Confirm Password</label>
                    <input type="password" class="form-control" name="re-password" id="re-password" placeholder="Confirm Password" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="cabang">Cabang</label>
                    <input type="text" class="form-control" name="cabang" id="cabang" placeholder="Enter cabang" value="<?=$user['cabang']?>" <?= !in_array($this->user['role'], ['Owner', 'Super Admin']) ? 'readonly' : '' ?> required>
                  </div>
                  <div class="form-group">
                    <label for="cabang">Company</label>
                    <input type="text" class="form-control" name="company" id="company" placeholder="Enter company" value="<?=$user['company']?>" <?= !in_array($this->user['role'], ['Owner']) ? 'readonly' : '' ?> required>
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" name="alamat" id="alamat" placeholder="Enter alamat" required><?=$user['alamat']?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" name="role" value="<?=$user['role']?>" <?= !in_array($this->user['role'], ['Super Admin']) ? 'readonly' : '' ?> <?= $this->user['role'] != 'Owner' ? 'required' : '' ?> >
                      <option value="Super Admin" <?=$user['role'] == 'Super Admin' ? 'selected' : ''?> >Super Admin</option>
                      <option value="Admin" <?=$user['role'] == 'Admin' ? 'selected' : ''?> >Admin</option>
                      <option value="User" <?=$user['role'] == 'User' ? 'selected' : ''?> >User</option>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- Page specific script -->
<script>
  $(function () {
    $('#formAddUser').on('submit', function(event) {
      let password = $('#password').val();
      let rePassword = $('#re-password').val();
      
      if (password && password != rePassword) {
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Info',
          autohide: true,
          delay: 5000,
          body: 'Password dan Confirm Password tidak sama!'
        })
        event.preventDefault();
      } else {
        $(this).submit();
      }
    });
  });
</script>

<?php include './views/admin_page/layout_footer.php'; ?>