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
                    <h2 class="guid_motion" data-id_motion="<?php echo $orders_guid; ?>" >Информация о движении МТР на базе</h2>
                </div>
                <div class="card-body">
                    <p>
                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Сформированна на основании:
                        </a>
                        <a class="btn btn-info" href="<?=base_url();?>Main/motion_add_many?string_check=<?php if(isset($string_check)) { echo($string_check);} else { echo($_GET['string_check']); } ?>" role="button">
                            Множественная вставка значений
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
            <?php $n=0; $accordion_flag=0; foreach($orders as $item): ?>
                <div class="card mb-4">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="alert-success card-header font-weight-bold" id="heading<?php echo ($accordion_flag); ?>">
                                <a href="#" data-toggle="collapse" data-target="#collapse<?php echo ($accordion_flag); ?>" aria-expanded="false" aria-controls="collapse<?php echo ($accordion_flag); ?>" class="collapsed">
                                    <div class="row">
                                        <div class="col text-primary">
                                           Наименование МТР - <input type="text" class="id_order_mtr_class" data-id_order_mtr="<?php if(isset($item['id_order'])) echo($item['id_order']); ?>" disabled style="width: 20%;"
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
                            <div id="collapse<?php echo ($accordion_flag); ?>" class="collapse" aria-labelledby="heading<?php echo ($accordion_flag); ?>" data-parent="#accordionExample" style="">
                                <div class="card-body">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td>Код МТР
                                            </td>
                                            <td><input type="text" class="code_mtr_class " data-bond_guid_motion_date="<?php echo($bond_guid_motion_date); ?>" disabled
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
                                            <td>Наименование объекта
                                            </td>
                                            <td><input type="text" class="ukObjectMTR" id="ukObjectMTR"  disabled
                                                       value="<?php if(isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?>"
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
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                <table class="motion_table compact table table-bordered table-hover table-sm" style="width:100%">
                    <thead>
                    <tr class="text-center" style="font-size: 8pt;">
                        <th colspan="3" rowspan="1" style="" data-toggle="tooltip"  data-placement="left" data-html="true"
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
                        <th rowspan="2" class="ButtonAction">Операция</th>
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
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                    <div class="card-footer bg-white">
                        <button type="button"
                                data-number_table="<?php echo($n); ?>"
                                data-sum_mtr="<?php if(isset($item['sumMTR'])) echo($item['sumMTR']); ?>"
                                data-id_order_mtr="<?php if(isset($item['id_order'])) echo($item['id_order']); ?>"
                                data-id_motion="<?php if(isset($item['id_motion'])) echo($item['id_motion']); ?>"
                                onclick="add_row_new(this);"
                                class="button_add_row btn btn-primary btn-sm" >Добавить строку
                        </button>
                    </div>
                </div>
                        </div>
                    </div>
                </div>
            <?php $n=$n+1; $accordion_flag=$accordion_flag+1; endforeach; ?>
            <!--------------------------------------------------------------------->

            <div class="row">
                <div class="col-sm-6">
                    <!--                    Кнопки управления при первичном занесение данных в БД-->
<!--                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">Внесение данным выбранным элементам</button>-->
                    <button id="saveToTable" onclick="saveMotion();" type="button" class="ButtonSaveToTable btn btn-outline-success">Сохранить <i class="fa fa-save"></i></button>
                    <button id="cancelToEditOrder" onclick="cancelCreateMotion();" type="button" class="ButtonCancelEditToTable btn btn-outline-warning">Отмена <i class="fa fa-undo"></i></button>
                </div>
            </div
        </div>
    </div>
</section>

