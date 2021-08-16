<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/reports/buttons.dataTables.min.css" >
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/reports/fixedHeader.dataTables.min.css" >
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
        <header class="panel-heading panel-heading-transparent">
            <h2 class="panel-title">Поиск информации по движению МТР</h2>
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
                                <?php if (isset($_POST['button_search_name_mtr'])) { ?>
                                    <button type="button" name="button_download_filials" onclick="ExportXls(this);"
                                            data-id_button_name_mtr="button_search_name_mtr"
                                            data-id_motion="<?php
                                            $n=0;
                                            foreach($orders as $item):
                                                if(isset($item['id_bond_order_mtr']))
                                                    echo($item['id_bond_order_mtr'].',');
                                                $n=$n+1;
                                            endforeach;
                                            ?>"
                                            class="download btn btn-success">Скачать
                                    </button>
                                <?php } ?>
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
                                    <label class="col-sm-4 control-label">Наименование участка: </label>
                                    <div class="col-sm-8">
                                        <select name="name_filial_2" class="form-control">
                                            <?php if(isset($_POST['name_filial_2'])) {
                                                foreach ($filials as $item_filials): ?>
                                                    <?php $select_filial=($item_filials['name_filial']==$_POST['name_filial_2'])?"selected":"";?>
                                                    <option value="<?php echo($item_filials['name_filial']); ?>" <?php echo($select_filial); ?> ><?php echo($item_filials['name_filial']); ?></option>
                                                <?php endforeach; } else { ?>

                                                <?php foreach($filials as $item_filials): ?>
                                                    <option value="<?php echo($item_filials['name_filial']) ?>"><?php echo($item_filials['name_filial']) ?></option>
                                                <?php endforeach; } ?>
                                        </select>
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
                                <div class="form-group">
                                    <div class="col-sm-8">
                                            <input type="checkbox" name="" id="checkboxOrder" class="checkboxOrder" data-checkboxOrder="checkboxOrder" value="checkboxOrder" >
                                            <label class="col-sm-8" for="checkboxOrder">Учитывать МТР по Распоряжениям в статусе: "Согласован", "В работе"</label>
                                    </div>
                                </div>
                            </div>
                            <footer class="panel-footer">
                                <button name="button_search_mtr" class="btn btn-primary">Поиск </button>
                                <?php if (isset($_POST['button_search_mtr'])) { ?>
                                    <button type="button" name="button_download_filials" onclick="ExportXls(this);"
                                            data-id_button_search_mtr="button_search_mtr"
                                            data-id_motion="<?php
                                            $n=0;
                                            foreach($orders as $item):
                                                if(isset($item['id_bond_all_orders']))
                                                    echo($item['id_bond_all_orders'].',');
                                                $n=$n+1;
                                            endforeach;
                                            ?>"
                                            class="download btn btn-success">Скачать
                                    </button>
                                <?php } ?>
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
                                <?php if (isset($_POST['button_search_filials'])) { ?>
                                    <button type="button" name="button_download_filials" onclick="ExportXls(this);"
                                            data-id_motion="<?php
                                            $n=0;
                                            foreach($orders as $item):
                                                if(isset($item['id_bond_order_mtr']))
                                                    echo($item['id_bond_order_mtr'].',');
                                                $n=$n+1;
                                            endforeach;
                                            ?>"
                                            class="download btn btn-success">Скачать
                                    </button>
                                <?php } ?>
                            </footer>
                        </section>
                    </form>
                </div>
