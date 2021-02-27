<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?=base_url();?>assets/order/favicon.png" type="image/png">

    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/bootstrap-4.2.1/css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/bootAdmin/css/fontawesome-all.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/bootAdmin/css/bootadmin.css" >

    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/dataTables.bootstrap4.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/fixedHeader.dataTables.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/datepicker4/css/gijgo.min.css" />

    <title>info-МТР</title>
</head>
<body class="bg-light">

<!--Header-->
<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="navbar-brand" href="<?=base_url();?>">АПД МТР</a>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a href="#" class="nav-link" data-toggle="dropdown"><i class="fa fa-envelope"></i> 5</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                    <a href="#" class="dropdown-item">test</a>
                    <a href="#" class="dropdown-item">test2</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link" data-toggle="dropdown"><i class="fa fa-bell"></i> 3</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                    <a href="#" class="dropdown-item">test4</a>
                    <a href="#" class="dropdown-item">test5</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#" id="dd_user" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Admin</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                    <a href="#" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!--Edit Order-->
<?php if(isset($order) && isset($info_order)) { ?>
    <section>
    <div class="d-flex">
        <div class="content p-4">
            <div class="card mb-4">
                <div class="card-header bg-white font-weight-bold">
                    <button type="button" onclick="showOrders();" name="order" class="btn btn-success">Вернуться к распоряжениям</button>
                </div>
                <a href="<?php print site_url();?>assets/uploads/sample-xlsx.xlsx" class="btn btn-info btn-sm"><i class="fa fa-file-excel"></i> Sample .XLSX</a>

                <?php foreach($info_order as $item_info): ?>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="number_order_id">Распоряжение №*</label>
                            <input data-toggle="tooltip" data-html="true" name="number_order_id" id="number_order_id" type="text"
                                   class="number_order form-control"
                                   data-original-title="<font color='red'>Пример 45/12</font> </br> <u>45</u> - Код ресурсного отдела, который инициировал распоряжение. </br> <u>12</u> - Порядковый номер распоряжения проставляется, согласно реестру распоряжений, который ведётся в ресурсном отделе>"
                                   placeholder="" disabled value="<?php if(isset($item_info['number_order'])) { echo($item_info['number_order']); } ?>"
                                   data-id-order="<?php if(isset($item_info['id_all_orders'])) { echo($item_info['id_all_orders']); } ?>"
                            >
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date_order_id">От</label>
                            <input type="text" class="form-control date" id="date_order_id"  disabled
                                   value="<?php if(isset($item_info['date_order'])) { echo($item_info['date_order']); } ?>"
                            >
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="address_order_id">Прошу отгрузить в адрес</label>
                            <select class="form-control" id="address_order_id" disabled >
                                <?php foreach($filials as $item_address): ?>
                                    <?php
                                        $sel=($item_address['name_filial']==$item_info['address_order'])?"selected":"";
                                        echo("<option value=".$item_address['name_filial']." ".$sel.">".$item_address['name_filial']."</option>");
                                    ?>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="name_sklad_id">Со склада</label>
                            <select class="form-control" id="name_sklad_id" disabled >
                                <?php foreach($sklads as $item_sklad): ?>
                                    <?php
                                        $sel=($item_sklad['name_sklad']==$item_info['name_sklad'])?"selected":"";
                                        echo("<option value=".$item_sklad['name_sklad']." ".$sel.">".$item_sklad['name_sklad']."</option>");
                                    ?>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
                <div class="table-responsive">
                    <table id="myOrder" class="table table-bordered table-hover tert" style="width:100%">
                        <thead>
                        <tr class="text-center">
                            <th scope="row">№</th>
                            <th>Код МТР</th>
                            <th style="width: 40%;">Наименование МТР</th>
                            <th style="width: 7%;">Объект</th>
                            <th style="width: 5%;">Ед.изм.</th>
                            <th style="width: 5%;">Кол-во</th>
                            <th style="width: 10%;">Филиал</th>
                            <th style="width: 5%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                                data-original-title="Режим доставки МТР:</br>
                                        1) <u>Аварийный</u> -(срочная доставка МТР к месту аварии на объектах МГ и КС или с целью исключения возникновения аварийной, сбойной ситуации)</br>
                                        2) <u>Срочный</u> - (доставка МТР для завершения выполненяемых работ, исключения срыва сроков плановых работ и т.п.)</br>
                                        3) <u>Плановый</u> - (доставка МТР поступившего согласно сроков указанных в годовой заявке филиала на приобретение МТР, не требующего срочного вовлечения в производство)</br>
                                        <font color='red'> При указании признаков: <u>аварийный</u>, <u>срочный</u>, в примечании указывается причина, по которой МТР требует внеплановой доставки.</font>" >Режим доставки МТР,</br> условия транспортировки **</th>
                            <th style="width: 20%;">Примечание</th>
                            <th style="display: none" class="ButtonAction">Операция</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($order as $item): ?>
                            <tr>
                                <td></td>
                                <td><input style="height:30px" name="codeMTR[]" type="text" value="<?php if(isset($item['codeMTR'])) { echo($item['codeMTR']); } ?>" class="codeMTR form-control" disabled data-id-order-mtr="<?php if(isset($item['id_order'])) { echo($item['id_order']); } ?>" ></td>
                                <td><textarea style="width:100%; height:30px" name="nameMTR[]" type="text" class="nameMTR form-control" disabled><?php if(isset($item['nameMTR'])) { echo($item['nameMTR']); }?></textarea></td>
                                <td><select style="width:100%; height:30px" name="ukObjectMTR[]" class="form-control ukObjectMTR" disabled>
                                        <?php foreach($objects as $item_objects): ?>
                                            <?php
                                            $sel=($item['ukObjectMTR']==$item_objects['name_object'])?"selected":"";
                                            echo("<option value=".$item_objects['name_object']." ".$sel.">".$item_objects['name_object']."</option>");
                                            ?>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><select style="width:100%; height:30px" name="sizeMTR[]" class="form-control sizeMTR" disabled>
                                        <?php foreach($measures as $item_measures): ?>
                                            <?php
                                            $sel=($item['sizeMTR']==$item_measures['name_measure'])?"selected":"";
                                            echo("<option value=".$item_measures['name_measure']." ".$sel.">".$item_measures['name_measure']."</option>");
                                            ?>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><input name="sum[]" type="text" value="<?php if(isset($item['sumMTR'])) { echo($item['sumMTR']); } ?>" class="sumMTR form-control input-block" disabled></td>
                                <td><select style="width:100%; height:30px" name="filialMTR[]" class="form-control filialMTR" disabled>
                                        <?php foreach($filials as $item_filials): ?>
                                            <?php
                                            $sel=($item['filialMTR']==$item_filials['name_filial'])?"selected":"";
                                            echo("<option value=".$item_filials['name_filial']." ".$sel.">".$item_filials['name_filial']."</option>");
                                            ?>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><select style="width:100%; height:30px" name="deliveryMTR[]" class="form-control deliveryMTR" disabled>
                                        <?php foreach($delivery_modes as $item_delivery_modes): ?>
                                            <?php
                                            $sel=($item['deliveryMTR']==$item_delivery_modes['name_delivery_mode'])?"selected":"";
                                            echo("<option value=".$item_delivery_modes['name_delivery_mode']." ".$sel.">".$item_delivery_modes['name_delivery_mode']."</option>");
                                            ?>
                                        <?php endforeach ?>
                                    </select></td>
                                <td><textarea style="width:100%; height:30px" name="noteMTR[]" class="form-control noteMTR" disabled> <?php if(isset($item['noteMTR'])) { echo($item['noteMTR']); } ?> </textarea></td>
                                <td style="display: none" class="ButtonAction">
                                    <a href="#" id="deleterow" onclick="deleteRowTable(this);" data-id-row-tablemtr="<?php if(isset($item['id_order'])) { echo($item['id_order']); } ?>" >Удалить</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?php
                        $_username = $this->session->userdata('username');
                        $_actions = $this->session->userdata('actions');
                        if (isset ($_username) && ((($_actions['edit_order']) == 1))) { ?>
<!--Кнопки управления при редактировании-->
                            <button id="addToTable" style="display: none" class="ButtonAddToTable btn btn-outline-primary">Добавить <i class="fa fa-plus"></i></button>
                            <button id="EditsaveToEditOrder" style="display: none" onclick="saveEditOrder();" type="button" class="ButtonSaveEditToTable btn btn-outline-success">Сохранить изменения<i class="fa fa-save"></i></button>
                            <button id="EditcancelToEditOrder" style="display: none" onclick="cancelEditOrder();" type="button" class="ButtonCancelEditToTable btn btn-outline-warning">Отмена<i class="fa fa-undo"></i></button>
                        <?php } ?>
