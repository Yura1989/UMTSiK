<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?=base_url();?>/vendor/bootadmin/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url();?>/vendor/bootadmin/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?=base_url();?>/vendor/bootadmin/css/datatables.min.css">
    <link rel="stylesheet" href="<?=base_url();?>/vendor/bootadmin/css/fullcalendar.min.css">
    <link rel="stylesheet" href="<?=base_url();?>/vendor/bootadmin/css/bootadmin.min.css">
    <link rel="shortcut icon" href="<?=base_url();?>/vendor/bootadmin/favicon_it.ico" type="image/png">
    <script src="<?=base_url();?>assets/vendor/jquery-3.3.1.min.js"></script>

    <title>IT UMTSiK</title>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="sidebar-toggle mr-3" href="#"><i class="fa fa-bars"></i></a>
    <a class="navbar-brand" href="#">IT</a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a href="#" id="dd_user" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->userdata('sername');?> <?php echo $this->session->userdata('name'); ?></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                    <a class="dropdown-item" role="menuitem" href="<?=base_url();?>it/exit_session_it"><i class="fa fa-power-off"></i> Выйти из системы</a>
                </div>
            </li>
        </ul>
    </div>
</nav>