<!-- end: create Motion -->
<div class="modal_loading"></div> <!--окно загрузки-->
<!--Модуль добавления строки-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Внесение данным выбранным МТР</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Заполните ниже поля и нажмите "Добавить"</p>
                Дата заявки на отгрузку <div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateRequest_motion[]" type="text" class="dateRequest_motion form-control date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>
                Заявка на контейнер/автотранспорт <input style="font-size: 9pt;" name="infoShipments_motion[]" type="text" class="infoShipments_motion form-control input-block" value="">
                Дата отгрузки <div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateShipments_motion[]" type="text" class="dateShipments_motion form-control date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>
                Груз сформирован в контейнер/автотранспорт <input style="font-size: 9pt;" name="cargo_motion[]" data-sum_mtr="' + sum_mtr + '" data-id_order_mtr="' + id_order_mtr + '" type="text" class="cargo_motion form-control input-block" value="">
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
    var add_info = 0; //глобальная переменная, для проверки добавления хоты бы одной строки
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
            "info":      false,
            columnDefs: [ {
                sortable: false,
                "class": "index",
                targets: 0
            } ]
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
        var a = 0; //счетчик строк
        var b = 0; //счетчик МТР
        var number_row = document.getElementsByClassName('shipped_motion').length;
        while (a < number_row) {
            var number_row_a = document.getElementsByClassName('shipped_motion')[a].value;
            console.log('Строка ' + a + ' значение -'+number_row_a);
            a++;
        }

        // var n_sumMTR = document.getElementsByClassName("sum_mtr"); //собираем всю инфу с элемента с классом sum_mtr
        var length_sum_mtr = document.getElementsByClassName('sum_mtr').length; //общее кол-во строк МТР
        // var length_shipped_morions = document.getElementsByClassName('shipped_motion').length;
        // console.log('length_shipped_morions- '+length_shipped_morions);
        // console.log(typeof n_sumMTR);
        console.log('Кол-во позиций-'+length_sum_mtr);
        console.log('Кол-во добавленных строк-'+length_codeMTR);
        // var shipped_motion_class = $('.shipped_motion');
        while (b < length_sum_mtr) {
           var code_mtr = document.getElementsByClassName('code_mtr_class')[b].value;
           console.log('Код МТР-'+code_mtr);
           if (typeof (document.getElementsByClassName('remains_motion')[b]) !== 'undefined') {
               shipped_motion_class.eq(a).removeClass('is-invalid');
               shipped_motion_class.eq(a).addClass('is-valid');
           }
        b++;
        }
        // while (a < length_shipped_morions) {
        //     var sumMTR = Number(n_sumMTR[a].dataset.sum_mtr);                                           //общее кол-во необходимого отгрузить
        //     var shipped_motion = Number(document.getElementsByClassName('shipped_motion')[a].value);    //кол-во которое отгружаем
        //     var remains_motion = Number(document.getElementsByClassName('remains_motion')[a].value);    //остаток
        //     remains_motion = sumMTR - shipped_motion;
        //
        //     console.log("Кол-во которое необходим увезти-" + sumMTR);
        //     console.log("Кол-во которое увозим-" + shipped_motion);
        //     console.log("Остаток-" + remains_motion);
        //     if (sumMTR >= shipped_motion) {
        //         shipped_motion_class.eq(a).removeClass('is-invalid');
        //         shipped_motion_class.eq(a).addClass('is-valid');
        //         Number(document.getElementsByClassName('remains_motion')[a].value = remains_motion);
        //         arr[arr.length] = 1;
        //     } else {
        //         shipped_motion_class.eq(a).removeClass('is-valid');
        //         shipped_motion_class.eq(a).addClass('is-invalid');
        //         Number(document.getElementsByClassName('remains_motion')[a].value = remains_motion);
        //         arr[arr.length] = 0;
        //     }
        //     a++;
        // }