<!--Кнопки при утверждении распоряжения-->
                        <?php
                        $_username = $this->session->userdata('username');
                        $_actions = $this->session->userdata('actions');
                        if (isset ($_username) && ((($_actions['edit_order']) == 1))) { ?>
                            <?php if ($info_order[0]['flag'] == FALSE){ ?>
                                <button id="EditeditToTable" onclick="editOrder();" type="button" class="ButtonEditToTable btn btn-outline-primary">Изменить <i class="fa fa-pencil"></i></button>
                                <button id="EditendToTable" onclick="endOrder();" type="button" class="ButtonEndTotable btn btn-outline-info">Завершить <i class="fa fa-send"></i></button>
                                <button type="button" onclick="ExportXls();" class="ButtonExportXLS btn btn-info">Экспорт в Excel</button>
                            <?php } ?>
                        <?php } ?>
<!--Кнопки при сформированном распоряжения-->
                        <?php
                        $_username = $this->session->userdata('username');
                        $_actions = $this->session->userdata('actions');
                        if (isset ($_username) && ((($_actions['delete_order']) == 1))) { ?>
                            <?php if ($info_order[0]['flag'] == TRUE){ ?>
                                <button id="EditeditToTable" onclick="edit_endOrder();" type="button" class="ButtonEditEndToTable btn btn-outline-primary">Вернуть на доработку <i class="fa fa-pencil"></i></button>
                                <button type="button" onclick="ExportXls();" class="ButtonExportXLS btn btn-info">Экспорт в Excel</button>
                            <?php } ?>
                        <?php } elseif (isset ($_username) && ((($_actions['show_order']) == 1))) {?>
                            <?php if ($info_order[0]['flag'] == TRUE){ ?>
                            <button type="button" onclick="ExportXls();" class="ButtonExportXLS btn btn-info">Экспорт в Excel</button>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div
        </div>
    </div>
    </section>
<?php } else { ?>
<!--New Order-->
<section>
    <div class="d-flex">
        <div class="content p-4">
            <div class="card mb-4">
                <div class="card-header bg-white font-weight-bold">
                    <button type="button" onclick="showOrders();" name="order" class="btn btn-success">Вернуться к распоряжениям</button>
                </div>
                <a href="<?php print site_url();?>assets/uploads/sample-xlsx.xlsx" class="btn btn-info btn-sm"><i class="fa fa-file-excel"></i> Sample .XLSX</a>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="number_order_id">Распоряжение №*</label>
                            <input data-toggle="tooltip" data-html="true" name="number_order_id" id="number_order_id" type="text" class="number_order form-control "
                                   data-original-title="<font color='red'>Пример 45/12</font> </br> <u>45</u> - Код ресурсного отдела, который инициировал распоряжение. </br> <u>12</u> - Порядковый номер распоряжения проставляется, согласно реестру распоряжений, который ведётся в ресурсном отделе">
                            <span id="valid_order"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date_order_id">От</label>
                            <input type="text" class="form-control date" id="date_order_id" value="<?php echo(date("d-m-Y")); ?>">
                            <span id="valid_date"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="address_order_id">Прошу отгрузить в адрес</label>
                            <select class="form-control" id="address_order_id"><option></option>
                                <?php foreach($filials as $item): ?>
                                    <option value="<?php echo($item['name_filial']); ?>"><?php echo($item['name_filial']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="valid_address"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="name_sklad_id">Со склада</label>
                            <select class="form-control" id="name_sklad_id"><option></option>
                                <?php foreach($sklads as $item): ?>
                                    <option value="<?php echo($item['name_sklad']); ?>"><?php echo($item['name_sklad']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="valid_sklad"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="myOrder" class="table table-bordered table-hover tert" style="width:100%">
                    <thead>
                    <tr class="text-center">
                        <th scope="row">№</th>
                        <th>Код МТР</th>
                        <th style="width: 40%;">Наименование МТР</th>
                        <th style="width: 7%;">Объект</th>
                        <th style="width: 5%;">Ед.изм.</th>
                        <th style="width: 5%;">Кол-во</th>
                        <th style="width: 10%;">Филиал</th>
                        <th style="width: 5%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                            data-original-title="Режим доставки МТР:</br>
                                    1) <u>Аварийный</u> -(срочная доставка МТР к месту аварии на объектах МГ и КС или с целью исключения возникновения аварийной, сбойной ситуации)</br>
                                    2) <u>Срочный</u> - (доставка МТР для завершения выполненяемых работ, исключения срыва сроков плановых работ и т.п.)</br>
                                    3) <u>Плановый</u> - (доставка МТР поступившего согласно сроков указанных в годовой заявке филиала на приобретение МТР, не требующего срочного вовлечения в производство)</br>
                                    <font color='red'> При указании признаков: <u>аварийный</u>, <u>срочный</u>, в примечании указывается причина, по которой МТР требует внеплановой доставки.</font>" >Режим доставки МТР,</br> условия транспортировки **</th>
                        <th style="width: 20%;">Примечание</th>
                        <th class="ButtonAction">Операция</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td><input style="height:30px" name="codeMTR[]" type="text" value="" class="codeMTR form-control"></td>
                        <td><textarea style="width:100%; height:30px" name="nameMTR[]" type="text" class="nameMTR form-control" ></textarea></td>
                        <td><select style="width:100%; height:30px" name="ukObjectMTR[]" class="form-control ukObjectMTR" > <option value=""></option> <?php foreach($objects as $item): ?> <option value="<?php echo($item['name_object']); ?>"><?php echo($item['name_object']); ?></option> <?php endforeach; ?> </select></td>
                        <td><select style="width:100%; height:30px" name="sizeMTR[]" class="form-control sizeMTR" > <option value=""></option> <?php foreach($measures as $item): ?> <option value="<?php echo($item['name_measure']); ?>"><?php echo($item['name_measure']); ?></option> <?php endforeach; ?> </select></td>
                        <td><input style="height:30px" name="sum[]" type="text" value="" class="sumMTR form-control input-block" ></td>
                        <td><select style="width:100%; height:30px" name="filialMTR[]" class="form-control filialMTR" > <option value=""></option> <?php foreach($filials as $item): ?> <option value="<?php echo($item['name_filial']); ?>"><?php echo($item['name_filial']); ?></option> <?php endforeach; ?> </select></td>
                        <td><select style="width:100%; height:30px" name="deliveryMTR[]" class="form-control deliveryMTR" > <option value=""></option> <?php foreach($delivery_modes as $item): ?> <option value="<?php echo($item['name_delivery_mode']); ?>"><?php echo($item['name_delivery_mode']); ?></option> <?php endforeach; ?> </select></td>
                        <td><textarea style="width:100%; height:30px" name="noteMTR[]" class="form-control noteMTR" ></textarea></td>
                        <td class="ButtonAction">
                            <a href="#" id="deleterow" onclick="deleteRowTable(this);" >Удалить</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-sm-6">
<!--Кнопки управления при первичном занесение данных в БД-->
                    <button id="addToTable" class="ButtonAddToTable btn btn-outline-primary">Добавить <i class="fa fa-plus"></i></button>
                    <button id="saveToTable" onclick="saveOrder();" type="button" class="ButtonSaveToTable btn btn-outline-success">Сохранить <i class="fa fa-save"></i></button>
                    <button id="saveToEditOrder" style="display: none" onclick="saveEditOrder();" type="button" class="ButtonSaveEditToTable btn btn-outline-success">Сохранить изменения <i class="fa fa-save"></i></button>
                    <button id="cancelToEditOrder" style="display: none" onclick="cancelEditOrder();" type="button" class="ButtonCancelEditToTable btn btn-outline-warning">Отмена <i class="fa fa-undo"></i></button>
                    <button id="editToTable" style="display: none" onclick="editOrder();" type="button" class="ButtonEditToTable btn btn-outline-primary">Изменить <i class="fa fa-pencil"></i></button>
                    <?php
                    $_username = $this->session->userdata('username');
                    $_actions = $this->session->userdata('actions');
                    if (isset ($_username) && ((($_actions['delete_order']) == 1))) { ?>
                        <button id="endToTable" style="display: none" onclick="endOrder();" type="button" class="ButtonEndTotable btn btn-outline-info">Завершить <i class="fa fa-send"></i></button>
                    <?php } ?>
                    <button type="button" style="display: none" onclick="ExportXls();" class="btn btn-info ButtonExportXLS">Экспорт в Excel</button>
                </div>
            </div
        </div>
    </div>
</section>
<?php } ?>


