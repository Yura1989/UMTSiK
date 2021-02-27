<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?=base_url();?>assets/order/favicon.png" type="image/png">

    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/bootstrap-4.2.1/css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/bootAdmin/css/fontawesome-all.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/bootAdmin/css/bootadmin.css" >
<!--    <link rel="stylesheet" href="--><?//=base_url();?><!--assets/vendor/stylesheets/theme_table.css" />-->
<!--    <link rel="stylesheet" type="text/css" href="--><?//=base_url();?><!--assets/order/dataTables/dataTables.bootstrap4.min.css" >-->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
<!--    <link rel="stylesheet" type="text/css" href="--><?//=base_url();?><!--assets/order/dataTables/fixedHeader.dataTables.min.css" >-->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/datepicker4/css/gijgo.min.css" />

    <title>АПД МТР</title>
</head>
<body class="bg-light">

<!--Header-->
<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Информации о движении МТР на базе (заполняется участками)</a>
    <div>
    <?php
    $_username = $this->session->userdata('username');
    $_actions = $this->session->userdata('actions');
    if (isset ($_username) && (($_actions['filial_edit_motion']) == 1) ) { ?>
        <?php if ((($info_motion[0]['flag_motion']) == '20') || (($info_motion[0]['flag_motion']) == '10')) { ?>
            <button id="editToTable" onclick="endGameMotion();" type="button" class="ButtonEndGameToTable btn btn-success">Завершить <i class="fa fa-pencil"></i></button>
        <?php } ?>
    <?php } ?>
    </div>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            <button id="cancelToEditOrder" onclick="ExitEditMotion();" type="button" class="ButtonExitEditMotion btn btn-outline-warning">Выход <i class="fa fa-undo"></i></button>
            <li class="nav-item dropdown">
                <a href="#" id="dd_user" class="nav-link" ><i class="fa fa-user"></i> <?php echo $this->session->userdata('username'); ?></a>
            </li>
        </ul>
    </div>
