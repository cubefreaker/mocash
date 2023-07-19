<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MOCASH</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/admin_template/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/admin_template/dist/css/adminlte.min.css">
  <!-- jQuery -->
  <script src="/assets/admin_template/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/assets/admin_template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/assets/admin_template/dist/js/adminlte.min.js"></script>
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="/" class="h1" style="font-size: 35px;font-weight: 600">MO<span style="font-size: 35px;color:rgba(255, 89, 0, 0.8)">CASH</span></a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Login ke aplikasi mocash</p>

          <form action="/admin/login" method="post">
              <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                    </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
              </div>
              <div class="row">
                <!-- <div class="col-8">
                    <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                        Remember Me
                    </label>
                    </div>
                </div> -->
                <!-- /.col -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
              </div>
          </form>

          <!-- <p class="mb-1">
              <a href="forgot-password.html">I forgot my password</a>
          </p>
          <p class="mb-0">
              <a href="register.html" class="text-center">Register a new membership</a>
          </p> -->
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->
<script>
    let flash_message_success = '<?= $this->flash_message['success'] ?>';
    let flash_message_warning = '<?= $this->flash_message['warning'] ?>';
    let flash_message_error = '<?= $this->flash_message['error'] ?>';
    let flash_message_info = '<?= $this->flash_message['info'] ?>';

    if(flash_message_success != ''){
      $(document).Toasts('create', {
        class: 'bg-success',
        title: 'Success',
        autohide: true,
        delay: 5000,
        body: flash_message_success
      })
    }

    if(flash_message_warning != ''){
      $(document).Toasts('create', {
        class: 'bg-warning',
        title: 'Warning',
        autohide: true,
        delay: 5000,
        body: flash_message_warning
      })
    }

    if(flash_message_error != ''){
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Error',
        autohide: true,
        delay: 5000,
        body: flash_message_error
      })
    }

    if(flash_message_info != ''){
      $(document).Toasts('create', {
        class: 'bg-info',
        title: 'Info',
        autohide: true,
        delay: 5000,
        body: flash_message_info
      })
    }
</script>
</body>
</html>