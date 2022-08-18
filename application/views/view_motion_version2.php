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
            <a class="guid_motion header__subtitle" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent"
               data-id_motion="<?php echo $orders_guid; ?>">Информация о движении МТР на базе </a>
        </div>
        <div class="header_nav">
            <a class="header__button header__subtitle nav-link text-white"
               href="<?= base_url(); ?>Main/motion_add_many?string_check=<?php if (isset($string_check)) {
                   echo($string_check);
               } else {
                   echo($_GET['string_check']);
               } ?>">Множественная вставка значений </a>
        </div>
        <p class="header__title">Приложение № 3</p>
    </header>
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <div class="card border-light ">
                <div class="card-header">
                    <?php foreach ($orders_name as $item_orders): ?>
                        <p class="header__title header__title_black-text id_number_orders"
                           data-id_order="<?php echo($item_orders['id_bond_all_orders']); ?>">Распоряжения
                            № <?php echo($item_orders['number_orderMTR']); ?>
                            от <?php echo(date('d-m-Y', strtotime($item_orders['date_orderMTR']))); ?> </p>
                    <?php endforeach; ?>
                </div>
                <div class="card-body">
                    <?php foreach ($author as $item_author): ?>
                        <p class="card-text">Исполнитель по Распоряжению: <input type="text" id="author_order"
                                                                                 name="author_order"
                                                                                 value="<?php if (isset($item_author['sername'])) {
                                                                                     echo($item_author['sername'] . " " . $item_author['name']);
                                                                                 } ?>"
                            ></p>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>