</nav>
<!--create Motion-->
<section>
    <div class="d-flex">
        <div class="content p-4">
            <div class="card mb-4">
                <div class="card-header bg-white font-weight-bold">
                    <h2 class="guid_motion id_motion" data-gid_motion="<?php foreach($info_motion as $item_motion): ?><?php if(isset($item_motion['number_motion'])) { echo($item_motion['number_motion']); } ?>"<?php endforeach ?> data-id_motion="<?php foreach($info_motion as $item_motion): ?><?php if(isset($item_motion['id_all_motion'])) { echo($item_motion['id_all_motion']); } ?>"<?php endforeach ?> >Информация о движении МТР на базе</h2>
                </div>
                <div class="card-body">
                    <p>
                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Сформированна на основании:
                        </a>
                    </p>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <ul>
                                <?php foreach($info_orders as $item_orders): ?>
                                    <li class="id_number_orders" data-id_order="<?php echo($item_orders['id_all_orders']); ?>">Распоряжения № <?php echo($item_orders['number_order']); ?> от <?php echo($item_orders['date_order']); ?> </li>
                                <?php endforeach; ?>
                            </ul>
                            <label for="author_order">Исполнитель</label>
                            <?php foreach($info_motion as $item_author): ?>
                                <input type="text" class="form-control" id="author_order" name="author_order"  disabled
                                       value="<?php if(isset($item_author['author_motion'])) { echo($item_author['author_motion']); } ?>"
                                >
                            <?php endforeach ?>
                        </div>
                    </div>
                        <!--                    Кнопки управления при изменении данных в БД-->
                        <?php
                        $_username = $this->session->userdata('username');
                        $_actions = $this->session->userdata('actions');
                        if (isset ($_username) && (($_actions['filial_edit_motion']) == 1) ) { ?>
                            <button id="saveToEditOrder" style="display: none" onclick="saveEditAreaMotion();" type="button" class="ButtonSaveEditToTable btn btn-outline-success">Сохранить изменения <i class="fa fa-save"></i></button>
                            <button id="cancelToEditOrder" style="display: none" onclick="cancelEditMotion();" type="button" class="ButtonCancelEditMotion btn btn-outline-warning">Отмена <i class="fa fa-undo"></i></button>
                            <button id="editToTable" onclick="editMotion();" type="button" class="ButtonEditToTable btn btn-outline-primary">Изменить <i class="fa fa-pencil"></i></button>
                        <?php } ?>
                        <?php if (isset ($_username) && ((($_actions['edit_motion']) == 1) || (($_actions['show_motion']) == 1)) ) { ?>
                            <button type="button" onclick="ExportXls();" class="btn btn-info ButtonExportXLS">Экспорт в Excel</button>
                        <?php } ?>
                </div>
            </div>

            <!--------------------------------------------------------------------->
            <?php $n=0; foreach($order as $item): ?>
                <div class="card mb-4">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="alert-success card-header font-weight-bold" id="heading<?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?>">
                                <a href="#" data-toggle="collapse" data-target="#collapse<?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?>" aria-expanded="false" aria-controls="collapse<?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?>" class="collapsed">
                                    <div class="row">
                                        <div class="col text-primary">
                                           Наименование МТР - <input type="text" class="id_order_mtr_class" data-id_order_mtr="<?php if(isset($item['id_order'])) echo($item['id_order']); ?>" disabled style="width: 30%;"
                                                                            value="<?php if(isset($item['nameMTR'])) echo($item['nameMTR']); ?>"
                                           >
                                           Кол-во <input type="text" class="sum_mtr" disabled
                                                          data-sum_mtr="<?php if(isset($item['sumMTR'])) echo($item['sumMTR']); ?>"
                                                          value="<?php if(isset($item['sumMTR'])) echo($item['sumMTR']); ?>"
                                           >
                                        </div>
                                        <div class="col-auto collapse-icon"></div>
                                    </div>
                                </a>
                            </div>
                            <div id="collapse<?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?>" class="collapse" aria-labelledby="heading<?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?>" data-parent="#accordionExample" style="">
                                <div class="card-body">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td>Код МТР
                                            </td>
                                            <td><input type="text" class="code_mtr_class " disabled
                                                       value="<?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?>"
                                                >
                                            </td>
                                            <td>Номер партии
                                            </td>
                                            <td><input type="text" class="numberPart" disabled
                                                       value="<?php if(isset($item['numberPart'])) echo($item['numberPart']); ?>"
                                                >
                                            </td>
                                            <td>Ед.изм.
                                            </td>
                                            <td><input type="text" class="sizeMTR " id="sizeMTR"  disabled
                                                       value="<?php if(isset($item['sizeMTR'])) echo($item['sizeMTR']); ?>"
                                                >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Инвентарный № объекта
                                            </td>
                                            <td><input type="text" class="numberObjectMTR" id="numberObjectMTR"  disabled
                                                       value="<?php if(isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?>"
                                                >
                                            </td>
                                            <td>Наименование транзитного* или конечного получателя груза
                                            </td>
                                            <td><input type="text" class="address_orderMTR" id="address_orderMTR"  disabled
                                                       value="<?php if(isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?>"
                                                >
                                            </td>
                                            <td>Наименование филиала получателя
                                            </td>
                                            <td><input type="text" class="filialMTR" id="filialMTR"  disabled
                                                       value="<?php if(isset($item['filialMTR'])) echo($item['filialMTR']); ?>"
                                                >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Приоритет(1,2,3)**
                                            </td>
                                            <td><input type="text" class="deliveryMTR" id="deliveryMTR"  disabled
                                                       value="<?php if(isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?>"
                                                >
                                            </td>
                                            <td>Примечание по доставке
                                            </td>
                                            <td><input type="text" class="noteMTR" id="noteMTR"  disabled
                                                       value="<?php if(isset($item['noteMTR'])) echo($item['noteMTR']); ?>"
                                                >
                                            </td>
                                            <td>Наименование объекта
                                            </td>
                                            <td><input type="text" class="ukObjectMTR" id="ukObjectMTR"  disabled
                                                       value="<?php if(isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?>"
                                                >
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                    <table class="motion_table table compact table-bordered table-hover table-sm" style="width:100%">
                        <thead>
                        <tr class="text-center" style="font-size: 8pt;" >
                            <th colspan="5" rowspan="1" style="font-size: 8pt;">Заполняется транзитным участком, базой ЮУМТСиК</th>
                            <th colspan="3" rowspan="1" style="width: 15%" data-toggle="tooltip" data-placement="left" data-html="true"
                                data-original-title="Указывается представителем базы или участка погрузочно-разгрузочных работ по запросу перевозчика">
                                Массогабаритные характеристики***
                            </th>
                            <th rowspan="2">Вес 1 ед. тн.</th>
                            <th rowspan="2">Всего тн.</th>
                            <th rowspan="2">Груз сформирован в контейнер/автотранспорт</th>
                            <th rowspan="2">Дата заявки на отгрузку</th>
                            <th rowspan="2">Дата отгрузки</th>
                            <th rowspan="2">Информация об отгрузке на текущую дату</th>
                            <th rowspan="2">Отгружено</th>
                            <th rowspan="2">Остаток</th>
                            <th colspan="2" rowspan="1" >Накладная формы М11</th>
                            <th rowspan="2">Общие примечания</th>
                        </tr>
                        <tr class="text-center" style="font-size: 8pt;">
                            <th data-align="center" style="">Дата поступления МТР на базу, участок</th>
                            <th data-align="center" style="">№ накладной М 15</th>
                            <th data-align="center" style="">Дата накладной М 15</th>
                            <th data-align="center" style="">Дата получения МТР филиалом получателя</th>
                            <th data-align="center" style="">Принято, кол-во</th>
                            <th data-align="center">Длина, м</th>
                            <th data-align="center">Ширина, м</th>
                            <th data-align="center">Высота, м</th>
                            <th data-align="center">№ накладной</th>
                            <th data-align="center">Дата накладной</th>

                        </tr>
                        <tr class="text-center" style="font-size: 8pt; background: cornsilk">
                            <th style="background: rgba(149,255,0,0.37">1</th>
                            <th style="background: rgba(149,255,0,0.37">2</th>
                            <th style="background: rgba(149,255,0,0.37">3</th>
                            <th style="background: rgba(149,255,0,0.37">4</th>
                            <th style="background: rgba(149,255,0,0.37">5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>10</th>
                            <th>11</th>
                            <th>12</th>
                            <th>13</th>
                            <th>14</th>
                            <th>15</th>
                            <th>16</th>
                            <th>17</th>
                            <th>18</th>
                            <th>19</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orders as $value ):
                        if ( (($value['id_bond_order_mtr']) == ($item['id_order'])) ) { ?>
                        <tr>
<!--Информация заполняемая участками-->
                            <td><input style="font-size: 9pt;" name="dateArrival_motion[]" type="text" class="dateArrival_motion form-control date_order_id" disabled autocomplete="off" value="<?php if($value['dateArrival_motion'] == NULL || $value['dateArrival_motion'] == '0000-00-00' || $value['dateArrival_motion'] == '1970-01-01') { echo('-');  } else { echo(date('d-m-Y', strtotime($value['dateArrival_motion']))); }?>"></td>
                            <td>
                                <input style="font-size: 9pt;"
                                       name="numberM15_motion[]"
                                       type="text"
                                       class="numberM15_motion form-control input-block"
                                       disabled
                                       value="<?php if(isset($value['numberM15_motion'])) echo($value['numberM15_motion']); ?>"
                                >
                            </td>
                            <td>
                                <input style="font-size: 9pt;"
                                       name="dateM15_motion[]"
                                       type="text"
                                       class="dateM15_motion form-control input-block date_order_id"
                                       disabled
                                       autocomplete="off"
                                       value="<?php if($value['dateM15_motion'] == NULL || $value['dateM15_motion'] == '0000-00-00' || $value['dateM15_motion'] == '1970-01-01') { echo('-');  } else { echo(date('d-m-Y', strtotime($value['dateM15_motion']))); }?>"
                                >
                            </td>
                            <td><input style="font-size: 9pt;" name="dateFilial_motion[]" type="text" class="dateFilial_motion form-control date_order_id" disabled autocomplete="off" value="<?php if($value['dateFilial_motion'] == NULL || $value['dateFilial_motion'] == '0000-00-00' || $value['dateFilial_motion'] == '1970-01-01') { echo('-');  } else { echo(date('d-m-Y', strtotime($value['dateFilial_motion']))); }?>"></td>
                            <td><input style="font-size: 9pt;"
                                       name="recd[]"
                                       type="text"
                                       class="recd form-control input-block"
                                       disabled
                                       value="<?php if(isset($value['recd'])) echo($value['recd']); ?>"
                                ></td>
<!--Информация заполненная складами-->
                            <td><input style="font-size: 9pt;" name="length_motion[]" type="text" class="length_motion form-control input-block" disabled value="<?php if(isset($value['length_motion'])) echo($value['length_motion']); ?>">
                            </td>
                            <td><input style="font-size: 9pt;" name="width_motion[]" type="text" class="width_motion form-control input-block" disabled value="<?php if(isset($value['width_motion'])) echo($value['width_motion']); ?>"></td>
                            <td><input style="font-size: 9pt;" name="height_motion[]" type="text" class="height_motion form-control input-block" disabled value="<?php if(isset($value['height_motion'])) echo($value['height_motion']); ?>"></td>
                            <td><input style="font-size: 9pt;" name="weight_motion[]" type="text" class="weight_motion form-control input-block" disabled value="<?php if(isset($value['weight_motion'])) echo($value['weight_motion']); ?>"></td>
                            <td><input style="font-size: 9pt;" name="total_motion[]" type="text" class="total_motion form-control input-block" disabled value="<?php if(isset($value['total_motion'])) echo($value['total_motion']); ?>"></td>
                            <td><input style="font-size: 9pt;" name="cargo_motion[]" type="text" class="cargo_motion form-control input-block" disabled
                                       value="<?php if(isset($value['cargo_motion'])) echo($value['cargo_motion']); ?>"
                                       data-sum_mtr="<?php if(isset($value['sumMTR'])) echo($value['sumMTR']); ?>"
                                       data-id_order_mtr="<?php if(isset($value['id_order'])) echo($value['id_order']); ?>"
                                       data-id_motion="<?php if(isset($value['id_motion'])) echo($value['id_motion']); ?>"
                                >
                            </td>
                            <td><input style="font-size: 9pt;" name="dateRequest_motion[]" type="text" class="dateRequest_motion form-control date_order_id" autocomplete="off" disabled value="  <?php if($value['dateRequest_motion'] == NULL || $value['dateRequest_motion'] == '0000-00-00' || $value['dateRequest_motion'] == '1970-01-01') { echo('-');  } else { echo(date('d-m-Y', strtotime($value['dateRequest_motion']))); }?>"></td>
                            <td><input style="font-size: 9pt;" name="dateShipments_motion[]" type="text" class="dateShipments_motion form-control date_order_id" autocomplete="off" disabled value="  <?php if($value['dateShipments_motion'] == NULL || $value['dateShipments_motion'] == '0000-00-00' || $value['dateShipments_motion'] == '1970-01-01') { echo('-');  } else { echo(date('d-m-Y', strtotime($value['dateShipments_motion']))); }?>"></td>
                            <td><input style="font-size: 9pt;" name="infoShipments_motion[]" type="text" class="infoShipments_motion form-control input-block" disabled value="<?php if(isset($value['infoShipments_motion'])) echo($value['infoShipments_motion']); ?>"></td>
                            <td><input style="font-size: 9pt;" name="shipped_motion[]" type="text" class="shipped_motion form-control input-block" data-class_mtr="<?php if(isset($value['codeMTR'])) echo($value['codeMTR']); ?>" disabled value="<?php if(isset($value['shipped_motion'])) echo($value['shipped_motion']); ?>"></td>
                            <td><input style="font-size: 9pt;" name="remains_motion[]" type="text" class="remains_motion form-control input-block" disabled value="<?php if(isset($value['remains_motion'])) echo($value['remains_motion']); ?>"></td>
                            <td><input style="font-size: 9pt;" name="numberOverhead_motion[]" type="text" class="numberOverhead_motion form-control input-block" disabled  value="<?php if(isset($value['numberOverhead_motion'])) echo($value['numberOverhead_motion']); ?>"></td>
                            <td><input style="font-size: 9pt;" name="dateOverhead_motion[]" type="text" class="dateOverhead_motion form-control input-block date_order_id" autocomplete="off" disabled value=" <?php if($value['dateOverhead_motion'] == NULL || $value['dateOverhead_motion'] == '0000-00-00' || $value['dateOverhead_motion'] == '1970-01-01') { echo('-');  } else { echo(date('d-m-Y', strtotime($value['dateOverhead_motion']))); }?>"></td>
                            <td><textarea style="width:100%; height:30px; font-size: 9pt;" name="note_motion[]" class="form-control note_motion" disabled><?php if(isset($value['note_motion'])) echo($value['note_motion']); ?></textarea></td>
                        </tr>
                        <?php } ?>
                            <?php  endforeach; ?>
                        </tbody>
                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php  $n=$n+1; endforeach; ?>
            <!--------------------------------------------------------------------->

            <div class="card-footer ">
                <div class="row">
                    <div class="col-sm-6">
                        <!--                    Кнопки управления при изменении данных в БД-->
                        <?php
                        $_username = $this->session->userdata('username');
                        $_actions = $this->session->userdata('actions');
                        if (isset ($_username) && (($_actions['filial_edit_motion']) == 1) ) { ?>
                            <button id="saveToEditOrder" style="display: none" onclick="saveEditAreaMotion();" type="button" class="ButtonSaveEditToTable btn btn-outline-success">Сохранить изменения <i class="fa fa-save"></i></button>
                            <button id="cancelToEditOrder" style="display: none" onclick="cancelEditMotion();" type="button" class="ButtonCancelEditMotion btn btn-outline-warning">Отмена <i class="fa fa-undo"></i></button>
                            <button id="editToTable" onclick="editMotion();" type="button" class="ButtonEditToTable btn btn-outline-primary">Изменить <i class="fa fa-pencil"></i></button>
                        <?php } ?>
                        <?php if (isset ($_username) && ((($_actions['filial_edit_motion']) == 1) || (($_actions['show_motion']) == 1)) ) { ?>

                            <button type="button" onclick="ExportXls();" class="btn btn-info ButtonExportXLS">Экспорт в Excel</button>
                        <?php } ?>
                    </div>
                </div
            </div>
        </div>
    </div>
