<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Отчеты</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Отчеты</span></li>
            </ol>
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

<!-- start: page -->
    <section class="panel">
        <div class="row">
            <div class="col-md-6">
                <form method="POST" action="" class="form-horizontal">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Отчет по наименованию МТР</h2>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Наименование МТР: </label>
                                <div class="col-sm-8">
                                    <input type="text" name="name_mtr" value="<?php if(isset($_POST['name_mtr'])) { echo($_POST['name_mtr']); } ?>" required class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Наименование участка: </label>
                                <div class="col-sm-8">
                                    <select name="name_filial" class="form-control">
                                        <?php if(isset($_POST['name_filial'])) {
                                         foreach ($filials as $item_filials): ?>
                                            <?php $select_filial=($item_filials['name_filial']==$_POST['name_filial'])?"selected":"";?>
                                            <option value="<?php echo($item_filials['name_filial']); ?>" <?php echo($select_filial); ?> ><?php echo($item_filials['name_filial']); ?></option>
                                        <?php endforeach; } else { ?>

                                        <?php foreach($filials as $item_filials): ?>
                                            <option value="<?php echo($item_filials['name_filial']) ?>"><?php echo($item_filials['name_filial']) ?></option>
                                        <?php endforeach; } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Выбор даты: </label>
                                <div class="col-sm-8">
                                    <div class="input-daterange input-group">
                                        <span class="input-group-addon">от</span>
                                        <input type="text" autocomplete="off" value="<?php if(isset($_POST['start_date_1'])) echo($_POST['start_date_1']) ?>" class="form-control" name="start_date_1" />
                                        <span class="input-group-addon">до</span>
                                        <input type="text" autocomplete="off" value="<?php if(isset($_POST['end_date_1'])) echo($_POST['end_date_1']) ?>" class="form-control" name="end_date_1" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <button name="button_search_name_mtr" class="btn btn-primary">Поиск</button>
                        </footer>
                    </section>
                </form>
            </div>
            <div class="col-md-6">
                <form method="POST" action="" class="form-horizontal">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Отчет по неотправленным МТР</h2>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Наименование МТР: </label>
                                <div class="col-sm-8">
                                    <input type="text" name="name_mtr_2" value="<?php if(isset($_POST['name_mtr_2'])) { echo($_POST['name_mtr_2']); } ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Дата создания: </label>
                                <div class="col-sm-8" id="rangeDate">
                                    <div class=" input-daterange input-group" id="datepicker">
                                        <span class="input-group-addon">от</span>
                                        <input type="text" autocomplete="off" value="<?php if(isset($_POST['start_date_2'])) echo($_POST['start_date_2']) ?>" class="form-control" name="start_date_2" />
                                        <span class="input-group-addon">до</span>
                                        <input type="text" autocomplete="off" value="<?php if(isset($_POST['end_date_2'])) echo($_POST['end_date_2']) ?>" class="form-control" name="end_date_2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <button name="button_search_mtr" class="btn btn-primary">Поиск </button>
                        </footer>
                    </section>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form method="POST" action="" class="form-horizontal">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Отчет по направлению</h2>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Наименование участка: </label>
                                <div class="col-sm-8">
                                    <select name="name_filial_3" class="form-control">
                                        <?php if(isset($_POST['name_filial_3'])) {
                                            foreach ($filials as $item_filials): ?>
                                                <?php $select_filial=($item_filials['name_filial']==$_POST['name_filial_3'])?"selected":"";?>
                                                <option value="<?php echo($item_filials['name_filial']); ?>" <?php echo($select_filial); ?> ><?php echo($item_filials['name_filial']); ?></option>
                                            <?php endforeach; } else { ?>

                                            <?php foreach($filials as $item_filials): ?>
                                                <option value="<?php echo($item_filials['name_filial']) ?>"><?php echo($item_filials['name_filial']) ?></option>
                                            <?php endforeach; } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Выбор даты: </label>
                                <div class="col-sm-8" id="rangeDate">
                                    <div class=" input-daterange input-group" id="datepicker">
                                        <span class="input-group-addon">от</span>
                                        <input type="text" autocomplete="off" value="<?php if(isset($_POST['start_date_3'])) echo($_POST['start_date_3']) ?>" class="form-control" name="start_date_3" />
                                        <span class="input-group-addon">до</span>
                                        <input type="text" autocomplete="off" value="<?php if(isset($_POST['end_date_3'])) echo($_POST['end_date_3']) ?>" class="form-control" name="end_date_3" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <button name="button_search_filials" class="btn btn-primary">Поиск </button>
                        </footer>
                    </section>
                </form>
            </div>
            <div class="col-md-6">
                <form method="POST" action="" class="form-horizontal">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Отчет по статусу распоряжений</h2>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Статус распоряжения: </label>
                                <div class="col-sm-8">
                                    <select name="status" class="form-control">
                                        <option></option>
                                        <option value="0">Создание</option>
                                        <option value="10">На согласование</option>
                                        <option value="20">Согласован</option>
                                        <option value="30">В работе</option>
                                        <option value="40">Отправлен</option>
                                        <option value="50">На участке</option>
                                        <option value="60">Завершено</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Дата создания: </label>
                                <div class="col-sm-8" id="rangeDate">
                                    <div class=" input-daterange input-group" id="datepicker">
                                        <span class="input-group-addon">от</span>
                                        <input type="text" autocomplete="off" value="<?php if(isset($_POST['start_date_4'])) echo($_POST['start_date_4']) ?>" class="form-control" name="start_date_4" />
                                        <span class="input-group-addon">до</span>
                                        <input type="text" autocomplete="off" value="<?php if(isset($_POST['end_date_4'])) echo($_POST['end_date_4']) ?>" class="form-control" name="end_date_4" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <button name="button_search_status_orders" class="btn btn-primary">Поиск </button>
                        </footer>
                    </section>
                </form>
            </div>
        </div>
    </section>
