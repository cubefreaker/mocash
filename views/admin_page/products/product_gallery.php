<?php include './views/admin_page/layout_header.php'; ?>
<?php include './views/admin_page/layout_nav.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= $kategori ?></h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <?php foreach ($listProduct as $p) : ?>
            <div class="col-sm-3 mb-4">
              <div class="row">
                <div class="col-12">
                  <?php
                    $image = $p['image'] && file_exists('./assets/image/products/' . $p['image']) ? '/assets/image/products/' . $p['image'] : '/assets/image/default-placeholder.png';
                  ?>
                  <a href="<?= $image ?>" data-toggle="lightbox" data-title="<?= $p['nama'] ?>" data-gallery="gallery" style="display: flex; justify-content: center">
                    <img src="<?= $image ?>" class="img-fluid mb-2" alt="<?= $p['nama'] ?>" style="width: 250px; height: 200px" />
                  </a>
                </div>
                <div class="col-12 text-center">
                  <?= $p['nama'] ?>
                </div>
                <div class="col-12 text-center">
                  <strong>Rp. <?= number_format($p['harga'], 2, ',', '.') ?></strong>
                </div>
                <div class="col-12 text-center">
                  Stok: <?= $p['stok'] ?>
                </div>
                <div class="col-12 text-center my-2">
                  <button onclick="window.location.href = '/admin/product/cart/add?id=<?= $p['id'] ?>&cart_id=<?= isset($this->cart['id']) ? $this->cart['id'] : '' ?>&price=<?= $p['harga'] ?>&kategori=<?= $kategori ?>'" class="btn btn-sm btn-primary" <?= $p['stok'] <= 0 ? 'disabled' : '' ?> >Pilih</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
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
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true,
      });
    });
  });
</script>

<?php include './views/admin_page/layout_footer.php'; ?>