//Итоги валидации
       console.log(arr);
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
        // var check_validation = 1;
        if (check_validation == 1 ){
            // ----------------------------------------------
            // Тестовая хрень, потом можно удалить
            var m = 0;
            var number_codeMTR = document.getElementsByClassName('cargo_motion').length; //считаем кол-во строк для добавления в базу
            if (add_info == 0) {
                console.log("Нет добавленных строк")
            } else {
                console.log("Кол-во позиций МТР-" + number_codeMTR);
                while (m < number_codeMTR) {
                    if (typeof (document.getElementsByClassName('remains_motion')[m]) !== 'undefined') {
                        var remains_motion = document.getElementsByClassName('remains_motion')[m].value;
                        console.log("По позиции № "+ m +" необходимо додоставить: " + remains_motion);
                    } else {
                        remains_motion = 0;
                        console.log("По позиции № "+ m +" необходимо додоставить: " + remains_motion);
                        // console.log("Переменная remains_motion не существует, ее номер - " + m)
                    }
                m++;
                }

            }

            // ----------------------------------------------

//            if (confirm("Вы точно хотите сохранить данные?")) {
////GUID всего отчета "информаиця о движении МТР"
//                var id_guid = document.getElementsByClassName("guid_motion");
//                var guid = id_guid[0].dataset.id_motion;
//                console.log(guid);
////GUID для строки внутри отчета "информаиця о движении МТР"
//                var id_bond_guid_motion_date = document.getElementsByClassName("code_mtr_class");
//                var guid_bond_guid_motion_date = id_bond_guid_motion_date[0].dataset.bond_guid_motion_date; //GUID строки для удобства следующего поиска
////                console.log(guid_bond_guid_motion_date);
//                var m = 0;
///*формирование запроса к базе all_motion*/
//                $.ajax({
//                    url : "<?//=base_url();?>//Main/saveAllMotion",
//                    type: "POST",
//                    data: {
//                        guid : guid
//                    },
//                    success: function (data_id_all_motion) {
//                        console.log(data_id_all_motion); // id с таблицы all_motion (id всего отчета)
//
///*формирование запроса к базе motion*/
//                        var n = document.getElementsByClassName("cargo_motion"); //находим элемента в классе которого есть информация об id из таблицы order_mtr
//                        var n_sumMTR = document.getElementsByClassName("cargo_motion");
//                        var n_sumMTR_length = document.getElementsByClassName("cargo_motion").length;
////                        console.log(n_sumMTR_length);
//                        var test_number_codeMTR = document.getElementsByClassName('sum_mtr').length; //считаем кол-во строк для добавления(изменения) в таблицы motion
//                        console.log("test"+test_number_codeMTR);
//                        var number_codeMTR = document.getElementsByClassName('cargo_motion').length; //считаем кол-во строк для добавления в базу
//                        console.log(number_codeMTR);
//                        while (m < number_codeMTR) {
//                                var length_motion = document.getElementsByClassName('length_motion')[m].value;
//                                var width_motion = document.getElementsByClassName('width_motion')[m].value;
//                                var height_motion = document.getElementsByClassName('height_motion')[m].value;
//                                var weight_motion = document.getElementsByClassName('weight_motion')[m].value;
//                                var total_motion = document.getElementsByClassName('total_motion')[m].value;
//                                var dateRequest_motion = document.getElementsByClassName('dateRequest_motion')[m].value;
//                                var infoShipments_motion = document.getElementsByClassName('infoShipments_motion')[m].value;
//                                var dateShipments_motion = document.getElementsByClassName('dateShipments_motion')[m].value;
//                                var cargo_motion = document.getElementsByClassName('cargo_motion')[m].value;
//                                var tranzit_motion = document.getElementsByClassName('tranzit_motion')[m].value;
//                                var shipped_motion = document.getElementsByClassName('shipped_motion')[m].value;
//                                var remains_motion = document.getElementsByClassName('remains_motion')[m].value;
//                                var numberOverhead_motion = document.getElementsByClassName('numberOverhead_motion')[m].value;
//                                var dateOverhead_motion = document.getElementsByClassName('dateOverhead_motion')[m].value;
//                                var note_motion = document.getElementsByClassName('note_motion')[m].value;
//                                var sumMTR = n_sumMTR[m].dataset.sum_mtr;
//                                var number_id_order_mtr = n[m].dataset.id_order_mtr; //из data-id_order_mtr забирают информацию об id из таблицы order_mtr
//                                //$.ajax({
//                                //    url: "<?////=base_url();?>////Main/saveMotion",
//                                //    type: "POST",
//                                //    data: {
//                                //        length_motion: length_motion,
//                                //        width_motion: width_motion,
//                                //        height_motion: height_motion,
//                                //        weight_motion: weight_motion,
//                                //        total_motion: total_motion,
//                                //        cargo_motion: cargo_motion,
//                                //        dateRequest_motion: dateRequest_motion,
//                                //        dateShipments_motion: dateShipments_motion,
//                                //        infoShipments_motion: infoShipments_motion,
//                                //        tranzit_motion: tranzit_motion,
//                                //        shipped_motion: shipped_motion,
//                                //        sumMTR: sumMTR,
//                                //        remains_motion: remains_motion,
//                                //        numberOverhead_motion: numberOverhead_motion,
//                                //        dateOverhead_motion: dateOverhead_motion,
//                                //        note_motion: note_motion,
//                                //        number_id_order_mtr: number_id_order_mtr,               //id из таблицы order_mtr
//                                //        id_bond_all_motion: data_id_all_motion,                 //id с таблицы all_motion (id всего отчета)
//                                //        guid: guid,                                             //GUID всего отчета "информаиця о движении МТР"
//                                //        guid_bond_guid_motion_date: guid_bond_guid_motion_date
//                                //    },
//                                //    success: function (data) {
//                                //        console.log(data);
//                                //        window.location = "<?////=base_url();?>////Main/edit_motion?guid=" + guid;
//                                //    }
//                                //});
//                                m++;
//                        }
//                        if (number_codeMTR == 0) {
//                            window.location = "<?//=base_url();?>//Main/edit_motion?guid=" + guid;
//                        }
//                    }
//                });
///*формирование запроса к базе all_orders*/
//                var check_orders = 0;
//                var number_orders = document.getElementsByClassName('id_number_orders').length;
//                var n_orders = document.getElementsByClassName("id_number_orders");
//                while (check_orders < number_orders) {
//                    var number_id_order = n_orders[check_orders].dataset.id_order;
//                    $.ajax({
//                        url : "<?//=base_url();?>//Main/saveGUIDAllMotionInOrders",
//                        type: "POST",
//                        data: {
//                            guid : guid,
//                            id_order : number_id_order
//                        },
//                        success: function (data) {
////                            console.log(data);
//                        }
//                    });
//                    check_orders++;
//                }
//            }
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

//Добавление строки 
    function add_row_new(id){
        add_info = 1; //проверка на добавлении строки
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
        var arr11 = '<input style="font-size: 9pt;" name="remains_motion[]" type="text" disabled class="remains_motion form-control input-block" value="" >';
        var arr12 = '<input style="font-size: 9pt;" name="numberOverhead_motion[]" type="text" class="numberOverhead_motion form-control input-block" value="">';
        var arr13 = '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group"><input style="font-size: 9pt;" name="dateOverhead_motion[]" type="text" class="dateOverhead_motion form-control input-block date_order_id" value="" autocomplete="off" role="input"><span class="input-group-addon" role="right-icon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
        var arr14 = '<textarea style="width:100%; height:30px; font-size: 9pt;" name="note_motion[]" class="form-control note_motion" ></textarea>';
        var arr18 = '<a href="#" id="deleterow" onclick="deleteRowTable(this);" data-id-row-tablemtr="" >Удалить</a>';

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
        row_data.splice(18, 1, arr18);

        table.eq(let).row.add(row_data).draw(true);
        //Вывод даты
        date_row();
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
                url: "<?=base_url();?>Main/deleteRowTable",
                data: {id : id_row_order},
                success: function(data) {
                    console.log(data);
                    $('.tert tbody tr').each(function(i) {
                        var number = i + 1;
                        $(this).find('td:first').text(number+".");
                    });
                }
            });
        }
    }

</script>