</section>
<!-- end: create Motion -->

<!--Модуль добавления строки-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Добавление контейнера/автотранспорта</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Заполните ниже поля и нажмите "Добавить"</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" onclick="addString(this);" class="btn btn-primary" data-dismiss="modal">Добавить</button>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url();?>assets/order/jquery-3.3.1.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/bootstrap-4.2.1/js/bootstrap.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/datepicker4/js/gijgo.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/datepicker4/js/messages/messages.ru-ru.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/bootAdmin/js/bootstrap.bundle.min.js" type="text/javascript"> </script>
<script src="<?=base_url();?>assets/order/bootAdmin/js/bootadmin.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/dataTables.fixedColumns.min.js" type="text/javascript"></script>

</body>
</html>

<script>
    $(document).ready(function() {
//Настройки таблицы
        var table = $('table.motion_table').DataTable({
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
            "scrollX": true,
            "searching": false,
            "paging":    false,
//            "ordering":  false,
//            "info":      false,
            "ordering": false,
            "info":     false,
            columnDefs: [ {
                sortable: false,
                "class": "index",
                targets: 0
            } ]
        });

//Вывод даты
        date_row();
    });

//Добавление строки 2
    function add_row_new(id){
        var id_row_table = id.dataset.number_table;
        var table = $('.motion_table').DataTable();
        var row_data = [];
        $(id).closest('tr').find('td').each(function () {
            row_data.push($(this).html());
        });
        var sum_mtr = id.dataset.sum_mtr;
        var id_order_mtr = id.dataset.id_order_mtr;
        var id_motion = id.dataset.id_motion;
        console.log(sum_mtr);
        console.log(id_order_mtr);
        console.log(id_motion);

        var arr0 = '<input style="font-size: 9pt;" name="length_motion[]" type="text" class="length_motion form-control input-block"  value="">';
        var arr1 = '<input style="font-size: 9pt;" name="width_motion[]" type="text" class="width_motion form-control input-block" value="">';
        var arr2 = '<input style="font-size: 9pt;" name="height_motion[]" type="text" class="height_motion form-control input-block" value="">';
        var arr3 = '<input style="font-size: 9pt;" name="weight_motion[]" type="text" class="weight_motion form-control input-block" value="">';
        var arr4 = '<input style="font-size: 9pt;" name="total_motion[]" type="text" class="total_motion form-control input-block" value="">';
        var arr5 = '<input style="font-size: 9pt;" name="cargo_motion[]" data-sum_mtr="' + sum_mtr + '" data-id_order_mtr="' + id_order_mtr + '" type="text" class="cargo_motion form-control input-block" value="">';
        var arr6 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateRequest_motion[]" type="text" class="dateRequest_motion form-control date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr7 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateShipments_motion[]" type="text" class="dateShipments_motion form-control date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr8 = '<input style="font-size: 9pt;" name="infoShipments_motion[]" type="text" class="infoShipments_motion form-control input-block" value="">';
        var arr9 = '<input style="font-size: 9pt;" name="shipped_motion[]" type="text" class="shipped_motion form-control input-block" value="">';
        var arr10 = '<input style="font-size: 9pt;" name="remains_motion[]" type="text" class="remains_motion form-control input-block" value="">';
        var arr11 = '<input style="font-size: 9pt;" name="numberOverhead_motion[]" type="text" class="numberOverhead_motion form-control input-block" value="">';
        var arr12 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateOverhead_motion[]" type="text" class="dateOverhead_motion form-control input-block date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr13 = '<textarea style="width:100%; height:30px; font-size: 9pt;" name="note_motion[]" class="form-control note_motion" ></textarea>';
        var arr14 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateArrival_motion[]" type="text" class="dateArrival_motion form-control date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr15 = '<input style="font-size: 9pt;" name="numberM15_motion[]" type="text" class="numberM15_motion form-control input-block" value="">';
        var arr16 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateM15_motion[]" type="text" class="dateM15_motion form-control input-block date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr17 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateFilial_motion[]" type="text" class="dateFilial_motion form-control date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
//        var f = $(row_data);
//        delete row_data[12];
//        console.log(row_data);
        row_data.splice(0, 1, arr0);
        row_data.splice(1, 1, arr1);
        row_data.splice(2, 1, arr2);
        row_data.splice(3, 1, arr3);
        row_data.splice(4, 1, arr4);
        row_data.splice(5, 1, arr5);
        row_data.splice(6, 1, arr6);
        row_data.splice(7, 1, arr7);
        row_data.splice(8, 1, arr8);
        row_data.splice(9, 1, arr9);
        row_data.splice(10, 1, arr10);
        row_data.splice(11, 1, arr11);
        row_data.splice(12, 1, arr12);
        row_data.splice(13, 1, arr13);
        row_data.splice(14, 1, arr14);
        row_data.splice(15, 1, arr15);
        row_data.splice(16, 1, arr16);
        row_data.splice(17, 1, arr17);

        table.eq(id_row_table).row.add(row_data).draw(true);
        //Вывод даты
        date_row();
    }

