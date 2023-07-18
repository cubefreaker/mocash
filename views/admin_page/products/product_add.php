<?php include './views/admin_page/layout_header.php'; ?>
<?php include './views/admin_page/layout_nav.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="/admin/products"><i class="fas fa-chevron-left"></i>&nbsp;Back</a>
            <br>
            <h1>Add Product</h1>
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
              <form id="formAddProduct" method="POST" action="/admin/product/add">
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Nama Produk</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Enter nama" required>
                  </div>
                  <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select class="form-control" name="kategori" required>
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Cemilan">Cemilan</option>
                        <option value="Dessert">Dessert</option>
                        <option value="Paket">Paket</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" step="0.1" class="form-control" name="harga" id="harga" placeholder="Enter harga" required>
                  </div>
                  <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" name="stok" id="stok" placeholder="Enter stok" required>
                  </div>
                  <div class="form-group">
                    <label for="company">Company</label>
                    <select class="form-control" name="company" required>
                        <?php foreach ($listCompany as $company) { ?>
                            <option value="<?= $company['company'] ?>"><?= $company['company'] ?></option>
                        <?php } ?>
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
  });
</script>

<?php include './views/admin_page/layout_footer.php'; ?>