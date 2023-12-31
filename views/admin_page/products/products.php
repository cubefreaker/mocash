<?php include './views/admin_page/layout_header.php'; ?>
<?php include './views/admin_page/layout_nav.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>List Product</h1>
          </div>
          <?php if(in_array($this->user['role'], ['Owner', 'Super Admin'])) { ?>
            <div class="col-sm-6">
              <a href="/admin/product/add" class="btn btn-primary float-right">Add Product</a>
            </div>
          <?php } ?>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="listProduct" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <thead id="filter">
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Company</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($listProduct as $p){ ?>
                    <tr>
                        <td><?= $p['nama'] ?></td>
                        <td class="text-right">Rp. <?= number_format($p['harga'], 2, ',', '.') ?></td>
                        <td class="text-center"><?= $p['stok'] ?></td>
                        <td><?= $p['kategori'] ?></td>
                        <td><?= $p['company'] ?></td>
                        <td class="text-center">
                            <a href="/admin/product/edit?id=<?= $p['id'] ?>" class="btn btn-warning">Edit</a>
                            <?php if(in_array($this->user['role'], ['Owner', 'Super Admin'])) { ?>
                              <a href="/admin/product/delete?id=<?= $p['id'] ?>" class="btn btn-danger">Delete</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
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
    let table = $('#listProduct').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });

    // Add datatable button
    table.buttons().container().appendTo('#listProduct_wrapper .col-md-6:eq(0)');

    // Setup - add a text input to each footer cell
    $('#listProduct thead#filter th').each(function (i) {
    let title = $('#listProduct thead th').eq($(this).index()).text();
    $(this).html(`<input type="text" id="columnFilter_${i}" style="width: 100%" placeholder="${title}" data-index="${i}"/>`);
    } );

    // Filter event handler
    $(table.table().container()).on('keyup', 'thead#filter input', function () {
        table.column($(this).data('index')).search(this.value).draw();
    } );

    // Hide column event handler for column visibility
    $('#listProduct').on( 'column-visibility.dt', function ( e, settings, column, state ) {
        if(state) {
            $(`#columnFilter_${column}`).parent().show();
        } else {
            $(`#columnFilter_${column}`).parent().hide();
        }
    });
  });
</script>

<?php include './views/admin_page/layout_footer.php'; ?>