//Вывод даты
    function date_row(){
        $('.date_order_id').each(function(){
            $(this).datepicker({
                // uiLibrary: 'bootstrap',
                locale: 'ru-ru',
                format: 'dd-mm-yyyy'
            });
        });
    }

//Валидация форм
    function validation_form() {
        var arr = []; //Счетчик ошибок при заполнении формы
//Валидация Примечания
        var length_codeMTR = document.getElementsByClassName('cargo_motion').length;
        var a = 0; //счетчик строк
        var b = 0; //счетчик МТР
        var n_sumMTR = document.getElementsByClassName("sum_mtr"); //собираем всю инфу с элемента с классом sum_mtr
        var length_sum_mtr = document.getElementsByClassName('sum_mtr').length; //общее кол-во строк МТР
        console.log('mtr-'+length_sum_mtr);
        console.log('row-'+length_codeMTR);
        var shipped_motion_class = $('.shipped_motion');
//        while (b < length_sum_mtr) {
//            var code_mtr = document.getElementsByClassName('code_mtr_class')[b].value;
//            console.log('code_mtr-'+code_mtr);
//            if()
//            b++;
//        }
        while (a < length_codeMTR) {

            var sumMTR = Number(n_sumMTR[a].dataset.sum_mtr);                                           //общее кол-во необходимого отгрузить
            var shipped_motion = Number(document.getElementsByClassName('shipped_motion')[a].value);    //кол-во которое отгружаем
            console.log(sumMTR);
            console.log(shipped_motion);

            if (sumMTR >= shipped_motion) {
                shipped_motion_class.eq(a).removeClass('is-invalid');
                shipped_motion_class.eq(a).addClass('is-valid');
                arr[arr.length] = 1;
            } else {
                shipped_motion_class.eq(a).removeClass('is-valid');
                shipped_motion_class.eq(a).addClass('is-invalid');
                arr[arr.length] = 0;
            }
            a++;
        }

//Итоги валидации
//        console.log(arr);
        var search = arr.indexOf(0);
        if (search == -1){
//            console.log("Good");
            return 1;
        } else {
//            console.log("Bad");
            return 0;
        }
    }