<!--                <div class="col-md-6">-->
<!--                    <form method="POST" action="" class="form-horizontal">-->
<!--                        <section class="panel">-->
<!--                            <header class="panel-heading">-->
<!--                                <h2 class="panel-title">Отчет по статусу распоряжений</h2>-->
<!--                            </header>-->
<!--                            <div class="panel-body">-->
<!--                                <div class="form-group">-->
<!--                                    <label class="col-sm-4 control-label">Статус распоряжения: </label>-->
<!--                                    <div class="col-sm-8">-->
<!--                                        <select name="status" class="form-control">-->
<!--                                            <option></option>-->
<!--                                            <option value="0">Создание</option>-->
<!--                                            <option value="10">На согласование</option>-->
<!--                                            <option value="20">Согласован</option>-->
<!--                                            <option value="30">В работе</option>-->
<!--                                            <option value="40">Отправлен</option>-->
<!--                                            <option value="50">На участке</option>-->
<!--                                            <option value="60">Завершено</option>-->
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <label class="col-sm-4 control-label">Дата создания: </label>-->
<!--                                    <div class="col-sm-8" id="rangeDate">-->
<!--                                        <div class=" input-daterange input-group" id="datepicker">-->
<!--                                            <span class="input-group-addon">от</span>-->
<!--                                            <input type="text" autocomplete="off" value="--><?php //if(isset($_POST['start_date_4'])) echo($_POST['start_date_4']) ?><!--" class="form-control" name="start_date_4" />-->
<!--                                            <span class="input-group-addon">до</span>-->
<!--                                            <input type="text" autocomplete="off" value="--><?php //if(isset($_POST['end_date_4'])) echo($_POST['end_date_4']) ?><!--" class="form-control" name="end_date_4" />-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <footer class="panel-footer">-->
<!--                                <button name="button_search_status_orders" class="btn btn-primary">Поиск </button>-->
<!--                            </footer>-->
<!--                        </section>-->
<!--                    </form>-->
<!--                </div>-->
            </div>
        </section>
        <!--Отчет по наименованию МТР-->
        <?php if(isset($_POST['button_search_name_mtr'])) { ?>
            <section id="create_motion" class="panel">
                <div class="panel-body">
                    <form method="POST" action="<?=base_url();?>Main/motion">

                            <table id="createMotionMTR" class="display ">
                                <thead>
                                <tr>
                                    <th style="width: 50px;">№</th>
                                    <th >Код МТР</th>
                                    <th >Наименование МТР</th>
                                    <th >Номер партии</th>
                                    <th >Длина, м</th>
                                    <th >Ширина, м</th>
                                    <th >Высота, м</th>
                                    <th >Ед.изм.</th>
                                    <th >Наименование объекта</th>
                                    <th >Инвентарный № объекта</th>
                                    <th >Кол-во</th>
                                    <th >вес 1 ед.</th>
                                    <th >Всего</th>
                                    <th >Дата заявки на отгрузку</th>
                                    <th >Заявка на контейнер/автотранспорт</th>
                                    <th >Дата отгрузки</th>
                                    <th >Груз сформирован в контейнер/автотранспорт</th>
                                    <th >Отгружено</th>
                                    <th >Остаток</th>
                                    <th >Наименование транзитного* <br/> или конечного получателя груза</th>
                                    <th >Наименование филиала получателя</th>
                                    <th >Накладная формы М11 № накладной</th>
                                    <th >Накладная формы М11 Дата накладной</th>
                                    <th >Приоритет(1,2,3)**</th>
                                    <th >Примечание по доставке</th>
                                    <th >Общие примечания</th>
                                    <th >Дата поступления МТР на базу, участок</th>
                                    <th >№ накладной М 15</th>
                                    <th >Дата накладной М 15</th>
                                    <th >Дата получения МТР филиалом получателя</th>
                                    <th >Принято, кол-во</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n=0; foreach($orders as $item): ?>
                                    <tr>
                                        <td></td>
                                        <td><?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?></td>
                                        <td><?php if(isset($item['nameMTR'])) echo($item['nameMTR']); ?></td>
                                        <td><?php if(isset($item['numberPart'])) echo($item['numberPart']); ?></td>
                                        <td><?php if(isset($item['length_motion'])) echo($item['length_motion']); ?></td>
                                        <td><?php if(isset($item['width_motion'])) echo($item['width_motion']); ?></td>
                                        <td><?php if(isset($item['height_motion'])) echo($item['height_motion']); ?></td>
                                        <td><?php if(isset($item['sizeMTR'])) echo($item['sizeMTR']); ?></td>
                                        <td><?php if(isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?></td>
                                        <td><?php if(isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?></td>
                                        <td><?php if(isset($item['sumMTR'])) echo($item['sumMTR']); ?></td>
                                        <td><?php if(isset($item['weight_motion'])) echo($item['weight_motion']); ?></td>
                                        <td><?php if(isset($item['total_motion'])) echo($item['total_motion']); ?></td>
                                        <td>
                                            <?php if(isset($item['dateRequest_motion'])) {
                                                if ($item['dateRequest_motion'] == NULL || $item['dateRequest_motion'] == '0000-00-00' || $item['dateRequest_motion'] == '1970-01-01') {
                                                    echo('-');
                                                } else {
                                                    echo(date('d-m-Y', strtotime($item['dateRequest_motion']))); }
                                            }
                                            ?>
                                        </td>
                                        <td><?php if(isset($item['infoShipments_motion'])) echo($item['infoShipments_motion']); ?></td>
                                        <td>
                                            <?php if(isset($item['dateShipments_motion'])) {
                                                if ($item['dateShipments_motion'] == NULL || $item['dateShipments_motion'] == '0000-00-00' || $item['dateShipments_motion'] == '1970-01-01') {
                                                    echo('-');
                                                } else {
                                                    echo(date('d-m-Y', strtotime($item['dateShipments_motion']))); }
                                            }
                                            ?>
                                        </td>
                                        <td><?php if(isset($item['cargo_motion'])) echo($item['cargo_motion']); ?></td>
                                        <td><?php if(isset($item['shipped_motion'])) echo($item['shipped_motion']); ?></td>
                                        <td><?php if(isset($item['remains_motion'])) echo($item['remains_motion']); ?></td>
                                        <td><?php if(isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?></td>
                                        <td><?php if(isset($item['filialMTR'])) echo($item['filialMTR']); ?></td>
                                        <td><?php if(isset($item['numberOverhead_motion'])) echo($item['numberOverhead_motion']); ?></td>
                                        <td>
                                            <?php if(isset($item['dateOverhead_motion'])) {
                                                if ($item['dateOverhead_motion'] == NULL || $item['dateOverhead_motion'] == '0000-00-00' || $item['dateOverhead_motion'] == '1970-01-01') {
                                                    echo('-');
                                                } else {
                                                    echo(date('d-m-Y', strtotime($item['dateOverhead_motion']))); }
                                            }
                                            ?>
                                        </td>
                                        <td><?php if(isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?></td>
                                        <td><?php if(isset($item['noteMTR'])) echo($item['noteMTR']); ?></td>
                                        <td><?php if(isset($item['note_motion'])) echo($item['note_motion']); ?></td>
                                        <td>
                                            <?php if(isset($item['dateArrival_motion'])) {
                                                if ($item['dateArrival_motion'] == NULL || $item['dateArrival_motion'] == '0000-00-00' || $item['dateArrival_motion'] == '1970-01-01') {
                                                    echo('-');
                                                } else {
                                                    echo(date('d-m-Y', strtotime($item['dateArrival_motion']))); }
                                            }
                                            ?>
                                        </td>
                                        <td><?php if(isset($item['numberM15_motion'])) echo($item['numberM15_motion']); ?></td>
                                        <td>
                                            <?php if(isset($item['dateM15_motion'])) {
                                                if ($item['dateM15_motion'] == NULL || $item['dateM15_motion'] == '0000-00-00' || $item['dateM15_motion'] == '1970-01-01') {
                                                    echo('-');
                                                } else {
                                                    echo(date('d-m-Y', strtotime($item['dateM15_motion']))); }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if(isset($item['dateFilial_motion'])) {
                                                if ($item['dateFilial_motion'] == NULL || $item['dateFilial_motion'] == '0000-00-00' || $item['dateFilial_motion'] == '1970-01-01') {
                                                    echo('-');
                                                } else {
                                                    echo(date('d-m-Y', strtotime($item['dateFilial_motion']))); }
                                            }
                                            ?>
                                        </td>
                                        <td><?php if(isset($item['recd'])) echo($item['recd']); ?></td>
                                    </tr>
                                    <?php $n=$n+1; endforeach; ?>
                                </tbody>
                            </table>

                    </form>
                </div>
            </section>
        <?php  } ?>
        <!--Отчет по неотправленным МТР-->
        <?php if(isset($_POST['button_search_mtr'])) { ?>
            <section id="create_motion" class="panel">
                <div class="panel-body">
                    <form method="POST" action="<?=base_url();?>Main/motion">

                        <table id="createMotionMTR" class="display ">
                            <thead>
                            <tr>
                                <th style="width: 50px;">№</th>
                                <th >Код МТР</th>
                                <th >Наименование МТР</th>
                                <th >Номер партии</th>
                                <th >Длина, м</th>
                                <th >Ширина, м</th>
                                <th >Высота, м</th>
                                <th >Ед.изм.</th>
                                <th >Наименование объекта</th>
                                <th >Инвентарный № объекта</th>
                                <th >Кол-во</th>
                                <th >вес 1 ед.</th>
                                <th >Всего</th>
                                <th >Дата заявки на отгрузку</th>
                                <th >Заявка на контейнер/автотранспорт</th>
                                <th >Дата отгрузки</th>
                                <th >Груз сформирован в контейнер/автотранспорт</th>
                                <th >Отгружено</th>
                                <th >Остаток</th>
                                <th >Наименование транзитного* <br/> или конечного получателя груза</th>
                                <th >Наименование филиала получателя</th>
                                <th >Накладная формы М11 № накладной</th>
                                <th >Накладная формы М11 Дата накладной</th>
                                <th >Приоритет(1,2,3)**</th>
                                <th >Примечание по доставке</th>
                                <th >Общие примечания</th>
                                <th >Дата поступления МТР на базу, участок</th>
                                <th >№ накладной М 15</th>
                                <th >Дата накладной М 15</th>
                                <th >Дата получения МТР филиалом получателя</th>
                                <th >Принято, кол-во</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $n=0; foreach($orders as $item): ?>
                                <tr>
                                    <td></td>
                                    <td><?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?></td>
                                    <td><?php if(isset($item['nameMTR'])) echo($item['nameMTR']); ?></td>
                                    <td><?php if(isset($item['numberPart'])) echo($item['numberPart']); ?></td>
                                    <td><?php if(isset($item['length_motion'])) echo($item['length_motion']); ?></td>
                                    <td><?php if(isset($item['width_motion'])) echo($item['width_motion']); ?></td>
                                    <td><?php if(isset($item['height_motion'])) echo($item['height_motion']); ?></td>
                                    <td><?php if(isset($item['sizeMTR'])) echo($item['sizeMTR']); ?></td>
                                    <td><?php if(isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?></td>
                                    <td><?php if(isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?></td>
                                    <td><?php if(isset($item['sumMTR'])) echo($item['sumMTR']); ?></td>
                                    <td><?php if(isset($item['weight_motion'])) echo($item['weight_motion']); ?></td>
                                    <td><?php if(isset($item['total_motion'])) echo($item['total_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateRequest_motion'])) {
                                            if ($item['dateRequest_motion'] == NULL || $item['dateRequest_motion'] == '0000-00-00' || $item['dateRequest_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateRequest_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['infoShipments_motion'])) echo($item['infoShipments_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateShipments_motion'])) {
                                            if ($item['dateShipments_motion'] == NULL || $item['dateShipments_motion'] == '0000-00-00' || $item['dateShipments_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateShipments_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['cargo_motion'])) echo($item['cargo_motion']); ?></td>
                                    <td><?php if(isset($item['shipped_motion'])) echo($item['shipped_motion']); ?></td>
                                    <td><?php if(isset($item['remains_motion'])) echo($item['remains_motion']); ?></td>
                                    <td><?php if(isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?></td>
                                    <td><?php if(isset($item['filialMTR'])) echo($item['filialMTR']); ?></td>
                                    <td><?php if(isset($item['numberOverhead_motion'])) echo($item['numberOverhead_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateOverhead_motion'])) {
                                            if ($item['dateOverhead_motion'] == NULL || $item['dateOverhead_motion'] == '0000-00-00' || $item['dateOverhead_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateOverhead_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?></td>
                                    <td><?php if(isset($item['noteMTR'])) echo($item['noteMTR']); ?></td>
                                    <td><?php if(isset($item['note_motion'])) echo($item['note_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateArrival_motion'])) {
                                            if ($item['dateArrival_motion'] == NULL || $item['dateArrival_motion'] == '0000-00-00' || $item['dateArrival_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateArrival_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['numberM15_motion'])) echo($item['numberM15_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateM15_motion'])) {
                                            if ($item['dateM15_motion'] == NULL || $item['dateM15_motion'] == '0000-00-00' || $item['dateM15_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateM15_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if(isset($item['dateFilial_motion'])) {
                                            if ($item['dateFilial_motion'] == NULL || $item['dateFilial_motion'] == '0000-00-00' || $item['dateFilial_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateFilial_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['recd'])) echo($item['recd']); ?></td>
                                </tr>
                                <?php $n=$n+1; endforeach; ?>
                            </tbody>
                        </table>

                    </form>
                </div>
            </section>
        <?php  } ?>
        <!--Отчет по направлению-->
        <?php if(isset($_POST['button_search_filials'])) { ?>
            <section id="create_motion" class="panel">
                <div class="panel-body">
                    <form method="POST" action="<?=base_url();?>Main/motion">

                        <table id="createMotionMTR" class="display ">
                            <thead>
                            <tr>
                                <th style="width: 50px;">№</th>
                                <th >Код МТР</th>
                                <th >Наименование МТР</th>
                                <th >Номер партии</th>
                                <th >Длина, м</th>
                                <th >Ширина, м</th>
                                <th >Высота, м</th>
                                <th >Ед.изм.</th>
                                <th >Наименование объекта</th>
                                <th >Инвентарный № объекта</th>
                                <th >Кол-во</th>
                                <th >вес 1 ед.</th>
                                <th >Всего</th>
                                <th >Дата заявки на отгрузку</th>
                                <th >Заявка на контейнер/автотранспорт</th>
                                <th >Дата отгрузки</th>
                                <th >Груз сформирован в контейнер/автотранспорт</th>
                                <th >Отгружено</th>
                                <th >Остаток</th>
                                <th >Наименование транзитного* <br/> или конечного получателя груза</th>
                                <th >Наименование филиала получателя</th>
                                <th >Накладная формы М11 № накладной</th>
                                <th >Накладная формы М11 Дата накладной</th>
                                <th >Приоритет(1,2,3)**</th>
                                <th >Примечание по доставке</th>
                                <th >Общие примечания</th>
                                <th >Дата поступления МТР на базу, участок</th>
                                <th >№ накладной М 15</th>
                                <th >Дата накладной М 15</th>
                                <th >Дата получения МТР филиалом получателя</th>
                                <th >Принято, кол-во</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $n=0; foreach($orders as $item): ?>
                                <tr>
                                    <td></td>
                                    <td><?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?></td>
                                    <td><?php if(isset($item['nameMTR'])) echo($item['nameMTR']); ?></td>
                                    <td><?php if(isset($item['numberPart'])) echo($item['numberPart']); ?></td>
                                    <td><?php if(isset($item['length_motion'])) echo($item['length_motion']); ?></td>
                                    <td><?php if(isset($item['width_motion'])) echo($item['width_motion']); ?></td>
                                    <td><?php if(isset($item['height_motion'])) echo($item['height_motion']); ?></td>
                                    <td><?php if(isset($item['sizeMTR'])) echo($item['sizeMTR']); ?></td>
                                    <td><?php if(isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?></td>
                                    <td><?php if(isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?></td>
                                    <td><?php if(isset($item['sumMTR'])) echo($item['sumMTR']); ?></td>
                                    <td><?php if(isset($item['weight_motion'])) echo($item['weight_motion']); ?></td>
                                    <td><?php if(isset($item['total_motion'])) echo($item['total_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateRequest_motion'])) {
                                            if ($item['dateRequest_motion'] == NULL || $item['dateRequest_motion'] == '0000-00-00' || $item['dateRequest_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateRequest_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['infoShipments_motion'])) echo($item['infoShipments_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateShipments_motion'])) {
                                            if ($item['dateShipments_motion'] == NULL || $item['dateShipments_motion'] == '0000-00-00' || $item['dateShipments_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateShipments_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['cargo_motion'])) echo($item['cargo_motion']); ?></td>
                                    <td><?php if(isset($item['shipped_motion'])) echo($item['shipped_motion']); ?></td>
                                    <td><?php if(isset($item['remains_motion'])) echo($item['remains_motion']); ?></td>
                                    <td><?php if(isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?></td>
                                    <td><?php if(isset($item['filialMTR'])) echo($item['filialMTR']); ?></td>
                                    <td><?php if(isset($item['numberOverhead_motion'])) echo($item['numberOverhead_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateOverhead_motion'])) {
                                            if ($item['dateOverhead_motion'] == NULL || $item['dateOverhead_motion'] == '0000-00-00' || $item['dateOverhead_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateOverhead_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?></td>
                                    <td><?php if(isset($item['noteMTR'])) echo($item['noteMTR']); ?></td>
                                    <td><?php if(isset($item['note_motion'])) echo($item['note_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateArrival_motion'])) {
                                            if ($item['dateArrival_motion'] == NULL || $item['dateArrival_motion'] == '0000-00-00' || $item['dateArrival_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateArrival_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['numberM15_motion'])) echo($item['numberM15_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateM15_motion'])) {
                                            if ($item['dateM15_motion'] == NULL || $item['dateM15_motion'] == '0000-00-00' || $item['dateM15_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateM15_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if(isset($item['dateFilial_motion'])) {
                                            if ($item['dateFilial_motion'] == NULL || $item['dateFilial_motion'] == '0000-00-00' || $item['dateFilial_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateFilial_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['recd'])) echo($item['recd']); ?></td>
                                </tr>
                                <?php $n=$n+1; endforeach; ?>
                            </tbody>
                        </table>

                    </form>
                </div>
            </section>
        <?php  } ?>
        <!--Отчет по статусу распоряжений-->
        <?php if(isset($_POST['button_search_status_orders'])) { ?>
            <section id="create_motion" class="panel">
                <div class="panel-body">
                    <form method="POST" action="<?=base_url();?>Main/motion">

                        <table id="createMotionMTR" class="display ">
                            <thead>
                            <tr>
                                <th style="width: 50px;">№</th>
                                <th >Код МТР</th>
                                <th >Наименование МТР</th>
                                <th >Номер партии</th>
                                <th >Длина, м</th>
                                <th >Ширина, м</th>
                                <th >Высота, м</th>
                                <th >Ед.изм.</th>
                                <th >Наименование объекта</th>
                                <th >Инвентарный № объекта</th>
                                <th >Кол-во</th>
                                <th >вес 1 ед.</th>
                                <th >Всего</th>
                                <th >Дата заявки на отгрузку</th>
                                <th >Заявка на контейнер/автотранспорт</th>
                                <th >Дата отгрузки</th>
                                <th >Груз сформирован в контейнер/автотранспорт</th>
                                <th >Отгружено</th>
                                <th >Остаток</th>
                                <th >Наименование транзитного* <br/> или конечного получателя груза</th>
                                <th >Наименование филиала получателя</th>
                                <th >Накладная формы М11 № накладной</th>
                                <th >Накладная формы М11 Дата накладной</th>
                                <th >Приоритет(1,2,3)**</th>
                                <th >Примечание по доставке</th>
                                <th >Общие примечания</th>
                                <th >Дата поступления МТР на базу, участок</th>
                                <th >№ накладной М 15</th>
                                <th >Дата накладной М 15</th>
                                <th >Дата получения МТР филиалом получателя</th>
                                <th >Принято, кол-во</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $n=0; foreach($orders as $item): ?>
                                <tr>
                                    <td></td>
                                    <td><?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?></td>
                                    <td><?php if(isset($item['nameMTR'])) echo($item['nameMTR']); ?></td>
                                    <td><?php if(isset($item['numberPart'])) echo($item['numberPart']); ?></td>
                                    <td><?php if(isset($item['length_motion'])) echo($item['length_motion']); ?></td>
                                    <td><?php if(isset($item['width_motion'])) echo($item['width_motion']); ?></td>
                                    <td><?php if(isset($item['height_motion'])) echo($item['height_motion']); ?></td>
                                    <td><?php if(isset($item['sizeMTR'])) echo($item['sizeMTR']); ?></td>
                                    <td><?php if(isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?></td>
                                    <td><?php if(isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?></td>
                                    <td><?php if(isset($item['sumMTR'])) echo($item['sumMTR']); ?></td>
                                    <td><?php if(isset($item['weight_motion'])) echo($item['weight_motion']); ?></td>
                                    <td><?php if(isset($item['total_motion'])) echo($item['total_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateRequest_motion'])) {
                                            if ($item['dateRequest_motion'] == NULL || $item['dateRequest_motion'] == '0000-00-00' || $item['dateRequest_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateRequest_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['infoShipments_motion'])) echo($item['infoShipments_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateShipments_motion'])) {
                                            if ($item['dateShipments_motion'] == NULL || $item['dateShipments_motion'] == '0000-00-00' || $item['dateShipments_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateShipments_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['cargo_motion'])) echo($item['cargo_motion']); ?></td>
                                    <td><?php if(isset($item['shipped_motion'])) echo($item['shipped_motion']); ?></td>
                                    <td><?php if(isset($item['remains_motion'])) echo($item['remains_motion']); ?></td>
                                    <td><?php if(isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?></td>
                                    <td><?php if(isset($item['filialMTR'])) echo($item['filialMTR']); ?></td>
                                    <td><?php if(isset($item['numberOverhead_motion'])) echo($item['numberOverhead_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateOverhead_motion'])) {
                                            if ($item['dateOverhead_motion'] == NULL || $item['dateOverhead_motion'] == '0000-00-00' || $item['dateOverhead_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateOverhead_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?></td>
                                    <td><?php if(isset($item['noteMTR'])) echo($item['noteMTR']); ?></td>
                                    <td><?php if(isset($item['note_motion'])) echo($item['note_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateArrival_motion'])) {
                                            if ($item['dateArrival_motion'] == NULL || $item['dateArrival_motion'] == '0000-00-00' || $item['dateArrival_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateArrival_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['numberM15_motion'])) echo($item['numberM15_motion']); ?></td>
                                    <td>
                                        <?php if(isset($item['dateM15_motion'])) {
                                            if ($item['dateM15_motion'] == NULL || $item['dateM15_motion'] == '0000-00-00' || $item['dateM15_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateM15_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if(isset($item['dateFilial_motion'])) {
                                            if ($item['dateFilial_motion'] == NULL || $item['dateFilial_motion'] == '0000-00-00' || $item['dateFilial_motion'] == '1970-01-01') {
                                                echo('-');
                                            } else {
                                                echo(date('d-m-Y', strtotime($item['dateFilial_motion']))); }
                                        }
                                        ?>
                                    </td>
                                    <td><?php if(isset($item['recd'])) echo($item['recd']); ?></td>
                                </tr>
                                <?php $n=$n+1; endforeach; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </section>
        <?php  } ?>
    </section>
</section>

<script src="<?=base_url();?>assets/order/jquery-3.3.1.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/reports/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/reports/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/reports/jszip.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/reports/pdfmake.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/reports/vfs_fonts.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/reports/buttons.print.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/reports/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url();?>assets/vendor/datepicker/locales/bootstrap-datepicker.ru.min.js" charset="UTF-8"></script>
<script>

    $(document).ready(function() {
        /*Таблица*/
        var table = $('#createMotionMTR').DataTable({
            "scrollX": true,

            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],

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

        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
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

    function createUUID() {
        var s = [];
        var hexDigits = "0123456789ABCDEF";
        for (var i = 0; i < 32; i++) {
            s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1);
        }
        s[12] = "4";  // bits 12-15 of the time_hi_and_version field to 0010
        s[16] = hexDigits.substr((s[16] & 0x3) | 0x8, 1);  // bits 6-7 of the clock_seq_hi_and_reserved to 01

        var uuid = s.join("");
        return uuid;
    }

    //Экспорт в Excel
    function ExportXls(id){
        var id_bond_order_mtr = id.getAttribute('data-id_motion');
        var id_button_name_mtr = id.getAttribute('data-id_button_name_mtr');
        var id_button_search_mtr = id.getAttribute('data-id_button_search_mtr');
        var checkbox_order_id = document.getElementById('checkboxOrder');

        if (checkbox_order_id.checked) {
            var checkbox_Order = [];
            $('.checkboxOrder:checked').each(function () {
                checkbox_Order.push($(this).val());
            });
            console.log('----------');
            console.log(checkbox_Order[0]);
            console.log('----------');
        } else {
            console.log('checkbox не выбран');
        }


        console.log("Export XSL");
        console.log(id_bond_order_mtr);
        var guid = createUUID();
        console.log(guid);

        $.ajax({
            url: "<?=base_url();?>Main/export_select_Motion",
            type: "POST",
            data: {
                   id_bond_order_mtr : id_bond_order_mtr,
                   guid : guid,
                   id_button_name_mtr : id_button_name_mtr,
                   id_button_search_mtr : id_button_search_mtr,
                   checkbox_Order: checkbox_Order
            },
            success: function(data){
                console.log(data);
                    var link = document.createElement('a');
                    link.setAttribute('href', '<?=base_url();?>'+guid+'.xlsx');
                    link.click();
                    return false;
            }
        })

    }

</script>
