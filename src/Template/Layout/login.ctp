<!DOCTYPE html>
<html lang="pt_br">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>Login</title>
    <?= $this->Html->meta('icon') ?>

    <!-- Font Awesome -->
    <?= $this->Html->css('fontawesome/css/all.min.css') ?>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <?= $this->Html->css('adminlte/icheck-bootstrap/icheck-bootstrap.min.css') ?>
    <!-- Theme style -->
    <?= $this->Html->css('adminlte/adminlte.min.css') ?>
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">

    <?= $this->fetch('content') ?>

    <!-- jQuery -->
    <?= $this->Html->script('adminlte/jquery/jquery.min.js') ?>
    <!-- Bootstrap 4 -->
    <?= $this->Html->script('adminlte/bootstrap/bootstrap.bundle.min.js') ?>
    <!-- AdminLTE App -->
    <?= $this->Html->script('adminlte/adminlte.min.js') ?>

</body>

</html>