//Сохранение изменения распоряжения с занесением в базу
    function saveEditAreaMotion() {
//        var check_validation = validation_form();
        check_validation = 1;
        if (check_validation == 1 ){
            if (confirm ("Вы точно хотите сохранить внесенные изменения ?")) {
/*Show and Hide кнопок управления*/
                $('.ButtonSaveEditToTable').hide();
                $('.ButtonCancelEditMotion').hide();
                $('.ButtonEditToTable').show();
                $('.ButtonExportXLS').show();
                $('.ButtonExitEditMotion').show();
                $('.ButtonEndGameToTable').show();

/*Show and Hide input table*/
                $(".dateArrival_motion").prop("disabled", true);
                $(".numberM15_motion").prop("disabled", true);
                $(".dateM15_motion").prop("disabled", true);
                $(".dateFilial_motion").prop("disabled", true);
                $(".recd").prop("disabled", true);

/*формирование запроса к базам*/
                var id_motion_class = document.getElementsByClassName("id_motion");
                var id_motion = id_motion_class[0].dataset.id_motion;   // id из таблицы all_motion
                var gid_motion = id_motion_class[0].dataset.gid_motion; // guid из таблицы all_motion
//GUID для строки внутри отчета "информаиця о движении МТР"
                var id_bond_guid_motion_date = document.getElementsByClassName("code_mtr_class");
                var guid_bond_guid_motion_date = id_bond_guid_motion_date[0].dataset.bond_guid_motion_date; //GUID строки для удобства следующего поиска
                var m = 0;
/*формирование запроса к базе motion*/
                        var n = document.getElementsByClassName("cargo_motion");            //собираем всю информацию по элементу
                        var number_codeMTR = document.getElementsByClassName('cargo_motion').length; //считаем кол-во строк для добавления(изменения) в таблицы motion
                        while (m < number_codeMTR) {
                            var dateArrival_motion = document.getElementsByClassName('dateArrival_motion')[m].value;
                            var numberM15_motion = document.getElementsByClassName('numberM15_motion')[m].value;
                            var dateM15_motion = document.getElementsByClassName('dateM15_motion')[m].value;
                            var dateFilial_motion = document.getElementsByClassName('dateFilial_motion')[m].value;
                            var recd = document.getElementsByClassName('recd')[m].value;
                            var n_id_order = document.getElementsByClassName("id_number_orders");
                            var id_order = n_id_order[0].dataset.id_order;        //id распоряжения из таблицы all_orders
                            var number_id_order_mtr = n[m].dataset.id_order_mtr;  //id mtr из таблицы order_mtr
                            var number_id_motion = n[m].dataset.id_motion;        //id_motion из таблицы motion каждой строки
                            $.ajax({
                                url: "<?=base_url();?>Main/save_area_edit_motion",
                                type: "POST",
                                data: {
                                    dateArrival_motion: dateArrival_motion,
                                    numberM15_motion: numberM15_motion,
                                    dateM15_motion: dateM15_motion,
                                    dateFilial_motion: dateFilial_motion,
                                    recd: recd,
                                    
                                    number_id_motion: number_id_motion,
                                    number_id_order_mtr: number_id_order_mtr,
                                    id_motion : id_motion,
                                    gid_motion : gid_motion,
                                    id_order : id_order,
                                    guid_bond_guid_motion_date: guid_bond_guid_motion_date
                                },
                                success: function (data) {
                                    console.log(data);
                                    window.location = "<?=base_url();?>Main/filial_edit_motion?id_motion=" + id_motion;
                                }
                            });
                            m++;
                        }
            }
        } else {
            alert("Обнаружены ошибки при сохранении формы, исправте ошибки и попробуйте снова");
        }
    }
    
    