<section>
    <div class="">
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
                    <a tabindex="0" data-bs-toggle="popover" data-bs-trigger="focus" title="Дополнительная информация"
                       data-bs-content="
                           Код МТР - <?php if (isset($item['codeMTR'])) echo($item['codeMTR']); ?>
                           Номер партии - <?php if (isset($item['numberPart'])) echo($item['numberPart']); ?>
                           Ед.изм. - <?php if(isset($item['sizeMTR'])) echo($item['sizeMTR']); ?>
                           Наименование объекта - <?php if(isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?>
                           Инвентарный № объекта - <?php if(isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?>
                           Наименование транзитного* или конечного получателя груза - <?php if(isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?>
                           Наименование филиала получателя - <?php if(isset($item['filialMTR'])) echo($item['filialMTR']); ?>
                           Приоритет(1,2,3)** - <?php if(isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?>
                           Примечание по доставке - <?php if(isset($item['noteMTR'])) echo($item['noteMTR']); ?>
                       "
                       class="table-links"><?php if (isset($item['nameMTR'])) echo($item['nameMTR']); ?>
                        - <?php if (isset($item['sumMTR'])) echo($item['sumMTR']); ?></a>
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
                    <input type="text" name="length_motion[]" class="length_motion" value="" autocomplete="off">
                </td>
                <td>
                    <input name="width_motion[]" type="text" class="width_motion" value="" autocomplete="off">
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
    </div>

    <div class="footer_yura">
        <div>
            <!--Кнопки управления при первичном занесение данных в БД-->
            <button id="saveToTable" onclick="saveMotion();" type="button"
                    class="ButtonSaveToTable btn btn-outline-success">Сохранить <i class="fa fa-save"></i></button>
            <button id="cancelToEditOrder" onclick="cancelCreateMotion();" type="button"
                    class="ButtonCancelEditToTable btn btn-outline-warning">Отмена <i class="fa fa-undo"></i></button>
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
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    });
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    $(document).ready(function() {
        var t = $('#createMotion').DataTable({
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
            // "scrollX": true,
            "searching": false,
            "paging":    false,
            // "ordering":  false,
            "info":      false,
            fixedHeader: true,
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ]
        });

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

// Вывод даты
        date_row();
    });

//Вывод даты
    function date_row(){
        $('.date_order_id').each(function(){
            $(this).datepicker({
                locale: 'ru-ru',
                format: 'dd-mm-yyyy'
            });
        });
    }

//Валидация форм
    function validation_form() {
        var arr = []; //Счетчик ошибок при заполнении формы
//Валидация Примечания
        var a = 0; //счетчик строк
        var b = 0; //счетчик МТР
        var number_row = document.getElementsByClassName('shipped_motion').length; //общее кол-во строк МТР которое отгружают
        var length_sum_mtr = document.getElementsByClassName('sum_mtr').length; //общее кол-во строк МТР
        console.log("number_row - " + number_row);
        while (a < number_row) {
            var number_row_a = document.getElementsByClassName('shipped_motion')[a].value;
            var number_row_b = document.getElementsByClassName('sum_mtr')[a].value;
            console.log('Строка ' + a + ' значение - '+number_row_a + ' максимальное значение - ' + number_row_b);
            a++;
        }
        console.log('Кол-во позиций - ' + length_sum_mtr);
        var shipped_motion = $('.shipped_motion');
        while (b < length_sum_mtr) {
           var code_mtr = document.getElementsByClassName('code_mtr_class')[b].value;
           console.log('Код МТР-'+code_mtr);
           var sumMTR = Number(document.getElementsByClassName('sum_mtr')[b].value);
           var shipped_motion_m = Number(document.getElementsByClassName('shipped_motion')[b].value);
           console.log("sumMTR - " + sumMTR);
           if (Number(document.getElementsByClassName('sum_mtr')[b].value) >= Number(document.getElementsByClassName('shipped_motion')[b].value)) {
               console.log("TRUE Сравнение sumMTR = " + sumMTR + " shipped_motion_m = " + shipped_motion_m);
               console.log("Results = " + sumMTR >= shipped_motion_m);
               console.log("Тип переменной " + typeof (sumMTR));
               shipped_motion.eq(b).removeClass('is-invalid-yura');
               shipped_motion.eq(b).addClass('is-valid-yura');
               arr[arr.length] = 1;
           } else {
               console.log("FALSE Сравнение sumMTR = " + sumMTR + " shipped_motion_m = " + shipped_motion_m);
               console.log("Results = " + sumMTR >= shipped_motion_m);
               console.log("Тип переменной " + typeof (sumMTR));
               arr[arr.length] = 0;
               shipped_motion.eq(b).addClass('is-invalid-yura');
               shipped_motion.eq(b).removeClass('is-valid-yura');
           }
           b++;
        }
//Итоги валидации
       console.log("Кол-во ошибок - " + arr);
        var search = arr.indexOf(0);
        if (search == -1){
           console.log("Good");
            return 1;
        } else {
           console.log("Bad");
            return 0;
        }
    }

    //Сохранение информации о движении с занесением в базу
    function saveMotion() {
       var check_validation = validation_form();
       //  var check_validation = 1;
        if (check_validation == 1 ){
            if (confirm("Вы точно хотите сохранить данные?")) {
//GUID всего отчета "информаиця о движении МТР"
                var id_guid = document.getElementsByClassName("guid_motion");
                var guid = id_guid[0].dataset.id_motion;
                console.log(guid);
//GUID для строки внутри отчета "информаиця о движении МТР"
                var id_bond_guid_motion_date = document.getElementsByClassName("code_mtr_class");
                var guid_bond_guid_motion_date = id_bond_guid_motion_date[0].dataset.bond_guid_motion_date; //GUID строки для удобства следующего поиска
//                console.log(guid_bond_guid_motion_date);
                var m = 0;
/*формирование запроса к базе all_motion*/
                $.ajax({
                    url : "<?=base_url();?>Main/saveAllMotion",
                    type: "POST",
                    data: {
                        guid : guid
                    },
                    success: function (data_id_all_motion) {
                        console.log(data_id_all_motion); // id с таблицы all_motion (id всего отчета)

/*формирование запроса к базе motion*/
                        var n = document.getElementsByClassName("cargo_motion"); //находим элемента в классе которого есть информация об id из таблицы order_mtr
                        var id_order_mtr = document.getElementsByClassName("id_order_mtr_class");
                        console.log("id_order_mtr - " + id_order_mtr);
                        var n_sumMTR = document.getElementsByClassName("cargo_motion");
                        var n_sumMTR_length = document.getElementsByClassName("cargo_motion").length;
//                        console.log(n_sumMTR_length);
                        var test_number_codeMTR = document.getElementsByClassName('sum_mtr').length; //считаем кол-во строк для добавления(изменения) в таблицы motion
                        console.log("test"+test_number_codeMTR);
                        var number_codeMTR = document.getElementsByClassName('cargo_motion').length; //считаем кол-во строк для добавления в базу
                        console.log(number_codeMTR);
                        while (m < number_codeMTR) {
                                var length_motion = document.getElementsByClassName('length_motion')[m].value;
                                var width_motion = document.getElementsByClassName('width_motion')[m].value;
                                var height_motion = document.getElementsByClassName('height_motion')[m].value;
                                var weight_motion = document.getElementsByClassName('weight_motion')[m].value;
                                var total_motion = document.getElementsByClassName('total_motion')[m].value;
                                var dateRequest_motion = document.getElementsByClassName('dateRequest_motion')[m].value;
                                var infoShipments_motion = document.getElementsByClassName('infoShipments_motion')[m].value;
                                var dateShipments_motion = document.getElementsByClassName('dateShipments_motion')[m].value;
                                var cargo_motion = document.getElementsByClassName('cargo_motion')[m].value;
                                var tranzit_motion = document.getElementsByClassName('tranzit_motion')[m].value;
                                var shipped_motion = Number(document.getElementsByClassName('shipped_motion')[m].value);
                                var remains_motion_n = Number(document.getElementsByClassName('remains_motion')[m].value);
                                var numberOverhead_motion = document.getElementsByClassName('numberOverhead_motion')[m].value;
                                var dateOverhead_motion = document.getElementsByClassName('dateOverhead_motion')[m].value;
                                var note_motion = document.getElementsByClassName('note_motion')[m].value;
                                var sumMTR = Number(document.getElementsByClassName('sum_mtr')[m].value);
                                console.log("remains_motion_n = " + remains_motion_n);
                                console.log("shipped_motion = " + shipped_motion);
                                console.log("sumMTR = " + sumMTR);
                                if (shipped_motion == undefined || shipped_motion == 0) {
                                   var remains_motion = 0;
                                   console.log("variant 1 = " + remains_motion);
                                } else {
                                   var remains_motion = sumMTR - shipped_motion;
                                   console.log("variant 2 = " + remains_motion);
                                }
                                var number_id_order_mtr = id_order_mtr[m].dataset.id_order_mtr; //из data-id_order_mtr забирают информацию об id из таблицы order_mtr
                                console.log("number_id_order_mtr - " + number_id_order_mtr);
                                $.ajax({
                                    url: "<?=base_url();?>Main/saveMotion",
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
                                        tranzit_motion: tranzit_motion,
                                        shipped_motion: shipped_motion,
                                        sumMTR: sumMTR,
                                        remains_motion: remains_motion,
                                        numberOverhead_motion: numberOverhead_motion,
                                        dateOverhead_motion: dateOverhead_motion,
                                        note_motion: note_motion,
                                        number_id_order_mtr: number_id_order_mtr,               //id из таблицы order_mtr
                                        id_bond_all_motion: data_id_all_motion,                 //id с таблицы all_motion (id всего отчета)
                                        guid: guid,                                             //GUID всего отчета "информаиця о движении МТР"
                                        guid_bond_guid_motion_date: guid_bond_guid_motion_date
                                    },
                                    success: function (data) {
                                        console.log(data);
                                        window.location = "<?=base_url();?>Main/edit_motion?guid=" + guid;
                                    }
                                });
                                m++;
                        }
                        if (number_codeMTR == 0) {
                            window.location = "<?=base_url();?>Main/edit_motion?guid=" + guid;
                        }
                    }
                });
/*формирование запроса к базе all_orders*/
                var check_orders = 0;
                var number_orders = document.getElementsByClassName('id_number_orders').length;
                var n_orders = document.getElementsByClassName("id_number_orders");
                while (check_orders < number_orders) {
                    var number_id_order = n_orders[check_orders].dataset.id_order;
                    $.ajax({
                        url : "<?=base_url();?>Main/saveGUIDAllMotionInOrders",
                        type: "POST",
                        data: {
                            guid : guid,
                            id_order : number_id_order
                        },
                        success: function (data) {
//                            console.log(data);
                        }
                    });
                    check_orders++;
                }
            }
        } else {
            alert("Обнаружены ошибки при заполнении формы, исправьте ошибки и повторите еще раз");
        }
    }

//Отмена последних изменений выход из режима редактирования информации о движении МТР
    function cancelCreateMotion(){
        var check_orders = 0;
        var number_orders = document.getElementsByClassName('id_number_orders').length;
        var n_orders = document.getElementsByClassName("id_number_orders");
        while (check_orders < number_orders) {
            var number_id_order = n_orders[check_orders].dataset.id_order;
            console.log(number_id_order);
            $.ajax({
                url : "<?=base_url();?>Main/cancelCreateMotion",
                type: "POST",
                data: {
                    id_order : number_id_order
                },
                success: function (data) {
                    console.log(data);
                }
            });
            check_orders++;
        }
        window.location ="<?=base_url();?>Main/create_motion";
    }

</script>
