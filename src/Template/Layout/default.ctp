<!DOCTYPE html>
<html lang="pt_br">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>Sistema de login</title>
    <link href="favicon.png" type="image/x-icon" rel="icon"/>
    <link href="favicon.png" type="image/x-icon" rel="shortcut icon"/>

    <!-- Font Awesome -->
    <?= $this->Html->css('fontawesome/css/all.min.css') ?>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <?= $this->Html->css('adminlte/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>
    <?= $this->Html->css('adminlte/datatables-responsive/css/responsive.bootstrap4.min.css') ?>
    <!-- icheck bootstrap -->
    <?= $this->Html->css('adminlte/icheck-bootstrap/icheck-bootstrap.min.css') ?>
    <!-- Theme style -->
    <?= $this->Html->css('adminlte/adminlte.min.css') ?>
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <?= $this->Html->image('../favicon.ico', ['class' => 'brand-image']) ?>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <?= $this->Html->link('link1', ['controller' => '/'], ['class' => 'nav-link']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link('link2', ['controller' => '/'], ['class' => 'nav-link']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link('link3', ['controller' => '/'], ['class' => 'nav-link']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link('link4', ['controller' => '/'], ['class' => 'nav-link']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link('link5', ['controller' => '/'], ['class' => 'nav-link']) ?>
                        </li>
                    </ul>
                </div>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li><?= $this->Html->link('Sair', ['controller' => 'sair']) ?></li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?= $this->fetch('content') ?>
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <?= $this->Html->script('adminlte/jquery/jquery.min.js') ?>
    <!-- Bootstrap 4 -->
    <?= $this->Html->script('adminlte/bootstrap/bootstrap.bundle.min.js') ?>
    <!-- DataTables -->
    <?= $this->Html->script('adminlte/datatables/jquery.dataTables.min.js') ?>
    <?= $this->Html->script('adminlte/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>
    <?= $this->Html->script('adminlte/datatables-responsive/js/dataTables.responsive.min.js') ?>
    <?= $this->Html->script('adminlte/datatables-responsive/js/responsive.bootstrap4.min.js') ?>
    <!-- AdminLTE App -->
    <?= $this->Html->script('adminlte/adminlte.min.js') ?>
    <!-- AdminLTE for demo purposes -->
    <?= $this->Html->script('adminlte/demo.js') ?>
    <!-- Page Script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>