<script src="<?=base_url();?>assets/order/jquery-3.3.1.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/bootstrap-4.2.1/js/bootstrap.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/datepicker4/js/gijgo.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/datepicker4/js/messages/messages.ru-ru.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/bootAdmin/js/bootstrap.bundle.min.js" type="text/javascript"> </script>
<script src="<?=base_url();?>assets/order/bootAdmin/js/bootadmin.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/dataTables.fixedHeader.min.js" type="text/javascript"></script>

</body>
</html>

<script>
    $(document).ready(function() {
//Валидация формы
    var pattern_date = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/; //Дата распоряжения
    var pattern_name_order = /^[0-9/\\]+$/; //Номер распоряжения

//Валидация наименования распоряжения
        var order_name_element = $('#number_order_id');
        order_name_element.blur(function(){
            if(order_name_element.val() != ''){
                if(order_name_element.val().search(pattern_name_order) == 0 ){
                    order_name_element.removeClass('is-invalid');
                    order_name_element.addClass('is-valid');
                } else {
                    order_name_element.addClass('is-invalid');
                    $('#valid_order').text('Error!');
                }
            }else{
                $('#valid_order').text('Поле не должно быть пустым!');
                order_name_element.addClass('is-invalid');
            }
        });
//Валидация даты распоряжения
        var date_order_element = $('#date_order_id');
        date_order_element.focusout(function(){
            if(date_order_element.val() != ''){
                if(date_order_element.val().search(pattern_date) == 0 ){
                    date_order_element.removeClass('is-invalid');
                    date_order_element.addClass('is-valid');
                } else {
                    date_order_element.addClass('is-invalid');
                    $('#valid_date').text('Error!');
                }
            }else{
                $('#valid_date').text('Поле не должно быть пустым!');
                date_order_element.addClass('is-invalid');
            }
        });
//Валидация адрес отгрузки
        var address_order_element = $('#address_order_id');
        address_order_element.blur(function(){
            if(address_order_element.val() != ''){
                address_order_element.removeClass('is-invalid');
                address_order_element.addClass('is-valid');
            }else{
                $('#valid_address').text('Поле не должно быть пустым!');
                address_order_element.addClass('is-invalid');
            }
        });
//Валидация склада
        var name_sklad_element = $('#name_sklad_id');
        name_sklad_element.blur(function(){
            if(name_sklad_element.val() != ''){
                name_sklad_element.removeClass('is-invalid');
                name_sklad_element.addClass('is-valid');
            }else{
                $('#valid_sklad').text('Поле не должно быть пустым!');
                name_sklad_element.addClass('is-invalid');
            }
        });

//Настройки таблицы
        var t = $('#myOrder').DataTable({
            fixedHeader: true,
            "searching": false,
            "paging":    false,
            "ordering":  false,
            "info":      false
        });
//Автоматические подсчет строк
        $('.tert tbody tr').each(function(i) {
            var number = i + 1;
            $(this).find('td:first').text(number+".");
        });
//Добавление строки
        $('#addToTable').on( 'click', function () {
            var rowNode= t.row.add( [
                '<td></td>',
                '<td><input style="width:100%; height:30px" name="codeMTR[]" type="text" class="codeMTR form-control"></td>',
                '<td><textarea style="width:100%; height:30px" name="nameMTR[]" type="text" class="nameMTR form-control"></textarea></td>',
                '<td><select style="width:100%; height:30px" name="ukObjectMTR[]" class="form-control ukObjectMTR"> <option value=""></option> <?php foreach($objects as $item): ?> <option value="<?php echo($item['name_object']); ?>"><?php echo($item['name_object']); ?></option> <?php endforeach; ?> </select></td>',
                '<td><select style="width:100%; height:30px" name="sizeMTR[]" class="form-control sizeMTR"> <option value=""></option> <?php foreach($measures as $item): ?> <option value="<?php echo($item['name_measure']); ?>"><?php echo($item['name_measure']); ?></option> <?php endforeach; ?> </select></td>',
                '<td><input style="width:100%; height:30px" name="sumMTR[]" type="text" value="" required class="form-control sumMTR" ></td>',
                '<td><select style="width:100%; height:30px" name="filialMTR[]" class="form-control filialMTR"> <option value=""></option> <?php foreach($filials as $item): ?> <option value="<?php echo($item['name_filial']); ?>"><?php echo($item['name_filial']); ?></option> <?php endforeach; ?> </select></td>',
                '<td><select style="width:100%; height:30px" name="deliveryMTR[]" class="form-control deliveryMTR"> <option value=""></option> <?php foreach($delivery_modes as $item): ?> <option value="<?php echo($item['name_delivery_mode']); ?>"><?php echo($item['name_delivery_mode']); ?></option> <?php endforeach; ?> </select></td>',
                '<td><textarea style="width:100%; height:30px" name="noteMTR[]" class="form-control noteMTR"></textarea></td>',
                '<td><a href="#" id="deleterow" onclick="deleteRowTable(this);">Удалить</a></td>'
            ] ).draw()
            .node();
            $(rowNode).find('td').eq(9).addClass('ButtonAction');

            $('.tert tbody tr').each(function(i) {
                var number = i + 1;
                $(this).find('td:first').text(number+".");
            });
        } );
    } );

