<?php include './views/admin_page/layout_header.php'; ?>
<?php include './views/admin_page/layout_nav.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="/admin/sales"><i class="fas fa-chevron-left"></i>&nbsp;Back</a>
            <br>
            <h1>Detail Penjualan</h1>
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
                <div class="row">
                    <div class="col-12">
                        <table id="cart" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Total</th>
                            </tr>
                          </thead>
                          <thead id="filter">
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($cart['detail'] as $c){ ?>
                            <tr>
                                <td><?= $c['nama'] ?></td>
                                <td class="text-right">Rp. <?= number_format($c['harga'], 2, ',', '.') ?></td>
                                <td class="text-center"><?= $c['jumlah'] ?></td>
                                <td class="text-right">Rp. <?= number_format($c['total'], 2, ',', '.') ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                    </div>
                    <?php if(!empty($cart['detail'])) { ?>
                        <div class="col-12 mt-5">
                            <h2>Total Harga: Rp. <?= number_format($cart['total_harga'], 2, ',', '.') ?></h2>
                            </div>
                        </div>
                    <?php } ?>
                </div>
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
    let table = $('#cart').DataTable({
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
    table.buttons().container().appendTo('#cart_wrapper .col-md-6:eq(0)');

    // Setup - add a text input to each footer cell
    $('#cart thead#filter th').each(function (i) {
    let title = $('#cart thead th').eq($(this).index()).text();
    $(this).html(`<input type="text" id="columnFilter_${i}" style="width: 100%" placeholder="${title}" data-index="${i}"/>`);
    } );

    // Filter event handler
    $(table.table().container()).on('keyup', 'thead#filter input', function () {
        table.column($(this).data('index')).search(this.value).draw();
    } );

    // Hide column event handler for column visibility
    $('#cart').on( 'column-visibility.dt', function ( e, settings, column, state ) {
        if(state) {
            $(`#columnFilter_${column}`).parent().show();
        } else {
            $(`#columnFilter_${column}`).parent().hide();
        }
    });
  });
</script>

<?php include './views/admin_page/layout_footer.php'; ?>