//Отмена последних изменений выход из режима редактирования информации о движении МТР
    function cancelEditMotion(){
//GUID всего отчета "информаиця о движении МТР"
        var id_guid = document.getElementsByClassName("guid_motion");
        var guid = id_guid[0].dataset.id_motion;
        console.log(guid);
        window.location = "<?=base_url();?>Main/filial_edit_motion?id_motion=" + guid;
    }

//Отмена последних изменений выход из режима редактирования информации о движении МТР
    function ExitEditMotion(){
        window.location ="<?=base_url();?>Main/show_edit_filial_motion";
    }

//Экспорт в Excel
    function ExportXls(){
        var id_motion = document.getElementsByClassName("id_motion");
        var id_motion = id_motion[0].dataset.id_motion;
        console.log("Export XSL");
        console.log(id_motion);

        $.ajax({
            url: "<?=base_url();?>Main/export_Motion",
            type: "POST",
            data: {id_motion : id_motion},
            success: function(data){
                window.location ="<?=base_url();?>Main/export_Motion?id_motion="+id_motion;
            }
        })
    }

//Режим редактирования распоряжения
    function editMotion(){
        /*Show and Hide кнопок управления*/
        $('.ButtonEditToTable').hide();
        $('.ButtonSaveEditToTable').show();
        $('.ButtonCancelEditMotion').show();

        $('.ButtonExportXLS').hide();
        $('.ButtonExitEditMotion').hide();
        $('.ButtonEndGameToTable').hide();

        /*Show and Hide input table*/
        $(".form-check-input").prop("disabled", false);

        $(".dateArrival_motion").prop("disabled", false);
        $(".numberM15_motion").prop("disabled", false);
        $(".dateM15_motion").prop("disabled", false);
        $(".dateFilial_motion").prop("disabled", false);
        $(".recd").prop("disabled", false);

    }

//Завершающий этап по формированию движения по МТР
    function endGameMotion(){
        var n_id_motion = document.getElementsByClassName("id_motion");
        var id_motion = n_id_motion[0].dataset.id_motion;                               // id отчета из таблицы all_motion
        var n = document.getElementsByClassName("cargo_motion");
        var n_id_order = document.getElementsByClassName("id_number_orders");
        var id_order = n_id_order[0].dataset.id_order;                                  // id распоряжения из таблицы all_orders
        var number_codeMTR = document.getElementsByClassName('cargo_motion').length;
        var m = 0;
        while (m < number_codeMTR) {
            var number_id_order_mtr = n[m].dataset.id_motion;                           // id каждой строки из таблицы motion
            $.ajax({
                url: "<?=base_url();?>Main/finishMotion",
                type: "POST",
                data: {
                    id_motion : id_motion,
                    number_id_order_mtr : number_id_order_mtr,
                    id_order : id_order
                },
                success: function(data) {
                    console.log(data);
                    window.location = "<?=base_url();?>Main/filial_edit_motion?id_motion=" + id_motion;
                    alert("Работа с данным распоряжением закончена");
                }
            });
            m++;
        }
    }
</script>