<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?=base_url();?>assets/order/favicon.png" type="image/png">

    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/bootstrap-4.2.1/css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/bootAdmin/css/fontawesome-all.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/bootAdmin/css/bootadmin.css" >

<!--    <link rel="stylesheet" type="text/css" href="--><?//=base_url();?><!--assets/order/dataTables/dataTables.bootstrap4.min.css" >-->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/fixedHeader.dataTables.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/datepicker4/css/gijgo.min.css" />

    <title>АПД МТР</title>
</head>
<body class="bg-light">

<!--Header-->
<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Формирование информации о движении МТР на базе </a>
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
                    </p>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <ul>
                                <?php foreach($orders_name as $item_orders): ?>
                                    <li class="id_number_orders" data-id_order="<?php echo($item_orders['id_bond_all_orders']); ?>">Распоряжения № <?php echo($item_orders['number_orderMTR']); ?> от <?php echo($item_orders['date_orderMTR']); ?> </li>
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
                <table id="myMotion" class="table table-bordered hover" style="width:100%">
                    <thead>
                    <tr class="text-center" style="background: rgb(224, 78, 57)">
                        <th rowspan="2" scope="row">№</th>
                        <th rowspan="2" style="width: 10%;">Код МТР</th>
                        <th rowspan="2" style="width: 40%;">Наименование МТР</th>
                        <th colspan="3" rowspan="1" style="width: 5%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                            data-original-title="Указывается представителем базы или участка погрузочно-разгрузочных работ по запросу перевозчика">Массогабаритные </br> характеристики***</th>
                        <th rowspan="2" style="width: 5%;">Ед.изм.</th>
                        <th rowspan="2" style="width: 7%;">Наименование </br> объекта</th>
                        <th rowspan="2" style="width: 7%;">Инвентарный № </br> объекта</th>
                        <th rowspan="2" style="width: 5%;">Кол-во</th>
                        <th rowspan="2" >вес 1 ед. тн.</th>
                        <th rowspan="2" >Всего тн.</th>
                        <th rowspan="2" >Груз сформирован </br>  в контейнер/автотранспорт</th>
                        <th rowspan="2" >Дата заявки </br> на отгрузку</th>
                        <th rowspan="2" >Дата отгрузки</th>
                        <th rowspan="2" >Информация об отгрузке </br> на текущую дату</th>
                        <th rowspan="2" >Отгружено</th>
                        <th rowspan="2" >Остаток</th>
                        <th rowspan="2" data-toggle="tooltip" data-placement="left"
                            data-original-title="Транзитный получатель - это участок или база по хранению и реализации МТР Югорского УМТСиК или филиала Общества,
                                который в логистической схеме доставки груза конечному получателю, выступает как база временного хранения " >Наименование транзитного* </br> или конечного получателя груза</th>
                        <th rowspan="2" >Наименование филиала </br> получателя</th>
                        <th colspan="2" rowspan="1" >Накладная формы М11</th>
                        <th rowspan="2" style="width: 5%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                            data-original-title="Режим доставки МТР:</br>
                                    1) <u>Аварийный</u> -(срочная доставка МТР к месту аварии на объектах МГ и КС или с целью исключения возникновения аварийной, сбойной ситуации)</br>
                                    2) <u>Срочный</u> - (доставка МТР для завершения выполненяемых работ, исключения срыва сроков плановых работ и т.п.)</br>
                                    3) <u>Плановый</u> - (доставка МТР поступившего согласно сроков указанных в годовой заявке филиала на приобретение МТР, не требующего срочного вовлечения в производство)</br>
                                    <font color='red'> При указании признаков: <u>аварийный</u>, <u>срочный</u>, в примечании указывается причина, по которой МТР требует внеплановой доставки.</font>" >Приоритет(1,2,3)**</th>
                        <th rowspan="2" style="width: 20%;">Примечание по доставке</th>
                        <th rowspan="2" style="width: 20%;">Общие примечания</th>
                        <th colspan="4" rowspan="1" style="background: rgb(57, 224, 119)">Заполняется транзитным участком, базой ЮУМТСиК</th>
                    </tr>
                    <tr class="text-center" style="background: rgb(224, 78, 57)">
                        <th data-align="center">Длина, м</th>
                        <th data-align="center">Ширина, м</th>
                        <th data-align="center">Высота, м</th>
                        <th data-align="center">№ накладной</th>
                        <th data-align="center">Дата накладной</th>
                        <th data-align="center" style="background: rgb(57, 224, 119)">Дата поступления МТР </br> на базу, участок</th>
                        <th data-align="center" style="background: rgb(57, 224, 119)">№ накладной </br> М 15</th>
                        <th data-align="center" style="background: rgb(57, 224, 119)">Дата накладной </br> М 15</th>
                        <th data-align="center" style="background: rgb(57, 224, 119)">Дата получения МТР </br>  филиалом получателя</th>
                    </tr>
                    <tr class="text-center" style="background: cornsilk">
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
                        <th>18</th>
                        <th>19</th>
                        <th>20</th>
                        <th>21</th>
                        <th>22</th>
                        <th>23</th>
                        <th>24</th>
                        <th>25</th>
                        <th>26</th>
                        <th>27</th>
                        <th>28</th>
                        <th>29</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($orders as $item): ?>
                        <tr>
                            <td></td>
                            <td class="code_mtr_class" data-bond_guid_motion_date="<?php echo($bond_guid_motion_date); ?>"> <?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?></td>
                            <td class="id_order_mtr_class" data-id_order_mtr="<?php if(isset($item['id_order'])) echo($item['id_order']); ?>"><?php if(isset($item['nameMTR'])) echo($item['nameMTR']); ?></td>
                            <td><input name="length_motion[]" type="text" class="length_motion form-control input-block"></td>
                            <td><input name="width_motion[]" type="text" class="width_motion form-control input-block"></td>
                            <td><input name="height_motion[]" type="text" class="height_motion form-control input-block"></td>
                            <td><?php if(isset($item['sizeMTR'])) echo($item['sizeMTR']); ?></td>
                            <td><?php if(isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?></td>
                            <td><?php if(isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?></td>
                            <td class="sum_mtr" data-sum_mtrr="<?php if(isset($item['sumMTR'])) echo($item['sumMTR']); ?>" ><?php if(isset($item['sumMTR'])) echo($item['sumMTR']); ?></td>
                            <td><input name="weight_motion[]" type="text" class="weight_motion form-control input-block"></td>
                            <td><input name="total_motion[]" type="text" class="total_motion form-control input-block"></td>
                            <td>
                                <div class="input-group ">
                                    <input name="cargo_motion[]" type="text" class="cargo_motion form-control input-block" value="">
                                    <button type="button" onclick="infoString(this);" class="copy btn btn-primary btn-sm btn-icon" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-fw fa-cog"></i></button>
                                </div>
                            </td>
                            <td><input name="dateRequest_motion[]" type="text" class="dateRequest_motion form-control date_order_id" value="" autocomplete="off"></td>
                            <td><input name="dateShipments_motion[]" type="text" class="dateShipments_motion form-control date_order_id" value="" autocomplete="off"></td>
                            <td><input name="infoShipments_motion[]" type="text" class="infoShipments_motion form-control input-block"></td>
                            <td><input name="shipped_motion[]" type="text" class="shipped_motion form-control input-block"></td>
                            <td><input name="remains_motion[]" type="text" class="remains_motion form-control input-block"></td>
                            <td><?php if(isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?></td>
                            <td><?php if(isset($item['filialMTR'])) echo($item['filialMTR']); ?></td>
                            <td><input name="numberOverhead_motion[]" type="text" class="numberOverhead_motion form-control input-block"></td>
                            <td><input name="dateOverhead_motion[]" type="text" class="dateOverhead_motion form-control input-block date_order_id" value="" autocomplete="off"></td>
                            <td><?php if(isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?></td>
                            <td><?php if(isset($item['noteMTR'])) echo($item['noteMTR']); ?></td>
                            <td><textarea style="width:100%; height:30px" name="note_motion[]" class="form-control note_motion"></textarea></td>
<!--Информация заполняемая участками-->
                            <td><input name="dateArrival_motion[]" type="text" class="dateArrival_motion form-control date_order_id" value="" disabled autocomplete="off"></td>
                            <td><input name="numberM15_motion[]" type="text" class="numberM15_motion form-control input-block" disabled></td>
                            <td><input name="dateM15_motion[]" type="text" class="dateM15_motion form-control input-block date_order_id" value="" disabled autocomplete="off"></td>
                            <td><input name="dateFilial_motion[]" type="text" class="dateFilial_motion form-control date_order_id" value="" disabled autocomplete="off"></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <br />
            <div class="row">
                <div class="col-sm-6">
                    <!--                    Кнопки управления при первичном занесение данных в БД-->
                    <button id="saveToTable" onclick="saveMotion();" type="button" class="ButtonSaveToTable btn btn-outline-success">Сохранить <i class="fa fa-save"></i></button>
                    <button id="cancelToEditOrder" onclick="cancelCreateMotion();" type="button" class="ButtonCancelEditToTable btn btn-outline-warning">Отмена <i class="fa fa-undo"></i></button>
                </div>
            </div
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
        var table = $('#myMotion').DataTable({
            fixedHeader: true,
            "scrollY":   '40vh',
            "scrollX": true,
            "searching": false,
            "paging":    false,
//            "ordering":  false,
            "info":      false,
            columnDefs: [ {
                sortable: false,
                "class": "index",
                targets: 0
            } ],
//Фиксация трех первых столбцов
            order: [[ 1, 'asc' ]],
            fixedColumns:   {
                leftColumns: 3
            }
        });
// Sort by column 2 and redraw
        table
            .order( [ 2, 'asc' ] )
            .draw();
//Нумерация строк
        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
//Вывод даты
        $('.date_order_id').each(function(){
            $(this).datepicker({
                uiLibrary: 'bootstrap',
                locale: 'ru-ru',
                format: 'dd-mm-yyyy'
            });
        });
    });

//Валидация форм
    function validation_form() {
        var arr = []; //Счетчик ошибок при заполнении формы
//Валидация Примечания
        var length_codeMTR = document.getElementsByClassName('sum_mtr').length;
        var a = 0;
        var n_sumMTR = document.getElementsByClassName("sum_mtr");
        var shipped_motion_class = $('.shipped_motion');
        console.log(length_codeMTR);
        while (a < length_codeMTR) {

            var sumMTR = Number(n_sumMTR[a].dataset.sum_mtrr);
            var shipped_motion = Number(document.getElementsByClassName('shipped_motion')[a].value);
            console.log(shipped_motion);
            console.log(sumMTR);

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
        console.log(check_validation);
//        check_validation = 1;
        if (check_validation == 1 ){
            console.log("true");
            if (confirm("Вы точно хотите сохранить данные?")) {
//GUID для отчета "информаиця о движении МТР"
                var id_guid = document.getElementsByClassName("guid_motion");
                var guid = id_guid[0].dataset.id_motion;
                console.log(guid);
//GUID для строки внутри отчета "информаиця о движении МТР"
                var id_bond_guid_motion_date = document.getElementsByClassName("code_mtr_class");
                var guid_bond_guid_motion_date = id_bond_guid_motion_date[0].dataset.bond_guid_motion_date;
                console.log(guid_bond_guid_motion_date);
                
                var author_motion = document.getElementById("author_order").value;
                console.log(author_motion);
                var m = 0;
/*формирование запроса к базе all_motion*/
                $.ajax({
                    url : "<?=base_url();?>Main/saveAllMotion",
                    type: "POST",
                    data: {
                        guid : guid,
                        author_motion : author_motion
                    },
                    success: function (data_id_all_motion) {
                        console.log(data_id_all_motion);
                                                
/*формирование запроса к базе motion*/
                        var n = document.getElementsByClassName("id_order_mtr_class");
                        var n_sumMTR = document.getElementsByClassName("sum_mtr");
                        var number_codeMTR = document.getElementsByClassName('id_order_mtr_class').length;
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
                                var shipped_motion = document.getElementsByClassName('shipped_motion')[m].value;
                                var remains_motion = document.getElementsByClassName('remains_motion')[m].value;
                                var numberOverhead_motion = document.getElementsByClassName('numberOverhead_motion')[m].value;
                                var dateOverhead_motion = document.getElementsByClassName('dateOverhead_motion')[m].value;
                                var note_motion = document.getElementsByClassName('note_motion')[m].value;
                                var sumMTR = n_sumMTR[m].dataset.sum_mtrr;

                                var number_id_order_mtr = n[m].dataset.id_order_mtr;
                                console.log(length_motion);
                                console.log(number_id_order_mtr);
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
                                        shipped_motion: shipped_motion,
                                        sumMTR: sumMTR,
                                        remains_motion: remains_motion,
                                        numberOverhead_motion: numberOverhead_motion,
                                        dateOverhead_motion: dateOverhead_motion,
                                        note_motion: note_motion,
                                        number_id_order_mtr: number_id_order_mtr,
                                        id_bond_all_motion: data_id_all_motion,
                                        guid: guid,
                                        guid_bond_guid_motion_date: guid_bond_guid_motion_date,
                                        author_motion: author_motion
                                    },
                                    success: function (data) {
                                        console.log(data);
                                        window.location = "<?=base_url();?>Main/edit_motion?guid=" + guid;
                                    }
                                });
                                m++;
                        }
                    }
                });
/*формирование запроса к базе all_orders*/
                var check_orders = 0;
                var number_orders = document.getElementsByClassName('id_number_orders').length;
                var n_orders = document.getElementsByClassName("id_number_orders");
                while (check_orders < number_orders) {
                    var number_id_order = n_orders[check_orders].dataset.id_order;
                    console.log(number_id_order);
                    $.ajax({
                        url : "<?=base_url();?>Main/saveGUIDAllMotionInOrders",
                        type: "POST",
                        data: {
                            guid : guid,
                            id_order : number_id_order
                        },
                        success: function (data) {
                            console.log(data);
                        }
                    });
                    check_orders++;
                }
            }
        } else {
            alert("Обнаружены ошибки при сохранении формы, исправте ошибки и попробуйте снова");
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