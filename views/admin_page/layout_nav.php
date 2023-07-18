<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <?php if($this->user) { ?>
        <li class="nav-item">
          <h5 class="nav-link"><?= strtoupper($this->user['fullname'] . ' (' . $this->user['company'] . ' | ' . $this->user['cabang'] . ')') ?></h5>
        </li>
      <?php } ?>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/assets/admin_template/index3.html" class="brand-link">
      <img src="/assets/image/logo_title.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">MOCASH</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php if(in_array($this->user['role'], ['Owner', 'Super Admin', 'Admin'])) { ?>
            <li class="nav-item">
              <a href="/admin/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/products" class="nav-link">
                <i class="nav-icon fas fa-box"></i>
                <p>
                  Products
                </p>
              </a>
            </li>
            </li>
            </li>
            <li class="nav-item">
              <a href="/admin/sales" class="nav-link">
                <i class="nav-icon fas fa-dollar-sign"></i>
                <p>
                  Sales
                </p>
              </a>
            </li>
            </li>
            <li class="nav-item">
              <a href="/admin/users" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Users
                </p>
              </a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a href="/admin/product/gallery?kategori=Populer" class="nav-link">
                <i class="nav-icon fas fa-fire-alt"></i>
                <p>
                  Populer
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/product/gallery?kategori=Paket" class="nav-link">
                <i class="nav-icon fas fa-gifts"></i>
                <p>
                  Paket
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/product/gallery?kategori=Makanan" class="nav-link">
                <i class="nav-icon fas fa-hamburger"></i>
                <p>
                  Makanan
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/product/gallery?kategori=Minuman" class="nav-link">
                <i class="nav-icon fas fa-mug-hot"></i>
                <p>
                  Minuman
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/product/gallery?kategori=Cemilan" class="nav-link">
                <i class="nav-icon fas fa-candy-cane"></i>
                <p>
                  Cemilan
                </p>
              </a>
            </li>
            <br>
            <li class="nav-item">
              <a href="/admin/product/cart" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <span class="badge badge-danger right"><?= $this->cart['detail'] ? array_sum(array_column($this->cart['detail'], 'jumlah')) : '' ?></span>
                <p>
                  Keranjang
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/products" class="nav-link">
                <i class="nav-icon fas fa-box"></i>
                <p>
                  Products
                </p>
              </a>
            </li>
          <?php } ?>
          <br>
          <li class="nav-item">
            <a href="/admin/logout" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>