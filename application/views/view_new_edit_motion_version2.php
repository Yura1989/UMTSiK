<!doctype html>
<html lang="ru">
<head>
    <title>МТР</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?=base_url();?>assets/order/favicon.png" type="image/png">
    <link rel="stylesheet" href="<?=base_url();?>vendor/bootstrap5/css/bootstrap.css">
    <link rel="stylesheet" href="<?=base_url();?>blocks/motion/motion.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/datepicker4/css/gijgo.min.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/fixedHeader.dataTables.min.css" >
    <link rel="stylesheet" href="<?=base_url();?>blocks/motion/motion.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/vendor/stylesheets/theme_table.css" />
    <script src="<?=base_url();?>vendor/bootstrap5/js/bootstrap.bundle.js" type="text/javascript"></script
    <script src="<?=base_url();?>vendor/bootstrap5/js/bootstrap.js" type="text/javascript"></script

</head>
<body class="bg-light main_yura">
    <header class="header navbar navbar-dark ">
        <div class="header_nav">
            <a class="guid_motion header__subtitle" data-bs-toggle="collapse"
               data-bs-target="#navbarToggleExternalContent" data-gid_motion="<?php foreach ($info_motion

            as $item_motion): ?><?php if (isset($item_motion['number_motion'])) {
                echo($item_motion['number_motion']);
            } ?>"<?php endforeach ?> data-id_motion="<?php foreach ($info_motion

            as $item_motion): ?><?php if (isset($item_motion['id_all_motion'])) {
                echo($item_motion['id_all_motion']);
            } ?>"<?php endforeach ?>
            >Информация о движении МТР на базе </a>
        </div>
        <div class="header_nav">
            <a class="header__button header__subtitle nav-link text-white"
               href="<?= base_url(); ?>Main/motion_add_many?string_check=<?php if (isset($info_orders[0]['id_all_orders'])) {
                   echo($info_orders[0]['id_all_orders']);
               } else {
                   echo($info_orders[0]['id_all_orders']);
               } ?>&guid_motion=<?php foreach ($info_motion

               as $item_motion): ?><?php if (isset($item_motion['number_motion'])) {
                   echo($item_motion['number_motion']);
               } ?>"<?php endforeach ?>" role="button">
            Множественная вставка значений
        </div>

        <div>
            <?php
            $_username = $this->session->userdata('username');
            $_actions = $this->session->userdata('actions');
            if (isset ($_username) && (($_actions['edit_motion']) == 1)) { ?>
                <button id="editToTable" onclick="endGameMotion();" type="button"
                        class="ButtonEndGameToTable btn btn-success">Завершить <i class="fa fa-pencil"></i></button>
            <?php } ?>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
                <button id="cancelToEditOrder" onclick="ExitEditMotion();" type="button"
                        class="ButtonExitEditMotion btn btn-outline-warning">Выход <i class="fa fa-undo"></i></button>
                <li class="nav-item dropdown">
                    <a href="#" id="dd_user" class="nav-link"><i
                                class="fa fa-user"></i> <?php echo $this->session->userdata('username'); ?></a>
                </li>
            </ul>
        </div>
        <!--                    Кнопки управления при изменении данных в БД-->
        <?php
        $_username = $this->session->userdata('username');
        $_actions = $this->session->userdata('actions');
        if (isset ($_username) && (($_actions['edit_motion']) == 1) ) { ?>
            <button id="saveToEditOrder" style="display: none" onclick="saveEditMotion();" type="button" class="ButtonSaveEditToTable btn btn-outline-success">Сохранить изменения <i class="fa fa-save"></i></button>
            <button id="cancelToEditOrder" style="display: none" onclick="cancelEditMotion();" type="button" class="ButtonCancelEditMotion btn btn-outline-warning">Отмена <i class="fa fa-undo"></i></button>
            <button id="editToTable" onclick="editMotion();" type="button" class="ButtonEditToTable btn btn-outline-primary">Изменить <i class="fa fa-pencil"></i></button>
        <?php } ?>
        <?php if (isset ($_username) && ((($_actions['edit_motion']) == 1) || (($_actions['show_motion']) == 1)) ) { ?>
            <button type="button" onclick="ExportXls();" class="btn btn-info ButtonExportXLS">Экспорт в Excel</button>
        <?php } ?>
        <p class="header__title">Приложение № 3</p>
    </header>
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <div class="card border-light ">
                <div class="card-header">
                    <?php foreach ($info_orders as $item_orders): ?>
                        <p class="header__title header__title_black-text id_number_orders"
                           data-id_order="<?php echo($item_orders['id_all_orders']); ?>">Распоряжения
                            № <?php echo($item_orders['number_order']); ?>
                            от <?php echo(date('d-m-Y', strtotime($item_orders['date_order']))); ?> </p>
                    <?php endforeach; ?>
                </div>
                <div class="card-body">
                    <?php foreach($info_motion as $item_author): ?>
                        <p class="card-text">Исполнитель по Распоряжению:
                            <input type="text" class="form-control"
                                id="author_order" name="author_order"
                                disabled
                                value="<?php if (isset($item_author['author_motion'])) {
                                echo($item_author['author_motion']);
                                } ?>"
                            >
                        </p>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>

