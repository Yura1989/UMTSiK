<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?=base_url();?>assets/order/favicon.png" type="image/png">

    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/bootstrap-4.2.1/css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/bootAdmin/css/fontawesome-all.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/bootAdmin/css/bootadmin.css" >
    <link rel="stylesheet" href="<?=base_url();?>assets/vendor/stylesheets/theme_table.css" />
<!--    <link rel="stylesheet" type="text/css" href="--><?//=base_url();?><!--assets/order/dataTables/dataTables.bootstrap4.min.css" >-->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/fixedHeader.dataTables.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/vendor/jquery-datatables-checkboxes/css/dataTables.checkboxes.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/datepicker4/css/gijgo.min.css" />

    <title>АПД МТР</title>
</head>
<body class="bg-light">

<!--Header-->
<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Формирование информации о движении МТР на базе (новая форма)</a>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
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
                    <h2 class="guid_motion" data-get_guid_motion="<?php if(isset($_GET['guid_motion'])) { echo($_GET['guid_motion']); }?>" data-id_motion="<?php echo $orders_guid; ?>" >Информация о движении МТР на базе</h2>
                </div>
                <div class="card-body">
                    <p>
                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Сформированна на основании:
                        </a>
                        <a class="btn btn-info" href="<?=base_url();?>Main/motion?string_check=<?php echo($_GET['string_check']); ?>" role="button">
                            Вернуться в основную форму
                        </a>
                    </p>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <ul>
                                <?php foreach($orders_name as $item_orders): ?>
                                    <li class="id_number_orders" data-id_order="<?php echo($item_orders['id_bond_all_orders']); ?>">Распоряжения № <?php echo($item_orders['number_orderMTR']); ?> от <?php echo(date('d-m-Y', strtotime($item_orders['date_orderMTR']))); ?> </li>
                                <?php endforeach; ?>
                            </ul>
                            <label for="author_order">Исполнитель</label>
                            <?php foreach($author as $item_author): ?>
                                <input type="text" class="form-control" id="author_order" name="author_order"  disabled
                                       value="<?php if(isset($item_author['sername'])) { echo($item_author['sername']." ".$item_author['name'] ); } ?>"
                                >
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>

            <!--------------------------------------------------------------------->

                <div class="card mb-4">
                    <form name="frm-example" id="frm-example" method="POST">
                    <table id="many_mtr" class="many_mtr compact table-bordered table-hover table-sm" style="width:100%">
                        <thead>
                        <tr class="text-center" style="font-size: 8pt;">
                            <th></th>
                            <th >Наименование МТР</th>
                            <th >Код МТР</th>
                            <th >Кол-во</th>
                            <th >Номер партии</th>
                            <th >Ед.изм.</th>
                            <th >Наименование объекта</th>
                            <th >Инвентарный № объекта</th>
                            <th >Наименование транзитного* <br/> или конечного получателя груза</th>
                            <th >Наименование филиала получателя</th>
                            <th >Приоритет(1,2,3)**</th>
                            <th >Примечание по доставке</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $n=0; foreach($orders as $item): ?>
                            <tr>
                                <td>
                                    <?php if(isset($item['id_order'])) echo($item['id_order']); ?>
                                </td>
                                <td>
                                    <input type="text" class="id_order_mtr_class" data-id_order_mtr="<?php if(isset($item['id_order'])) echo($item['id_order']); ?>" disabled
                                           value="<?php if(isset($item['nameMTR'])) echo($item['nameMTR']); ?>"></td>
                                <td><input type="text" class="sum_mtr" disabled
                                           data-sum_mtr="<?php if(isset($item['sumMTR'])) echo($item['sumMTR']); ?>"
                                           value="<?php if(isset($item['sumMTR'])) echo($item['sumMTR']); ?>"
                                    ></td>
                                <td><input type="text" class="code_mtr_class " data-bond_guid_motion_date="<?php echo($bond_guid_motion_date); ?>" disabled
                                           value="<?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?>"
                                    ></td>
                                <td><input type="text" class="numberPart" disabled
                                           value="<?php if(isset($item['numberPart'])) echo($item['numberPart']); ?>"
                                    ></td>
                                <td><input type="text" class="sizeMTR " id="sizeMTR"  disabled
                                           value="<?php if(isset($item['sizeMTR'])) echo($item['sizeMTR']); ?>"
                                    ></td>
                                <td><input type="text" class="ukObjectMTR" id="ukObjectMTR"  disabled
                                           value="<?php if(isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?>"
                                    ></td>
                                <td><input type="text" class="numberObjectMTR" id="numberObjectMTR"  disabled
                                           value="<?php if(isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?>"
                                    ></td>
                                <td><input type="text" class="address_orderMTR" id="address_orderMTR"  disabled
                                           value="<?php if(isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?>"
                                    ></td>
                                <td><input type="text" class="filialMTR" id="filialMTR"  disabled
                                           value="<?php if(isset($item['filialMTR'])) echo($item['filialMTR']); ?>"
                                    ></td>
                                <td><input type="text" class="deliveryMTR" id="deliveryMTR"  disabled
                                           value="<?php if(isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?>"
                                    ></td>
                                <td><input type="text" class="noteMTR" id="noteMTR"  disabled
                                           value="<?php if(isset($item['noteMTR'])) echo($item['noteMTR']); ?>"
                                    ></td>
                            </tr>
                        <?php $n=$n+1; endforeach; ?>
                        </tbody>
                    </table>

                    <table class="motion_table compact table-bordered table-hover table-sm" style="width:100%">
                        <thead>
                        <tr class="text-center" style="font-size: 8pt;">
                            <th colspan="3" rowspan="1" style="width: 15%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                                data-original-title="Указывается представителем базы или участка погрузочно-разгрузочных работ по запросу перевозчика">Массогабаритные характеристики***</th>
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
                        <tr class="text-center" style="font-size: 8pt;">
                            <th data-align="center">Длина, м</th>
                            <th data-align="center">Ширина, м</th>
                            <th data-align="center">Высота, м</th>
                            <th data-align="center">№ накладной</th>
                            <th data-align="center">Дата накладной</th>
                        </tr>
                        <tr class="text-center" style="font-size: 8pt; background: cornsilk">
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
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input style="font-size: 9pt;" name="length_motion[]" type="text" class="length_motion form-control input-block"  value=""></td>
                                <td><input style="font-size: 9pt;" name="width_motion[]" type="text" class="width_motion form-control input-block" value=""></td>
                                <td><input style="font-size: 9pt;" name="height_motion[]" type="text" class="height_motion form-control input-block" value=""></td>
                                <td><input style="font-size: 9pt;" name="weight_motion[]" type="text" class="weight_motion form-control input-block" value=""></td>
                                <td><input style="font-size: 9pt;" name="total_motion[]" type="text" class="total_motion form-control input-block" value=""></td>
                                <td><div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateRequest_motion[]" type="text" class="dateRequest_motion form-control date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>
                                <td><input style="font-size: 9pt;" name="infoShipments_motion[]" type="text" class="infoShipments_motion form-control input-block" value=""></td>
                                <td><div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateShipments_motion[]" type="text" class="dateShipments_motion form-control date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>
                                <td><input style="font-size: 9pt;" name="cargo_motion[]" type="text" class="cargo_motion form-control input-block" value=""></td>
                                <td><input style="font-size: 9pt;" name="tranzit_motion[]" type="text" class="tranzit_motion form-control input-block" value=""></td>
                                <td><input style="font-size: 9pt;" name="shipped_motion[]" type="text" class="shipped_motion form-control input-block" value=""></td>
                                <td><input style="font-size: 9pt;" name="remains_motion[]" type="text" class="remains_motion form-control input-block" value=""></td>
                                <td><input style="font-size: 9pt;" name="numberOverhead_motion[]" type="text" class="numberOverhead_motion form-control input-block" value=""></td>
                                <td><div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateOverhead_motion[]" type="text" class="dateOverhead_motion form-control input-block date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>
                                <td><textarea style="width:100%; height:30px; font-size: 9pt;" name="note_motion[]" class="form-control note_motion" ></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            <!--------------------------------------------------------------------->
            <div class="row">
                <div class="col-sm-6">
                    <!--                    Кнопки управления при первичном занесение данных в БД-->
                    <button id="saveToTable" class="ButtonSaveToTable btn btn-outline-success">Сохранить<i class="fa fa-save"></i></button>
                    <button id="cancelToEditOrder" onclick="cancelCreateMotion();" type="button" class="ButtonCancelEditToTable btn btn-outline-warning">Отмена <i class="fa fa-undo"></i></button>
                </div>
            </div
            </form>
        </div>
    </div>