<!--Отчет по наименованию МТР-->
    <?php if(isset($_POST['button_search_name_mtr'])) { ?>
        <section id="create_motion" class="panel">
            <div class="panel-body">
                <form method="POST" action="<?=base_url();?>Main/motion">
                    <div class="">
                        <table id="createMotionMTR" class="table table-hover">
                            <thead>
                            <tr>
                                <th style="width: 50px;">№</th>
                                <th>Наименование МТР</th>
                                <th>Номер распоряжения</th>
                                <th>Дата распоряжения</th>
                                <th>Участок</th>
                                <th>Склад</th>
                                <th>Статус</th>
                                <th>Прогресс</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($orders as $item): ?>
                                    <tr>
                                        <td style="width: 50px;"></td>
                                        <td><?php echo($item['nameMTR']); ?> </td>
                                        <td>Распоряжение №<?php echo($item['number_order']); ?></td>
                                        <td><?php echo($item['date_order']); ?></td>
                                        <td><?php echo($item['address_order']); ?></td>
                                        <td><?php echo($item['name_sklad']); ?></td>
                                           <?php if ($item['flag'] == 0) { ?>
                                        <td> <span class="label label-info"> <?php echo('Создание'); ?></span></td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                                                    10%
                                                </div>
                                            </div>
                                        </td>
                                        <?php } elseif ($item['flag'] == 10) { ?>
                                        <td> <span class="label label-warning"> <?php echo('На согласовании'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                                    25%
                                                </div>
                                            </div>
                                        </td>
                                        <?php } elseif ($item['flag'] == 20) { ?>
                                        <td> <span class="label label-success"> <?php echo('Согласован'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    50%
                                                </div>
                                            </div>
                                        </td>
                                        <?php } elseif ($item['flag'] == 30) { ?>
                                        <td> <span class="label label-warning"> <?php echo('В работе'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    50%
                                                </div>
                                            </div>
                                        </td>
                                        <?php } elseif ($item['flag'] == 40) { ?>
                                        <td> <span class="label label-success"> <?php echo('Отправлен'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
                                                    70%
                                                </div>
                                            </div>
                                        </td>
                                        <?php } elseif ($item['flag'] == 50) { ?>
                                        <td> <span class="label label-warning"> <?php echo('На участке'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">
                                                    90%
                                                </div>
                                            </div>
                                        </td>
                                        <?php } elseif ($item['flag'] == 60) { ?>
                                        <td> <span class="label label-success"> <?php echo('Завершен'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                    100%
                                                </div>
                                            </div>
                                        </td>
                                        <?php } else { ?>
                                        <td> <span class="label label-danger"> <?php echo('Ошибка'); ?></span></td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    50%
                                                </div>
                                            </div>
                                        </td>
                                        <?php }?>
                                    </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </section>
    <?php  } ?>
<!--Отчет по неотправленным МТР-->
    <?php if(isset($_POST['button_search_mtr'])) { ?>
        <section id="create_motion" class="panel">
            <div class="panel-body">
                <form method="POST" action="<?=base_url();?>Main/motion">
                    <div class="">
                        <table id="createMotionMTR" class="table table-hover">
                            <thead>
                            <tr>
                                <th style="width: 50px;">№</th>
                                <th>Наименование МТР</th>
                                <th>Номер распоряжения</th>
                                <th>Дата распоряжения</th>
                                <th>Участок</th>
                                <th>Склад</th>
                                <th>Статус</th>
                                <th>Прогресс</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($orders as $item):
                            $_status = (integer)$item['flag'];
                            if ( ($_status == 20) || ($_status == 30) || ($_status == 40) || ($_status == 50) || ($_status == 60)) { ?>
                                <tr>
                                    <td style="width: 50px;"></td>
                                    <td><?php echo($item['nameMTR']); ?> </td>
                                    <td>Распоряжение №<?php echo($item['number_order']); ?></td>
                                    <td><?php echo($item['date_order']); ?></td>
                                    <td><?php echo($item['address_order']); ?></td>
                                    <td><?php echo($item['name_sklad']); ?></td>
                                    <?php if ($item['flag'] == 0) { ?>
                                        <td> <span class="label label-info"> <?php echo('Создание'); ?></span></td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                                                    10%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } elseif ($item['flag'] == 10) { ?>
                                        <td> <span class="label label-warning"> <?php echo('На согласовании'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                                    25%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } elseif ($item['flag'] == 20) { ?>
                                        <td> <span class="label label-success"> <?php echo('Согласован'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    50%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } elseif ($item['flag'] == 30) { ?>
                                        <td> <span class="label label-warning"> <?php echo('В работе'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    50%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } elseif ($item['flag'] == 40) { ?>
                                        <td> <span class="label label-success"> <?php echo('Отправлен'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
                                                    70%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } elseif ($item['flag'] == 50) { ?>
                                        <td> <span class="label label-warning"> <?php echo('На участке'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">
                                                    90%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } elseif ($item['flag'] == 60) { ?>
                                        <td> <span class="label label-success"> <?php echo('Завершен'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                    100%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } else { ?>
                                        <td> <span class="label label-danger"> <?php echo('Ошибка'); ?></span></td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    50%
                                                </div>
                                            </div>
                                        </td>
                                    <?php }?>
                                </tr>
                            <?php } endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </section>
    <?php  } ?>
<!--Отчет по направлению-->
    <?php if(isset($_POST['button_search_filials'])) { ?>
        <section id="create_motion" class="panel">
            <div class="panel-body">
                <form method="POST" action="<?=base_url();?>Main/motion">
                    <div class="">
                        <table id="createMotionMTR" class="table table-hover">
                            <thead>
                            <tr>
                                <th style="width: 50px;">№</th>
                                <th>Номер распоряжения</th>
                                <th>Дата распоряжения</th>
                                <th>Участок</th>
                                <th>Склад</th>
                                <th>Статус</th>
                                <th>Прогресс</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($orders as $item): ?>
                                    <tr>
                                        <td style="width: 50px;"></td>
                                        <td>Распоряжение №<?php echo($item['number_order']); ?></td>
                                        <td><?php echo($item['date_order']); ?></td>
                                        <td><?php echo($item['address_order']); ?></td>
                                        <td><?php echo($item['name_sklad']); ?></td>
                                        <?php if ($item['flag'] == 0) { ?>
                                            <td> <span class="label label-info"> <?php echo('Создание'); ?></span></td>
                                            <td>
                                                <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                                                        10%
                                                    </div>
                                                </div>
                                            </td>
                                        <?php } elseif ($item['flag'] == 10) { ?>
                                            <td> <span class="label label-warning"> <?php echo('На согласовании'); ?></span>
                                                <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                            </td>
                                            <td>
                                                <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                                        25%
                                                    </div>
                                                </div>
                                            </td>
                                        <?php } elseif ($item['flag'] == 20) { ?>
                                            <td> <span class="label label-success"> <?php echo('Согласован'); ?></span>
                                                <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                            </td>
                                            <td>
                                                <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                        50%
                                                    </div>
                                                </div>
                                            </td>
                                        <?php } elseif ($item['flag'] == 30) { ?>
                                            <td> <span class="label label-warning"> <?php echo('В работе'); ?></span>
                                                <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                            </td>
                                            <td>
                                                <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                        50%
                                                    </div>
                                                </div>
                                            </td>
                                        <?php } elseif ($item['flag'] == 40) { ?>
                                            <td> <span class="label label-success"> <?php echo('Отправлен'); ?></span>
                                                <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                            </td>
                                            <td>
                                                <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
                                                        70%
                                                    </div>
                                                </div>
                                            </td>
                                        <?php } elseif ($item['flag'] == 50) { ?>
                                            <td> <span class="label label-warning"> <?php echo('На участке'); ?></span>
                                                <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                            </td>
                                            <td>
                                                <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">
                                                        90%
                                                    </div>
                                                </div>
                                            </td>
                                        <?php } elseif ($item['flag'] == 60) { ?>
                                            <td> <span class="label label-success"> <?php echo('Завершен'); ?></span>
                                                <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                            </td>
                                            <td>
                                                <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                        100%
                                                    </div>
                                                </div>
                                            </td>
                                        <?php } else { ?>
                                            <td> <span class="label label-danger"> <?php echo('Ошибка'); ?></span></td>
                                            <td>
                                                <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                        50%
                                                    </div>
                                                </div>
                                            </td>
                                        <?php }?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </section>
    <?php  } ?>
<!--Отчет по статусу распоряжений-->
    <?php if(isset($_POST['button_search_status_orders'])) { ?>
        <section id="create_motion" class="panel">
            <div class="panel-body">
                <form method="POST" action="<?=base_url();?>Main/motion">
                    <div class="">
                        <table id="createMotionMTR" class="table table-hover">
                            <thead>
                            <tr>
                                <th style="width: 50px;">№</th>
                                <th>Номер распоряжения</th>
                                <th>Дата распоряжения</th>
                                <th>Участок</th>
                                <th>Склад</th>
                                <th>Статус</th>
                                <th>Прогресс</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($orders as $item): ?>
                                <tr>
                                    <td style="width: 50px;"></td>
                                    <td>Распоряжение №<?php echo($item['number_order']); ?></td>
                                    <td><?php echo($item['date_order']); ?></td>
                                    <td><?php echo($item['address_order']); ?></td>
                                    <td><?php echo($item['name_sklad']); ?></td>
                                    <?php if ($item['flag'] == 0) { ?>
                                        <td> <span class="label label-info"> <?php echo('Создание'); ?></span></td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                                                    10%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } elseif ($item['flag'] == 10) { ?>
                                        <td> <span class="label label-warning"> <?php echo('На согласовании'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                                    25%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } elseif ($item['flag'] == 20) { ?>
                                        <td> <span class="label label-success"> <?php echo('Согласован'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    50%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } elseif ($item['flag'] == 30) { ?>
                                        <td> <span class="label label-warning"> <?php echo('В работе'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    50%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } elseif ($item['flag'] == 40) { ?>
                                        <td> <span class="label label-success"> <?php echo('Отправлен'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
                                                    70%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } elseif ($item['flag'] == 50) { ?>
                                        <td> <span class="label label-warning"> <?php echo('На участке'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">
                                                    90%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } elseif ($item['flag'] == 60) { ?>
                                        <td> <span class="label label-success"> <?php echo('Завершен'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                    100%
                                                </div>
                                            </div>
                                        </td>
                                    <?php } else { ?>
                                        <td> <span class="label label-danger"> <?php echo('Ошибка'); ?></span></td>
                                        <td>
                                            <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    50%
                                                </div>
                                            </div>
                                        </td>
                                    <?php }?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </section>
    <?php  } ?>
</section>

<script src="<?=base_url();?>assets/order/jquery-3.3.1.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url();?>assets/vendor/datepicker/locales/bootstrap-datepicker.ru.min.js" charset="UTF-8"></script>
<script>

    $(document).ready(function() {
        /*Таблица*/
        var t = $('#createMotionMTR').DataTable({
            "language": {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }
            },
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 2, '' ]]
        });

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

//Вывод даты
        $('.input-daterange').datepicker({
            format: "dd-mm-yyyy",
            language: "ru",
            orientation: "bottom auto",
            autoclose: true
        });
    });

    //Экспорт в Excel
    function ExportXls(id){
        var id_order = id.getAttribute('data-id_all_order');
        console.log("Export XSL");
        console.log(id_order);

        $.ajax({
            url: "<?=base_url();?>Main/export_Orders",
            type: "POST",
            data: {id_order : id_order},
            success: function(data){
                window.location ="<?=base_url();?>Main/export_Orders?JSid_order="+id_order;
            }
        })
    }
</script>