<!--create Motion-->
<section>
   <div class="">
       <?php $n = 0; $accordion_flag = 0; foreach ($order as $item): ?>
                    <table id="createMotion" class="motion_table table table-sm table-primary table-hover table-motion">
                                    <thead class="table-light">
                                    <tr class="text-center">
                                        <th rowspan="2">#</th>
                                        <th rowspan="2">МТР и кол-во</th>
                                        <th colspan="3" rowspan="1" data-bs-toggle="tooltip" data-html="true"
                                            title="Указывается представителем базы или участка погрузочно-разгрузочных работ по запросу перевозчика">Массогабаритные характеристики***</th>
                                        <th rowspan="2" >вес 1 ед. тн.</th>
                                        <th rowspan="2" >Всего тн.</th>
                                        <th rowspan="2" >Дата заявки на отгрузку</th>
                                        <th rowspan="2" >Заявка на контейнер/автотранспорт</th>
                                        <th rowspan="2" >Дата отгрузки</th>
                                        <th rowspan="2" >Груз сформирован в контейнер/автотранспорт</th>
                                        <th rowspan="2" >Транзитный склад</th>
                                        <th rowspan="2" >Отгружено</th>
                                        <th rowspan="2" >Остаток</th>
                                        <th colspan="2" rowspan="1" >Накладная формы М11</th>
                                        <th rowspan="2" >Общие примечания</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th data-align="center">Длина, м</th>
                                        <th data-align="center">Ширина, м</th>
                                        <th data-align="center">Высота, м</th>
                                        <th data-align="center">№ накладной</th>
                                        <th data-align="center">Дата накладной</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
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
                                    </tr>
                                    </thead>
                                    <tbody class="table-striped">
                                    <?php $n=0; $accordion_flag=0; foreach($orders as $item): ?>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <a tabindex="0" data-bs-toggle="popover" data-bs-trigger="focus"
                                                   title="Дополнительная информация"
                                                   data-bs-content="
                                                   Код МТР - <?php if (isset($item['codeMTR'])) echo($item['codeMTR']); ?>
                                                   Номер партии - <?php if (isset($item['numberPart'])) echo($item['numberPart']); ?>
                                                   Ед.изм. - <?php if (isset($item['sizeMTR'])) echo($item['sizeMTR']); ?>
                                                   Наименование объекта - <?php if (isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?>
                                                   Инвентарный № объекта - <?php if (isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?>
                                                   Наименование транзитного* или конечного получателя груза - <?php if (isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?>
                                                   Наименование филиала получателя - <?php if (isset($item['filialMTR'])) echo($item['filialMTR']); ?>
                                                   Приоритет(1,2,3)** - <?php if (isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?>
                                                   Примечание по доставке - <?php if (isset($item['noteMTR'])) echo($item['noteMTR']); ?>
                                                   "
                                                   class="table-links"><?php if (isset($item['nameMTR'])) echo($item['nameMTR']); ?>
                                                    - <?php if (isset($item['sumMTR'])) echo($item['sumMTR']); ?>
                                                </a>
                                                <input type="hidden" class="id_order_mtr_class"
                                                       data-id_order_mtr="<?php if (isset($item['id_order'])) echo($item['id_order']); ?>"
                                                       disabled
                                                       value="<?php if (isset($item['nameMTR'])) echo($item['nameMTR']); ?>"
                                                >
                                                <input type="hidden" class="sum_mtr" disabled
                                                       data-sum_mtr="<?php if (isset($item['sumMTR'])) echo($item['sumMTR']); ?>"
                                                       value="<?php if (isset($item['sumMTR'])) echo($item['sumMTR']); ?>"
                                                >
                                                <input type="hidden" class="code_mtr_class "
                                                       data-bond_guid_motion_date="<?php echo($bond_guid_motion_date); ?>" disabled
                                                       value="<?php if (isset($item['codeMTR'])) echo($item['codeMTR']); ?>"
                                                >
                                                <input type="hidden" class="numberPart" disabled
                                                       value="<?php if (isset($item['numberPart'])) echo($item['numberPart']); ?>"
                                                >
                                                <input type="hidden" class="sizeMTR " id="sizeMTR" disabled
                                                       value="<?php if (isset($item['sizeMTR'])) echo($item['sizeMTR']); ?>"
                                                >
                                                <input type="hidden" class="ukObjectMTR" id="ukObjectMTR" disabled
                                                       value="<?php if (isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?>"
                                                >
                                                <input type="hidden" class="numberObjectMTR" id="numberObjectMTR" disabled
                                                       value="<?php if (isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?>"
                                                >
                                                <input type="hidden" class="address_orderMTR" id="address_orderMTR" disabled
                                                       value="<?php if (isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?>"
                                                >
                                                <input type="hidden" class="filialMTR" id="filialMTR" disabled
                                                       value="<?php if (isset($item['filialMTR'])) echo($item['filialMTR']); ?>"
                                                >
                                                <input type="hidden" class="deliveryMTR" id="deliveryMTR" disabled
                                                       value="<?php if (isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?>"
                                                >
                                                <input type="hidden" class="noteMTR" id="noteMTR" disabled
                                                       value="<?php if (isset($item['noteMTR'])) echo($item['noteMTR']); ?>"
                                                >

                                            </td>
                                            <td>
                                                <input name="length_motion[]" type="text"
                                                       class="length_motion_2" disabled
                                                       value="<?php if (isset($value['length_motion'])) echo($value['length_motion']); ?>">
                                            </td>
                                            <td>
                                                <input name="width_motion[]" type="text"
                                                       class="width_motion_2" disabled
                                                       value="<?php if (isset($value['width_motion'])) echo($value['width_motion']); ?>">
                                            </td>
                                            <td>
                                                <input name="height_motion[]" type="text" class="height_motion" value="" autocomplete="off">
                                            </td>
                                            <td>
                                                <input name="weight_motion[]" type="text" class="weight_motion" value="" autocomplete="off">
                                            </td>
                                            <td>
                                                <input name="total_motion[]" type="text" class="total_motion" value="" autocomplete="off">
                                            </td>
                                            <td>
                                                <input
                                                        name="dateRequest_motion[]" type="text"
                                                        class="date_pickers dateRequest_motion date_order_id " value="" autocomplete="off"
                                                >
                                            </td>
                                            <td>
                                                <input name="infoShipments_motion[]" type="text" class="infoShipments_motion" value="">
                                            </td>
                                            <td>
                                                <div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input
                                                            name="dateShipments_motion[]" type="text"
                                                            class="dateShipments_motion date_order_id" value="" autocomplete="off"
                                                            role="input"><span class="input-group-addon" role="right-icon"><span
                                                                class="glyphicon glyphicon-calendar"></span></span></div>
                                            </td>
                                            <td>
                                                <input name="cargo_motion[]"
                                                       type="text"
                                                       class="cargo_motion" value="">
                                            </td>
                                            <td>
                                                <input name="tranzit_motion[]" type="text" class="tranzit_motion" value="">
                                            </td>
                                            <td>
                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus"
                          data-bs-content="<?php if (isset($item['sumMTR'])) echo($item['sumMTR']); ?>
                            - <?php if(isset($item['sizeMTR'])) echo($item['sizeMTR']); ?>">
                        <input name="shipped_motion[]" type="text" class="shipped_motion" value="" autocomplete="off">
                    </span>
                                            </td>
                                            <td>
                                                <input name="remains_motion[]" type="text" disabled class="remains_motion" value="">
                                            </td>
                                            <td>
                                                <input name="numberOverhead_motion[]" type="text" class="numberOverhead_motion" value="" autocomplete="off">
                                            </td>
                                            <td>
                                                <div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input
                                                            name="dateOverhead_motion[]" type="text"
                                                            class="dateOverhead_motion input-block date_order_id" value=""
                                                            autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span
                                                                class="glyphicon glyphicon-calendar"></span></span>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea name="note_motion[]" class="note_motion"></textarea>
                                            </td>
                                        </tr>
                                        <?php
                                        $n=$n+1;
                                        $accordion_flag=$accordion_flag+1;
                                    endforeach;
                                    ?>
                                    </tbody>
                                </table>


           <div style="display: none" class="card-footer bg-white">
               <button type="button"
                       data-number_table="<?php echo($n); ?>"
                       data-sum_mtr="<?php if (isset($item['sumMTR'])) echo($item['sumMTR']); ?>"
                       data-id_order_mtr="<?php if (isset($item['id_order'])) echo($item['id_order']); ?>"
                       data-id_motion="<?php if (isset($item['id_motion'])) echo($item['id_motion']); ?>"
                       onclick="add_row_new(this);"
                       class="button_add_row btn btn-primary btn-sm">Добавить строку
               </button>
           </div>
       <?php $n = $n + 1; $accordion_flag = $accordion_flag + 1; endforeach; ?>
            <!--------------------------------------------------------------------->

            <div class="card-footer ">
                <div class="row">
                    <div class="col-sm-6">
                        <!--                    Кнопки управления при изменении данных в БД-->
                        <?php
                        $_username = $this->session->userdata('username');
                        $_actions = $this->session->userdata('actions');
                        if (isset ($_username) && (($_actions['edit_motion']) == 1) ) { ?>
                            <button id="saveToEditOrder" style="display: none" onclick="saveEditMotion();" type="button" class="ButtonSaveEditToTable btn btn-outline-success">Сохранить изменения <i class="fa fa-save"></i></button>
                            <button id="cancelToEditOrder" style="display: none" onclick="cancelEditMotion();" type="button" class="ButtonCancelEditMotion btn btn-outline-warning">Отмена <i class="fa fa-undo"></i></button>
                            <button id="editToTable" onclick="editMotion();" type="button" class="ButtonEditToTable btn btn-outline-primary">Изменить <i class="fa fa-pencil"></i></button>
                        <?php } ?>
                        <?php if (isset ($_username) && ((($_actions['edit_motion']) == 1) || (($_actions['show_motion']) == 1)) ) { ?>

                            <button type="button" onclick="ExportXls();" class="btn btn-info ButtonExportXLS">Экспорт в Excel</button>
                        <?php } ?>
                    </div>
                </div
            </div>
        </div>
    </div>
</section>
<!-- end: create Motion -->
<div class="modal_loading"></div> <!--окно загрузки-->

<script src="<?=base_url();?>assets/order/jquery-3.3.1.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/datepicker4/js/gijgo.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/datepicker4/js/messages/messages.ru-ru.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/dataTables.fixedHeader.min.js" type="text/javascript"></script>

</body>
</html>

<script>
    $body = $("body");
    $(document).on({
        ajaxStart: function() { $body.addClass("loading");    },
        ajaxStop: function() { $body.removeClass("loading"); }
    });

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

//Добавление строки
    function addrowR2 (id){
//        console.log(id);
        var id_row_table = id.dataset.id_table;
//        console.log(id_row_table);
        var table = $('.motion_table').DataTable();
//        console.log(table);
        var rowNode= table.eq(id_row_table).row.add( [
            '<td><input style="font-size: 9pt;" name="length_motion[]" type="text" class="length_motion form-control input-block"></td>',
            '<td><input style="font-size: 9pt;" name="width_motion[]" type="text" class="width_motion form-control input-block"></td>',
            '<td><input style="font-size: 9pt;" name="height_motion[]" type="text" class="height_motion form-control input-block"></td>',
            '<td><input style="font-size: 9pt;" name="weight_motion[]" type="text" class="weight_motion form-control input-block"></td>',
            '<td><input style="font-size: 9pt;" name="total_motion[]" type="text" class="total_motion form-control input-block"></td>',
            '<td><input style="font-size: 9pt;" name="cargo_motion[]" type="text" class="cargo_motion form-control input-block" value=""></td>',
            '<td><input style="font-size: 9pt;" name="dateRequest_motion[]" type="text" class="dateRequest_motion form-control date_order_id" value="" autocomplete="off"></td>',
            '<td><input style="font-size: 9pt;" name="dateShipments_motion[]" type="text" class="dateShipments_motion form-control date_order_id" value="" autocomplete="off"></td>',
            '<td><input style="font-size: 9pt;" name="infoShipments_motion[]" type="text" class="infoShipments_motion form-control input-block"></td>',
            '<td><input style="font-size: 9pt;" name="tranzit_motion[]" type="text" class="tranzit_motion form-control input-block"></td>',
            '<td><input style="font-size: 9pt;" name="shipped_motion[]" type="text" class="shipped_motion form-control input-block"></td>',
            '<td><input style="font-size: 9pt;" name="remains_motion[]" type="text" class="remains_motion form-control input-block"></td>',
            '<td><input style="font-size: 9pt;" name="numberOverhead_motion[]" type="text" class="numberOverhead_motion form-control input-block"></td>',
            '<td><input style="font-size: 9pt;" name="dateOverhead_motion[]" type="text" class="dateOverhead_motion form-control input-block date_order_id" value="" autocomplete="off"></td>',
            '<td><textarea style="width:100%; height:30px; font-size: 9pt;" name="note_motion[]" class="form-control note_motion"></textarea></td>',
            '<td><input style="font-size: 9pt;" name="dateArrival_motion[]" type="text" class="dateArrival_motion form-control date_order_id" value="" disabled autocomplete="off"></td>',
            '<td><input style="font-size: 9pt;" name="numberM15_motion[]" type="text" class="numberM15_motion form-control input-block" disabled></td>',
            '<td><input style="font-size: 9pt;" name="dateM15_motion[]" type="text" class="dateM15_motion form-control input-block date_order_id" value="" disabled autocomplete="off"></td>',
            '<td><input style="font-size: 9pt;" name="dateFilial_motion[]" type="text" class="dateFilial_motion form-control date_order_id" value="" disabled autocomplete="off"></td>',
            '<td><a href="#" id="deleterow" onclick="deleteRowTable(this);">Удалить</a></td>'
        ] ).draw(false)
            .node();
        $(rowNode).find('td').eq(19).addClass('ButtonAction');
        //Вывод даты
        date_row();
    }

//Добавление строки
    function addrowR(id){
        var id_row_table = id.dataset.number_table;
        var table = $('.motion_table').DataTable();
        var row_data = [];
        $(id).closest('tr').find('td').each(function () {
            row_data.push($(this).html());
        });
        var arr5 = '<input style="font-size: 9pt;" name="cargo_motion[]" type="text" class="cargo_motion form-control input-block" value="" data-sum_mtr="20" data-id_order_mtr="398" data-id_motion="NULL">';
        var arr6 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateRequest_motion[]" type="text" class="dateRequest_motion form-control date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr7 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateShipments_motion[]" type="text" class="dateShipments_motion form-control date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr12 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateOverhead_motion[]" type="text" class="dateOverhead_motion form-control input-block date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr14 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateArrival_motion[]" type="text" class="dateArrival_motion form-control date_order_id" value="" disabled="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr16 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateM15_motion[]" type="text" class="dateM15_motion form-control input-block date_order_id" value="" disabled="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr17 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateFilial_motion[]" type="text" class="dateFilial_motion form-control date_order_id" value="" disabled="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';

        row_data.splice(5, 1, arr5);
        row_data.splice(6, 1, arr6);
        row_data.splice(7, 1, arr7);
        row_data.splice(12, 1, arr12);
        row_data.splice(14, 1, arr14);
        row_data.splice(16, 1, arr16);
        row_data.splice(17, 1, arr17);
        table.eq(id_row_table).row.add(row_data).draw(true);
        //Вывод даты
        date_row();
    }

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
        var arr5 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateRequest_motion[]" type="text" class="dateRequest_motion form-control date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr6 = '<input style="font-size: 9pt;" name="infoShipments_motion[]" type="text" class="infoShipments_motion form-control input-block" value="">';
        var arr7 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateShipments_motion[]" type="text" class="dateShipments_motion form-control date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr8 = '<input style="font-size: 9pt;" name="cargo_motion[]" data-sum_mtr="' + sum_mtr + '" data-id_order_mtr="' + id_order_mtr + '" type="text" class="cargo_motion form-control input-block" value="">';
        var arr9 = '<input style="font-size: 9pt;" name="tranzit_motion[]" type="text" class="tranzit_motion form-control input-block" value="">';
        var arr10 = '<input style="font-size: 9pt;" name="shipped_motion[]" type="text" class="shipped_motion form-control input-block" value="">';
        var arr11 = '<input style="font-size: 9pt;" name="remains_motion[]" type="text" class="remains_motion form-control input-block" value="" disabled>';
        var arr12 = '<input style="font-size: 9pt;" name="numberOverhead_motion[]" type="text" class="numberOverhead_motion form-control input-block" value="">';
        var arr13 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateOverhead_motion[]" type="text" class="dateOverhead_motion form-control input-block date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr14 = '<textarea style="width:100%; height:30px; font-size: 9pt;" name="note_motion[]" class="form-control note_motion" ></textarea>';
        var arr15 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateArrival_motion[]" type="text" class="dateArrival_motion form-control date_order_id" value="" autocomplete="off" role="input" disabled><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr16 = '<input style="font-size: 9pt;" name="numberM15_motion[]" type="text" class="numberM15_motion form-control input-block" value="" disabled>';
        var arr17 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateM15_motion[]" type="text" class="dateM15_motion form-control input-block date_order_id" value="" autocomplete="off" role="input" disabled><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr18 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateFilial_motion[]" type="text" class="dateFilial_motion form-control date_order_id" value="" autocomplete="off" role="input" disabled><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr19 = '<input style="font-size: 9pt;" name="recd[]" type="text" class="recd form-control input-block" value="" disabled>';
        var arr20 = '<a href="#" id="deleterow" onclick="deleteRowTable(this);" data-id-row-tablemtr="" >Удалить</a>';
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
        row_data.splice(18, 1, arr18);
        row_data.splice(19, 1, arr19);
        row_data.splice(20, 1, arr20);

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
            var remains_motion = Number(document.getElementsByClassName('remains_motion')[a].value);    //остаток
            remains_motion = sumMTR - shipped_motion;
            console.log(sumMTR);
            console.log(shipped_motion);
            if (sumMTR >= shipped_motion) {
                shipped_motion_class.eq(a).removeClass('is-invalid');
                shipped_motion_class.eq(a).addClass('is-valid');
                Number(document.getElementsByClassName('remains_motion')[a].value = remains_motion);
                arr[arr.length] = 1;
            } else {
                shipped_motion_class.eq(a).removeClass('is-valid');
                shipped_motion_class.eq(a).addClass('is-invalid');
                Number(document.getElementsByClassName('remains_motion')[a].value = remains_motion);
                arr[arr.length] = 0;
            }
            a++;
        }

//Итоги валидации
       console.log(arr);
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
    function saveEditMotion() {
       var check_validation = validation_form();
        console.log(check_validation);
        if (check_validation == 1 ){
            if (confirm ("Вы точно хотите сохранить внесенные изменения?")) {
                /*Show and Hide кнопок управления*/
                $('.ButtonSaveEditToTable').hide();
                $('.ButtonCancelEditMotion').hide();
                $('.ButtonEditToTable').show();
                $('.ButtonExportXLS').show();
                $('.ButtonExitEditMotion').show();
                $('.ButtonDateMotion').show();
                $('.ButtonEndGameToTable').show();

                /*Show and Hide input table*/
                $(".id_order_mtr_class").prop("disabled", true);
                $(".length_motion").prop("disabled", true);
                $(".width_motion").prop("disabled", true);
                $(".height_motion").prop("disabled", true);
                $(".weight_motion").prop("disabled", true);
                $(".total_motion").prop("disabled", true);
                $(".cargo_motion").prop("disabled", true);
                $(".dateRequest_motion").prop("disabled", true);
                $(".dateShipments_motion").prop("disabled", true);
                $(".infoShipments_motion").prop("disabled", true);
                $(".tranzit_motion").prop("disabled", true);
                $(".shipped_motion").prop("disabled", true);
                $(".remains_motion").prop("disabled", true);
                $(".numberOverhead_motion").prop("disabled", true);
                $(".dateOverhead_motion").prop("disabled", true);
                $(".note_motion").prop("disabled", true);

                /*формирование запроса к базам*/
                var id_motion_class = document.getElementsByClassName("id_motion");
                var id_motion = id_motion_class[0].dataset.id_motion;   // id из таблицы all_motion
                var gid_motion = id_motion_class[0].dataset.gid_motion; // guid из таблицы all_motion
//GUID для строки внутри отчета "информаиця о движении МТР"
                var id_bond_guid_motion_date = document.getElementsByClassName("code_mtr_class");
                var guid_bond_guid_motion_date = id_bond_guid_motion_date[0].dataset.bond_guid_motion_date; //GUID строки для удобства следующего поиска
                var m = 0;
/*формирование запроса к базе all_motion*/
                $.ajax({
                    url : "<?=base_url();?>Main/saveEditAllMotion",
                    type: "POST",
                    data: {
                        id_motion : id_motion
                    },
                    success: function (data_id_all_motion) {

/*формирование запроса к базе motion*/
                        var n = document.getElementsByClassName("cargo_motion");            //собираем всю информацию по элементу
                        var number_codeMTR = document.getElementsByClassName('cargo_motion').length; //считаем кол-во строк для добавления(изменения) в таблицы motion
                        var test_number_codeMTR = document.getElementsByClassName('sum_mtr').length; //считаем кол-во строк для добавления(изменения) в таблицы motion
                        console.log(test_number_codeMTR);
                        while (m < number_codeMTR) {
                            var length_motion = document.getElementsByClassName('length_motion')[m].value;
                            var width_motion = document.getElementsByClassName('width_motion')[m].value;
                            var height_motion = document.getElementsByClassName('height_motion')[m].value;
                            var weight_motion = document.getElementsByClassName('weight_motion')[m].value;
                            var total_motion = document.getElementsByClassName('total_motion')[m].value;
                            var cargo_motion = document.getElementsByClassName('cargo_motion')[m].value;
                            var dateRequest_motion = document.getElementsByClassName('dateRequest_motion')[m].value;
                            var dateShipments_motion = document.getElementsByClassName('dateShipments_motion')[m].value;
                            var infoShipments_motion = document.getElementsByClassName('infoShipments_motion')[m].value;
                            var tranzit_motion = document.getElementsByClassName('tranzit_motion')[m].value;
                            var shipped_motion = document.getElementsByClassName('shipped_motion')[m].value;
                            var remains_motion = document.getElementsByClassName('remains_motion')[m].value;
                            var numberOverhead_motion = document.getElementsByClassName('numberOverhead_motion')[m].value;
                            var dateOverhead_motion = document.getElementsByClassName('dateOverhead_motion')[m].value;
                            var note_motion = document.getElementsByClassName('note_motion')[m].value;
                            var number_id_order_mtr = n[m].dataset.id_order_mtr;  //id mtr из таблицы order_mtr
                            var number_id_motion = n[m].dataset.id_motion;        //id_motion из таблицы motion каждой строки
                            var sumMTR = n[m].dataset.sum_mtr;                    //sum mtr из таблицы order_mtr
                            console.log(shipped_motion);
                            $.ajax({
                                url: "<?=base_url();?>Main/saveEditMotion",
                                type: "POST",
                                data: {
                                    length_motion: length_motion,
                                    width_motion: width_motion,
                                    height_motion: height_motion,
                                    weight_motion: weight_motion,
                                    total_motion: total_motion,
                                    cargo_motion: cargo_motion,
                                    dateRequest_motion: dateRequest_motion,
                                    dateShipments_motion: dateShipments_motion,
                                    infoShipments_motion: infoShipments_motion,
                                    tranzit_motion: tranzit_motion,  //кол-во транзитного склада
                                    shipped_motion: shipped_motion,  //кол-во отгруженно
                                    sumMTR: sumMTR,                  //кол-во всего надо отгрузить
                                    remains_motion: remains_motion,
                                    numberOverhead_motion: numberOverhead_motion,
                                    dateOverhead_motion: dateOverhead_motion,
                                    note_motion: note_motion,
                                    number_id_motion: number_id_motion,
                                    number_id_order_mtr: number_id_order_mtr,
                                    id_motion : id_motion,
                                    gid_motion : gid_motion,
                                    guid_bond_guid_motion_date: guid_bond_guid_motion_date
                                },
                                success: function (data) {
                                    console.log(data)
                                    //window.location = "<?//=base_url();?>//Main/edit_motion?id_motion=" + id_motion;
                                }
                            });
                            m++;
                        }
                    }
                });
            }
        } else {
            alert("Обнаружены ошибки при заполнении формы, исправьте ошибки и повторите еще раз");
        }
    }

//Отмена последних изменений выход из режима редактирования информации о движении МТР
    function cancelEditMotion(){
//GUID всего отчета "информаиця о движении МТР"
        var id_guid = document.getElementsByClassName("guid_motion");
        var guid = id_guid[0].dataset.id_motion;
        console.log(guid);
        window.location = "<?=base_url();?>Main/edit_motion?id_motion=" + guid;
    }

//Кнопка удаление строки
    function deleteRowTable(id){
        if (confirm("Вы точно хотите удалить строку безбозвратно?")){
            var id_row_order = id.getAttribute('data-id-row-tablemtr');
            console.log(id_row_order);

            var t = $('table.motion_table').DataTable();
            $('table.motion_table').on("click", "a", function(){
                t.row($(this).parents('tr')).remove().draw( false );
            });

            $.ajax({
                type: "POST",
                url: "<?=base_url();?>Main/deleteRowMotionTable",
                data: {id : id_row_order},
                success: function(data) {
                    console.log(data);
                }
            });
        }
    }

//Отмена последних изменений выход из режима редактирования информации о движении МТР
    function ExitEditMotion(){
        window.location ="<?=base_url();?>Main/show_motion";
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
        $('.card-footer').show();
        $(".buttonCopy").prop("disabled", false);
        $('.ButtonExportXLS').hide();
        $('.ButtonExitEditMotion').hide();
        $('.ButtonDateMotion').hide();
        $('.ButtonEndGameToTable').hide();

        /*Show and Hide input table*/
        $(".form-check-input").prop("disabled", false);

        $(".length_motion").prop("disabled", false);
        $(".width_motion").prop("disabled", false);
        $(".height_motion").prop("disabled", false);
        $(".weight_motion").prop("disabled", false);
        $(".total_motion").prop("disabled", false);
        $(".cargo_motion").prop("disabled", false);
        $(".dateRequest_motion").prop("disabled", false);
        $(".dateShipments_motion").prop("disabled", false);
        $(".infoShipments_motion").prop("disabled", false);
        $(".tranzit_motion").prop("disabled", false);
        $(".shipped_motion").prop("disabled", false);
        // $(".remains_motion").prop("disabled", false);
        $(".numberDateOverhead_motion").prop("disabled", false);
        $(".numberOverhead_motion").prop("disabled", false);
        $(".dateOverhead_motion").prop("disabled", false);
        $(".note_motion").prop("disabled", false);
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
                url: "<?=base_url();?>Main/endGameMotion",
                type: "POST",
                data: {
                    id_motion : id_motion,
                    number_id_order_mtr : number_id_order_mtr,
                    id_order : id_order
                },
                success: function(data) {
                    console.log(data);
                    window.location = "<?=base_url();?>Main/edit_motion?id_motion=" + id_motion;

                }
            });
            m++;
        }
        alert("Данная информация передана на участок");
    }
</script>