</section>

<!-- end: create Motion -->
<div class="modal_loading"></div> <!--окно загрузки-->

<script src="<?=base_url();?>assets/order/jquery-3.3.1.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/bootstrap-4.2.1/js/bootstrap.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/datepicker4/js/gijgo.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/datepicker4/js/messages/messages.ru-ru.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/bootAdmin/js/bootstrap.bundle.min.js" type="text/javascript"> </script>
<script src="<?=base_url();?>assets/order/bootAdmin/js/bootadmin.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/dataTables.fixedColumns.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/vendor/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js" type="text/javascript"></script>

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
        var table = $('#many_mtr').DataTable({
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
            columnDefs: [ {
                "searchable": false,
                "orderable": false,
                targets: 0,
                'checkboxes': true
            } ],
            'order': [[1, 'asc']]
        });

        // Handle form submission event
        $('#frm-example').on('submit', function(e){

            var rows_selected = table.column(0).checkboxes.selected();
            var x= rows_selected.join(",");
            var arr = x.split(',');
            console.log(arr);
            // Prevent actual form submission
            e.preventDefault();

            check_validation = 1;
            if (check_validation == 1 ){
                if (confirm("Вы точно хотите сохранить данные?")) {
//GUID всего отчета "информаиця о движении МТР"
                    var id_guid = document.getElementsByClassName("guid_motion");
                    var guid = id_guid[0].dataset.id_motion;
                    var guid_motion = id_guid[0].dataset.get_guid_motion;
                    console.log(guid_motion);
                    if (guid_motion == undefined || guid_motion == null || guid_motion == false) {
                        console.log("Переменная не существует");
                        //GUID для строки внутри отчета "информаиця о движении МТР"
                        var id_bond_guid_motion_date = document.getElementsByClassName("code_mtr_class");
                        var guid_bond_guid_motion_date = id_bond_guid_motion_date[0].dataset.bond_guid_motion_date; //GUID строки для удобства следующего поиска
                        // console.log(guid_bond_guid_motion_date);
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
                                var arr_length =arr.length;
                                console.log(arr_length);

                                    var length_motion = document.getElementsByClassName('length_motion')[0].value;
                                    var width_motion = document.getElementsByClassName('width_motion')[0].value;
                                    var height_motion = document.getElementsByClassName('height_motion')[0].value;
                                    var weight_motion = document.getElementsByClassName('weight_motion')[0].value;
                                    var total_motion = document.getElementsByClassName('total_motion')[0].value;
                                    var dateRequest_motion = document.getElementsByClassName('dateRequest_motion')[0].value;
                                    var infoShipments_motion = document.getElementsByClassName('infoShipments_motion')[0].value;
                                    var dateShipments_motion = document.getElementsByClassName('dateShipments_motion')[0].value;
                                    var cargo_motion = document.getElementsByClassName('cargo_motion')[0].value;
                                    var tranzit_motion = document.getElementsByClassName('tranzit_motion')[0].value;
                                    var shipped_motion = document.getElementsByClassName('shipped_motion')[0].value;
                                    var remains_motion = document.getElementsByClassName('remains_motion')[0].value;
                                    var numberOverhead_motion = document.getElementsByClassName('numberOverhead_motion')[0].value;
                                    var dateOverhead_motion = document.getElementsByClassName('dateOverhead_motion')[0].value;
                                    var note_motion = document.getElementsByClassName('note_motion')[0].value;
                                    var sumMTR = document.getElementsByClassName('sum_mtr')[0].value;
                                    var number_id_order_mtr = arr;               //id из таблицы order_mtr

                                    $.ajax({
                                        url: "<?=base_url();?>Main/saveManyMotion",
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
                                            id_bond_all_motion: data_id_all_motion,                 //id с таблицы all_motion (id всего отчета)
                                            guid: guid,                                             //GUID всего отчета "информаиця о движении МТР"
                                            guid_bond_guid_motion_date: guid_bond_guid_motion_date,
                                            number_id_order_mtr : number_id_order_mtr                                     //Передаем id все выбранных строк для таблицы Motion
                                        },
                                        success: function (data) {
                                            console.log(data);
                                            window.location = "<?=base_url();?>Main/edit_motion?guid=" + guid;
                                        }
                                    });
                                    m++;

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
                                }
                            });
                            check_orders++;
                        }
                    } else {
                        /*формирование запроса к базе motion*/
                        //GUID для строки внутри отчета "информаиця о движении МТР"
                        var id_bond_guid_motion_date = document.getElementsByClassName("guid_motion");
                        var guid_bond_guid_motion_date = id_bond_guid_motion_date[0].dataset.get_guid_motion; //GUID строки для удобства следующего поиска
                        // console.log(guid_bond_guid_motion_date);
                        $.ajax({
                            url: "<?=base_url();?>Main/selectIdAllMotion",
                            type: "POST",
                            data: {
                                guid_bond_guid_motion_date : guid_bond_guid_motion_date
                            },
                            success: function(data_id_all_motion) {
                                console.log(data_id_all_motion);
                                var arr_length = arr.length;
                                console.log(arr_length);

                                var length_motion = document.getElementsByClassName('length_motion')[0].value;
                                var width_motion = document.getElementsByClassName('width_motion')[0].value;
                                var height_motion = document.getElementsByClassName('height_motion')[0].value;
                                var weight_motion = document.getElementsByClassName('weight_motion')[0].value;
                                var total_motion = document.getElementsByClassName('total_motion')[0].value;
                                var dateRequest_motion = document.getElementsByClassName('dateRequest_motion')[0].value;
                                var infoShipments_motion = document.getElementsByClassName('infoShipments_motion')[0].value;
                                var dateShipments_motion = document.getElementsByClassName('dateShipments_motion')[0].value;
                                var cargo_motion = document.getElementsByClassName('cargo_motion')[0].value;
                                var tranzit_motion = document.getElementsByClassName('tranzit_motion')[0].value;
                                var shipped_motion = document.getElementsByClassName('shipped_motion')[0].value;
                                var remains_motion = document.getElementsByClassName('remains_motion')[0].value;
                                var numberOverhead_motion = document.getElementsByClassName('numberOverhead_motion')[0].value;
                                var dateOverhead_motion = document.getElementsByClassName('dateOverhead_motion')[0].value;
                                var note_motion = document.getElementsByClassName('note_motion')[0].value;
                                var sumMTR = document.getElementsByClassName('sum_mtr')[0].value;
                                var number_id_order_mtr = arr;               //id из таблицы order_mtr

                                $.ajax({
                                    url: "<?=base_url();?>Main/saveManyMotion",
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
                                        id_bond_all_motion: data_id_all_motion,                 //id с таблицы all_motion (id всего отчета)
                                        guid: guid_motion,                                             //GUID всего отчета "информаиця о движении МТР"
                                        guid_bond_guid_motion_date: guid_bond_guid_motion_date,
                                        number_id_order_mtr: number_id_order_mtr                                     //Передаем id все выбранных строк для таблицы Motion
                                    },
                                    success: function (data) {
                                        console.log(data);
                                        window.location = "<?=base_url();?>Main/edit_motion?guid=" + guid_bond_guid_motion_date;
                                    }
                                });
                            }
                        });
                    }
                    }
            } else {
                alert("Обнаружены ошибки при сохранении формы, исправте ошибки и попробуйте снова");
            }
        });
//Вывод даты
        date_row();
    });
        
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