//Вывод даты
    $('#date_order_id').datepicker({
        uiLibrary: 'bootstrap',
        locale: 'ru-ru',
        format: 'dd-mm-yyyy'
    });

//Кнопка удаление строки
    function deleteRowTable(id){
        if (confirm("Вы точно хотите удалить строку безбозвратно?")){
            var id_row_order = id.getAttribute('data-id-row-tablemtr');
            console.log(id_row_order);

            var t = $('#myOrder').DataTable();
            $('#myOrder').on("click", "a", function(){
                t.row($(this).parents('tr')).remove().draw(false);
            });

            $('.tert tbody tr').each(function(i) {
                var number = i + 1;
                $(this).find('td:first').text(number+".");
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

//Возврат на список распоряжений
    function showOrders(){
        if(confirm ("Вы точно хотите выйти не сохранив изменения?")) {
            window.location.replace("<?=base_url();?>Main/range_date_orders");
        }
    }

//Валидация форм
    function validation_form() {
        var pattern_date = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/; //Дата распоряжения
        var pattern_name_order = /^[0-9/\\]+$/; //Номер распоряжения
        var arr = []; //Счетчик ошибок при заполнении формы

//Валидация наименования распоряжения
        var order_name_element = $('#number_order_id');
            if(order_name_element.val() != ''){
                if(order_name_element.val().search(pattern_name_order) == 0 ){
                    order_name_element.removeClass('is-invalid');
                    order_name_element.addClass('is-valid');
                    arr[arr.length] = 1;
                } else {
                    order_name_element.addClass('is-invalid');
                    $('#valid_order').text('Error!');
                    arr[arr.length] = 0;
                }
            }else{
                $('#valid_order').text('Поле не должно быть пустым!');
                order_name_element.addClass('is-invalid');
                arr[arr.length] = 0;
            }
//Валидация даты распоряжения
        var date_order_element = $('#date_order_id');
            if(date_order_element.val() != ''){
                if(date_order_element.val().search(pattern_date) == 0 ){
                    date_order_element.removeClass('is-invalid');
                    date_order_element.addClass('is-valid');
                    arr[arr.length] = 1;
                } else {
                    date_order_element.addClass('is-invalid');
                    $('#valid_date').text('Error!');
                    arr[arr.length] = 0;
                }
            }else{
                $('#valid_date').text('Поле не должно быть пустым!');
                date_order_element.addClass('is-invalid');
                arr[arr.length] = 0;
            }

//Валидация адрес отгрузки
        var address_order_element = $('#address_order_id');
            if(address_order_element.val() != ''){
                address_order_element.removeClass('is-invalid');
                address_order_element.addClass('is-valid');
                arr[arr.length] = 1;
            }else{
                $('#valid_address').text('Поле не должно быть пустым!');
                address_order_element.addClass('is-invalid');
                arr[arr.length] = 0;
            }

//Валидация склада
        var name_sklad_element = $('#name_sklad_id');
            if(name_sklad_element.val() != ''){
                name_sklad_element.removeClass('is-invalid');
                name_sklad_element.addClass('is-valid');
                arr[arr.length] = 1;
            }else{
                $('#valid_sklad').text('Поле не должно быть пустым!');
                name_sklad_element.addClass('is-invalid');
                arr[arr.length] = 0;
            }

//Валидация Примечания
        var length_noteMTR = document.getElementsByClassName('noteMTR').length;
        var a = 0;
        while (a < length_noteMTR) {
            var noteMTR_element = $('.noteMTR');
            var number_noteMTR = noteMTR_element.eq(a).val();
            var deliveryMTR_element = $('.deliveryMTR');
            var number_deliveryMTR = deliveryMTR_element.eq(a).val();
            if (number_deliveryMTR == 'Аварийный' || number_deliveryMTR == 'Срочный') {
                if (number_noteMTR != '') {
                    noteMTR_element.eq(a).removeClass('is-invalid');
                    noteMTR_element.eq(a).addClass('is-valid');
                    arr[arr.length] = 1;
                } else {
                    noteMTR_element.eq(a).addClass('is-invalid');
                    arr[arr.length] = 0;
                }
            } else {
                noteMTR_element.eq(a).removeClass('is-invalid');
                noteMTR_element.eq(a).addClass('is-valid');
            }
            a++;
        }


//Валидация Код МТР
        var length_codeMTR = document.getElementsByClassName('codeMTR').length;
        var b = 0;
            while (b < length_codeMTR) {
                var codeMTR_element = $('.codeMTR');
                var number_codeMTR = codeMTR_element.eq(b).val();
                if (number_codeMTR != '') {
                    codeMTR_element.eq(b).removeClass('is-invalid');
                    codeMTR_element.eq(b).addClass('is-valid');
                    arr[arr.length] = 1;
                } else {
                    codeMTR_element.eq(b).addClass('is-invalid');
                    arr[arr.length] = 0;
                }
                b++;
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

//Сохранение распоряжение с занесением в базу
    function saveOrder() {
        var check_validation = validation_form();
        console.log(check_validation);
        if (check_validation == 1 ){
            console.log("true");
            var el_order_name = document.getElementById('number_order_id');
            el_order_name.classList.add('is-valid');
            if (confirm("Вы точно хотите сохранить данные?")) {
                /*Show and Hide кнопок управления*/
                $('.ButtonAction').hide();
                $('.ButtonSaveToTable').hide();
                $('.ButtonAddToTable').hide();
                $('.ButtonEndTotable').show();
                $('.ButtonEditToTable').show();
                $('.ButtonExportXLS').show();

                /*Show and Hide input table*/
                $("#number_order_id").prop("disabled", true);
                $("#date_order_id").prop("disabled", true);
                $("#address_order_id").prop("disabled", true);
                $("#name_sklad_id").prop("disabled", true);
                $(".codeMTR").prop("disabled", true);
                $(".nameMTR").prop("disabled", true);
                $(".ukObjectMTR").prop("disabled", true);
                $(".sizeMTR").prop("disabled", true);
                $(".sumMTR").prop("disabled", true);
                $(".filialMTR").prop("disabled", true);
                $(".deliveryMTR").prop("disabled", true);
                $(".noteMTR").prop("disabled", true);

                /*формирование запроса к базе All_order*/
                var JSnumber_order = document.getElementById('number_order_id').value;
                var JSdate_order = document.getElementById('date_order_id').value;
                var JSaddress_order = document.getElementById('address_order_id').value;
                var JSname_sklad = document.getElementById('name_sklad_id').value;
                console.log(JSnumber_order);
                console.log(JSdate_order);
                console.log(JSaddress_order);
                console.log(JSname_sklad);
                var m = 0;

                $.ajax({
                    url: "<?=base_url();?>Main/saveAllOrder",
                    type: "POST",
                    data: {
                        number_order: JSnumber_order,
                        date_order: JSdate_order,
                        address_order: JSaddress_order,
                        name_sklad: JSname_sklad
                    },
                    success: function (data) {
                        console.log(data);

                        /*формирование запроса к базе Order_MTR*/
                        var number_codeMTR = document.getElementsByClassName('codeMTR').length;
                        while (m < number_codeMTR) {
                            var JScodeMTR = document.getElementsByClassName('codeMTR')[m].value;
                            var JSnameMTR = document.getElementsByClassName('nameMTR')[m].value;
                            var JSukObjectMTR = document.getElementsByClassName('ukObjectMTR')[m].value;
                            var JSsizeMTR = document.getElementsByClassName('sizeMTR')[m].value;
                            var JSsumMTR = document.getElementsByClassName('sumMTR')[m].value;
                            var JSfilialMTR = document.getElementsByClassName('filialMTR')[m].value;
                            var JSdeliveryMTR = document.getElementsByClassName('deliveryMTR')[m].value;
                            var JSnoteMTR = document.getElementsByClassName('noteMTR')[m].value;
                            var JSnumber_orderMTR = document.getElementById('number_order_id').value;
                            var JSdate_orderMTR = document.getElementById('date_order_id').value;
                            var JSaddress_orderMTR = document.getElementById('address_order_id').value;
                            var JSname_skladMTR = document.getElementById('name_sklad_id').value;
                            console.log(JScodeMTR);
                            console.log(JSnameMTR);
                            console.log(JSukObjectMTR);
                            console.log(JSsizeMTR);
                            console.log(JSsumMTR);
                            console.log(JSfilialMTR);
                            console.log(JSdeliveryMTR);
                            console.log(JSnoteMTR);
                            console.log(JSnumber_orderMTR);
                            console.log(JSdate_orderMTR);
                            console.log(JSaddress_orderMTR);
                            console.log(JSname_skladMTR);

                            $.ajax({
                                url: "<?=base_url();?>Main/saveOrderMTR",
                                type: "POST",
                                data: {
                                    codeMTR: JScodeMTR,
                                    nameMTR: JSnameMTR,
                                    ukObjectMTR: JSukObjectMTR,
                                    sizeMTR: JSsizeMTR,
                                    sumMTR: JSsumMTR,
                                    filialMTR: JSfilialMTR,
                                    deliveryMTR: JSdeliveryMTR,
                                    noteMTR: JSnoteMTR,
                                    number_orderMTR: JSnumber_orderMTR,
                                    date_orderMTR: JSdate_orderMTR,
                                    address_orderMTR: JSaddress_orderMTR,
                                    name_skladMTR: JSname_skladMTR
                                },
                                success: function (datax) {
                                    console.log(datax);
                                    window.location = "<?=base_url();?>Main/create_edit_order?id_order=" + datax;
                                }
                            });
                            m++;
                        }
                    }
                });
            }
        } else {
            alert("Обнаружены ошибки при сохранении формы, исправте ошибки и попробуйте снова");
        }
    }

//Сохранение изменения распоряжения с занесением в базу
    function saveEditOrder() {
        var check_validation = validation_form();
        console.log(check_validation);
        if (check_validation == 1 ){
            console.log("true");
            var el_order_name = document.getElementById('number_order_id');
            el_order_name.classList.add('is-valid');
            if (confirm ("Вы точно хотите сохранить внесенные изменения?")) {
                /*Show and Hide кнопок управления*/
                $('.ButtonAction').hide();
                $('.ButtonSaveToTable').hide();
                $('.ButtonAddToTable').hide();
                $('.ButtonSaveEditToTable').hide();
                $('.ButtonCancelEditToTable').hide();
                $('.ButtonEndTotable').show();
                $('.ButtonEditToTable').show();
                $('.ButtonExportXLS').show();

                /*Show and Hide input table*/
                $("#number_order_id").prop("disabled", true);
                $("#date_order_id").prop("disabled", true);
                $("#address_order_id").prop("disabled", true);
                $("#name_sklad_id").prop("disabled", true);
                $(".codeMTR").prop("disabled", true);
                $(".nameMTR").prop("disabled", true);
                $(".ukObjectMTR").prop("disabled", true);
                $(".sizeMTR").prop("disabled", true);
                $(".sumMTR").prop("disabled", true);
                $(".filialMTR").prop("disabled", true);
                $(".deliveryMTR").prop("disabled", true);
                $(".noteMTR").prop("disabled", true);

                /*формирование запроса к базе All_order*/
                var JSnumber_order = document.getElementById('number_order_id').value;
                var JSdate_order = document.getElementById('date_order_id').value;
                var JSaddress_order = document.getElementById('address_order_id').value;
                var JSname_sklad = document.getElementById('name_sklad_id').value;
                var t = document.getElementById('number_order_id');
                var JSid_order = t.getAttribute('data-id-order');
                console.log(JSnumber_order);
                console.log(JSdate_order);
                console.log(JSaddress_order);
                console.log(JSname_sklad);
                console.log(JSid_order);
                var m = 0;
                $.ajax({
                    type: "POST",
                    url: "<?=base_url();?>Main/saveEditAllOrder",
                    data: {
                        number_order: JSnumber_order,
                        date_order: JSdate_order,
                        name_sklad: JSname_sklad,
                        address_order: JSaddress_order,
                        id_order: JSid_order
                    },
                    success: function (data) {
                        console.log(data);

                        /*формирование запроса к базе Order_MTR*/
                        var number_codeMTR = document.getElementsByClassName('codeMTR').length;
                        while (m < number_codeMTR) {
                            /*Находим id строки в которую внесли изменения*/
                            var id_n = document.getElementsByClassName('codeMTR')[m];
                            var JSid_rowMTR = id_n.getAttribute('data-id-order-mtr');
                            /*Находим id распоряжения по которому вносим изменения*/
                            var id_t = document.getElementById('number_order_id');
                            var JSid_orderMTR = id_t.getAttribute('data-id-order');
                            /*Данные с каждой строки*/
                            var JScodeMTR = document.getElementsByClassName('codeMTR')[m].value;
                            var JSnameMTR = document.getElementsByClassName('nameMTR')[m].value;
                            var JSukObjectMTR = document.getElementsByClassName('ukObjectMTR')[m].value;
                            var JSsizeMTR = document.getElementsByClassName('sizeMTR')[m].value;
                            var JSsumMTR = document.getElementsByClassName('sumMTR')[m].value;
                            var JSfilialMTR = document.getElementsByClassName('filialMTR')[m].value;
                            var JSdeliveryMTR = document.getElementsByClassName('deliveryMTR')[m].value;
                            var JSnoteMTR = document.getElementsByClassName('noteMTR')[m].value;
                            /*Основная информация о распоряжении*/
                            var JSnumber_orderMTR = document.getElementById('number_order_id').value;
                            var JSdate_orderMTR = document.getElementById('date_order_id').value;
                            var JSname_skladMTR = document.getElementById('name_sklad_id').value;
                            var JSaddress_orderMTR = document.getElementById('address_order_id').value;

                            console.log(JSid_rowMTR);
                            console.log(JSid_orderMTR);
                            console.log(JScodeMTR);
                            console.log(JSnameMTR);
                            console.log(JSukObjectMTR);
                            console.log(JSsizeMTR);
                            console.log(JSsumMTR);
                            console.log(JSfilialMTR);
                            console.log(JSdeliveryMTR);
                            console.log(JSnoteMTR);
                            console.log(JSnumber_orderMTR);
                            console.log(JSdate_orderMTR);
                            console.log(JSname_skladMTR);
                            console.log(JSaddress_orderMTR);

                            $.ajax({
                                url: "<?=base_url();?>Main/saveEditOrderMTR",
                                type: "POST",
                                data: {
                                    id_rowMTR : JSid_rowMTR,
                                    id_orderMTR : JSid_orderMTR,
                                    codeMTR : JScodeMTR,
                                    nameMTR : JSnameMTR,
                                    ukObjectMTR : JSukObjectMTR,
                                    sizeMTR : JSsizeMTR,
                                    sumMTR : JSsumMTR,
                                    filialMTR : JSfilialMTR,
                                    deliveryMTR : JSdeliveryMTR,
                                    noteMTR : JSnoteMTR,
                                    number_orderMTR : JSnumber_orderMTR,
                                    date_orderMTR : JSdate_orderMTR,
                                    name_skladMTR : JSname_skladMTR,
                                    address_orderMTR : JSaddress_orderMTR,
                                },
                                success: function(data){
                                    console.log(data);
                                    window.location = "<?=base_url();?>Main/create_edit_order?id_order="+JSid_orderMTR;
                                }
                            });
                            m++;
                        }
                    }
                });
            }
        } else {
            alert("Обнаружены ошибки при сохранении формы, исправте ошибки и попробуйте снова");
        }

    }

//Отмена последних изменений выход из режима редактирования распоряжения
    function cancelEditOrder(){
        var t = document.getElementById('number_order_id');
        var JSid_order = t.getAttribute('data-id-order');
        window.location ="<?=base_url();?>Main/create_edit_order?id_order=" + JSid_order;
    }

//Режим редактирования распоряжения
    function editOrder(){
        /*Show and Hide кнопок управления*/
        $('.ButtonEndTotable').hide();
        $('.ButtonEditToTable').hide();
        $('.ButtonAction').show();
        $('.ButtonAddToTable').show();
        $('.ButtonSaveEditToTable').show();
        $('.ButtonCancelEditToTable').show();
        $('.ButtonExportXLS').hide();

        /*Show and Hide input table*/
        $("#number_order_id").prop("disabled", false);
        $("#date_order_id").prop("disabled", false);
        $("#address_order_id").prop("disabled", false);
        $("#name_sklad_id").prop("disabled", false);
        $(".codeMTR").prop("disabled", false);
        $(".nameMTR").prop("disabled", false);
        $(".ukObjectMTR").prop("disabled", false);
        $(".sizeMTR").prop("disabled", false);
        $(".sumMTR").prop("disabled", false);
        $(".filialMTR").prop("disabled", false);
        $(".deliveryMTR").prop("disabled", false);
        $(".noteMTR").prop("disabled", false);
    }

//Заключительный этап приема распоряжение - Завершить
    function endOrder(){
        if(confirm("Вы точно хотите завершить прием распоряжения?")) {
            var t = document.getElementById('number_order_id');
            var JSid_order = t.getAttribute('data-id-order');
            $.ajax({
                type: "POST",
                url: "<?=base_url();?>Main/endAllOrder",
                data: {id_order : JSid_order},
                success: function(data){
                    console.log(data);
                    $('.ButtonEndTotable').hide();
                    $('.ButtonEditToTable').hide();
                }
            });
        }
    }

//Возрат распоряжения на этап формирования
    function edit_endOrder(){
        if(confirm("Вы точно хотите вернуть распоряжение на этап формирования?")) {
            var t = document.getElementById('number_order_id');
            var JSid_order = t.getAttribute('data-id-order');
            $.ajax({
                type: "POST",
                url: "<?=base_url();?>Main/editendAllOrder",
                data: {id_order : JSid_order},
                success: function(data){
                    console.log(data);
                    $('.ButtonEndTotable').show();
                    $('.ButtonEditToTable').show();
                }
            });
        }
    }

//Экспорт в Excel
    function ExportXls(){
        var t = document.getElementById('number_order_id');
        var JSid_order = t.getAttribute('data-id-order');
        console.log("Export XSL");
        console.log(JSid_order);

        $.ajax({
            url: "<?=base_url();?>Main/export_Orders",
            type: "POST",
            data: {JSid_order : JSid_order},
            success: function(data){
                window.location ="<?=base_url();?>Main/export_Orders?JSid_order="+JSid_order;
            }
        })
    }

</script>