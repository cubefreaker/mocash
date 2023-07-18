<?php include './views/admin_page/layout_header.php'; ?>
<?php include './views/admin_page/layout_nav.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>List Penjualan</h1>
          </div>
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
                <table id="listCart" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cabang</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th>User</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <thead id="filter">
                    <tr>
                        <th>ID</th>
                        <th>Cabang</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($listCart as $c){ ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= $c['cabang'] ?></td>
                        <td><?= $c['total_produk'] ?></td>
                        <td>Rp. <?= number_format($c['total_harga'], 2, ',', '.') ?></td>
                        <td><?= $c['user_email'] ?></td>
                        <td class="text-center">
                            <?php if($c['status'] == 'Pending') { ?>
                                <span class="badge badge-warning"><?= strtoupper($c['status']) ?></span>
                            <?php } else if($c['status'] == 'Done') { ?>
                                <span class="badge badge-success"><?= strtoupper($c['status']) ?></span>
                            <?php } else if($c['status'] == 'Cancel') { ?>
                                <span class="badge badge-danger"><?= strtoupper($c['status']) ?></span>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <a href="/admin/sales/detail?id=<?= $c['id'] ?>" class="btn btn-info">Detail</a>
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
  $(document).ready(function () {
    let table = $('#listCart').DataTable({
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
    table.buttons().container().appendTo('#listCart_wrapper .col-md-6:eq(0)');
    
    // Setup - add a text input to each footer cell
    $('#listCart thead#filter th').each(function (i) {
      let title = $('#listCart thead th').eq($(this).index()).text();
      $(this).html(`<input type="text" style="width: 100%" placeholder="${title}" data-index="${i}"/>`);
    } );

    // Filter event handler
    $(table.table().container()).on('keyup', 'thead#filter input', function () {
        table.column($(this).data('index')).search(this.value).draw();
    } );
  });
</script>

<?php include './views/admin_page/layout_footer.php'; ?>