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
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/dataTables.bootstrap4.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/fixedHeader.dataTables.min.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/datepicker4/css/gijgo.min.css" />

    <title>info-МТР</title>

    <style type="text/css">
        .zv-load-css {
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
            position:fixed;
            top:5px;
            left:5px;
            background:rgba(0,0,0,0.7);
            color:#fff;
            padding:6px 10px;
            z-index:999;
            font-size:11px;
            font-family:Tahoma;
        }
        #loading {
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            position: fixed;
            display: block;
            opacity: 0.7;
            background-color: #fff;
            z-index: 99;
            text-align: center;
        }

        #loading-image {
            position: absolute;
            top: 100px;
            left: 240px;
            z-index: 100;
        }
    </style>

</head>
<body class="bg-light">
<div style="position:relative" id="zv-load">
    <div class="zv-load-css">
        <img src="<?=base_url();?>assets/order/loading.gif" alt="Импортируем данные..." style="vertical-align: middle;" >Импортируем данные...</div>
</div>
<!--Header-->
<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Формирование распоряжения</a>
    <a href="<?=base_url();?>assets/order/SampleOrder.xlsx" download=""> <button class="ButtonExportXLS btn btn-sm btn-info"> <i class="fa fa-file-excel"></i> Sample.XLSX</button> </a>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            <button id="cancelToEditOrder" onclick="ExitEditMotion();" type="button" class="ButtonExitEditMotion btn btn-outline-warning">Выход <i class="fa fa-undo"></i></button>
            <li class="nav-item dropdown">
                <a href="#" id="dd_user" class="nav-link" ><i class="fa fa-user"></i> <?php echo $this->session->userdata('username'); ?></a>
            </li>
        </ul>
    </div>
</nav>
<!--Edit Order-->
<?php if(($order != NULL) && isset($info_order)) { ?>
    <section>
    <div class="d-flex">
        <div class="content p-4">
            <div class="card mb-4">
                <div class="card-header bg-white font-weight-bold">
                    <button type="button" onclick="showOrders();" name="order" class="btn btn-success">Вернуться к распоряжениям</button>
                    <?php if ($info_order[0]['flag'] == 0){ ?>
                    <button id="OrderNach" onclick="OrderNach();" type="button" class="ButtonEndTotable btn btn-primary">Передать на согласование <i class="fa fa-send"></i></button>
                    <?php } ?>
                </div>
                <?php foreach($info_order as $item_info): ?>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-2 mb-3">
                            <label for="number_order_id">Распоряжение №*</label>
                            <input data-toggle="tooltip" data-html="true" name="number_order_id" id="number_order_id" type="text"
                                   class="number_order form-control"
                                   data-original-title="<font color='red'>Пример 45/12</font> </br> <u>45</u> - Код ресурсного отдела, который инициировал распоряжение. </br> <u>12</u> - Порядковый номер распоряжения проставляется, согласно реестру распоряжений, который ведётся в ресурсном отделе>"
                                   placeholder="" disabled value="<?php if(isset($item_info['number_order'])) { echo($item_info['number_order']); } ?>"
                                   data-id-order="<?php if(isset($item_info['id_all_orders'])) { echo($item_info['id_all_orders']); } ?>"
                            >
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="date_order_id">От</label>
                            <input type="text" class="form-control date" id="date_order_id"  disabled
                                   value="<?php if(isset($item_info['date_order'])) { echo(date('d-m-Y', strtotime($item_info['date_order']))); } ?>"
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
                        <div class="col-md-2 mb-3">
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
                        <div class="col-md-3 mb-3">
                            <label for="author_order">Автор</label>
                            <?php foreach($author as $item_author): ?>
                                <input type="text" class="form-control date" id="author_order" name="author_order"  disabled
                                       value="<?php if(isset($item_author['sername'])) { echo($item_author['sername']." ".$item_author['name']." ".$item_author['patronymic'] ); } ?>"
                                >
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
                <div >
                    <form action="" id="our-form">
                    <table id="myOrder" class="table compact table-bordered table-hover tert" style="width:100%">
                        <thead>
                        <tr style="font-size: 10pt;" class="text-center">
                            <th style="width: 1%;">№</th>
                            <th style="width: 25%;">Код МТР</th>
                            <th style="width: 5%;">Номер партии</th>
                            <th style="width: 50%;">Наименование МТР</th>
                            <th style="width: 5%;">Объект</th>
                            <th style="width: 7%;">Инвентарный номер </br> объекта</th>
                            <th style="width: 5%;">Ед.изм.</th>
                            <th style="width: 5%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                                data-original-title="Кол-во необходим указывать в целых или дробных значениях (Пример: целое - 34, дробное - 34.3)">Кол-во</th>
                            <th style="width: 10%;">Филиал</th>
                            <th style="width: 5%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                                data-original-title="Режим доставки МТР:</br>
                                    1) <u>Аварийный</u> -(срочная доставка МТР к месту аварии на объектах МГ и КС или с целью исключения возникновения аварийной, сбойной ситуации)</br>
                                    2) <u>Срочный</u> - (доставка МТР для завершения выполненяемых работ, исключения срыва сроков плановых работ и т.п.)</br>
                                    3) <u>Плановый</u> - (доставка МТР поступившего согласно сроков указанных в годовой заявке филиала на приобретение МТР, не требующего срочного вовлечения в производство)</br>
                                    <font color='red'> При указании признаков: <u>аварийный</u>, <u>срочный</u>, в примечании указывается причина, по которой МТР требует внеплановой доставки.</font>" >Режим доставки </br> МТР</th>
                            <th style="width: 5%;">Примечание</th>
                            <th style="display: none" class="ButtonAction">Операция</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($order as $item): ?>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="checkbox-custom checkbox-primary ">
                                        <input class="Checkbox_selected checkboxMTR " type="checkbox" name="checkboxMTR[]" data-id-order-mtr_checkbox="<?php if(isset($item['id_order'])) { echo($item['id_order']); } ?>" disabled id="Checkbox_selected" value="<?php if(isset($item['id_order'])) { echo($item['id_order']); } ?>">
                                        <textarea style="height:30px" name="codeMTR[]" type="text" class="codeMTR form-control" data-id-order-mtr="<?php if(isset($item['id_order'])) { echo($item['id_order']); } ?>" disabled ><?php if(isset($item['codeMTR'])) { echo($item['codeMTR']); } ?></textarea>
                                    </div>
                                </td>

                                <td><textarea style="width:100%; height:30px" name="numberPartMTR[]" type="text" class="numberPartMTR form-control" disabled><?php if(isset($item['numberPart'])) { echo($item['numberPart']); }?></textarea></td>
                                <td><textarea style="width:100%; height:30px" name="nameMTR[]" type="text" class="nameMTR form-control" disabled><?php if(isset($item['nameMTR'])) { echo($item['nameMTR']); }?></textarea></td>
                                <td><select style="width:100%; height:30px" name="ukObjectMTR[]" class="form-control ukObjectMTR" disabled>
                                        <option value=""></option>
                                        <?php foreach($objects as $item_objects): ?>
                                            <?php
                                            $sel=($item['ukObjectMTR']==$item_objects['name_object'])?"selected":""; ?>
                                            <option value="<?php echo($item_objects['name_object']); ?>" <?php echo($sel); ?> ><?php echo($item_objects['name_object']); ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><input style="height:30px" name="numberObjectMTR[]" type="text" value="<?php if(isset($item['numberObjectMTR'])) { echo($item['numberObjectMTR']); } ?>" class="numberObjectMTR form-control input-block" disabled></td>
                                <td><select style="width:100%; height:30px" name="sizeMTR[]" class="form-control sizeMTR" disabled>
                                        <option value=""></option>
                                        <?php foreach($measures as $item_measures): ?>
                                            <?php
                                            $sel=($item['sizeMTR']==$item_measures['name_measure'])?"selected":""; ?>
                                            <option value="<?php echo($item_measures['name_measure']); ?>" <?php echo($sel); ?> ><?php echo($item_measures['name_measure']); ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><input name="sum[]" type="text" value="<?php if(isset($item['sumMTR'])) { echo($item['sumMTR']); } ?>" class="sumMTR form-control input-block" disabled></td>
                                <td><select style="width:100%; height:30px" name="filialMTR[]" class="form-control filialMTR" disabled>
                                        <option value=""></option>
                                        <?php foreach($lpu as $item_lpu): ?>
                                            <?php
                                            $sel=($item['filialMTR']==$item_lpu['name_lpu'])?"selected":""; ?>
                                            <option value="<?php echo($item_lpu['name_lpu']); ?>" <?php echo($sel); ?> ><?php echo($item_lpu['name_lpu']); ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td>
                                    <select style="width:100%; height:30px" name="deliveryMTR[]" class="form-control deliveryMTR" disabled>
                                        <option value=""></option>
                                        <?php foreach($delivery_modes as $item_delivery_modes): ?>
                                            <?php
                                            $sel=($item['deliveryMTR']==$item_delivery_modes['name_delivery_mode'])?"selected":""; ?>
                                            <option value="<?php echo($item_delivery_modes['name_delivery_mode']); ?>" <?php echo($sel); ?> ><?php echo($item_delivery_modes['name_delivery_mode']); ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><textarea style="width:100%; height:30px" name="noteMTR[]" class="form-control noteMTR" disabled> <?php if(isset($item['noteMTR'])) { echo($item['noteMTR']); } ?> </textarea></td>
                                <td style="display: none" class="ButtonAction">
                                    <a href="#" id="deleterow" onclick="deleteRowTable(this);" data-id-row-tablemtr="<?php if(isset($item['id_order'])) { echo($item['id_order']); } ?>" >Удалить</a>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    </form>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                        $_actions = $this->session->userdata('actions');
                        if ( ((($_actions['edit_order']) == 1)  || (($_actions['delete_order']) == 1)) ) { ?>
<!--Кнопки управления при редактировании-->
                            <button id="addToTable" style="display: none" class="ButtonAddToTable btn btn-outline-primary">Добавить <i class="fa fa-plus"></i></button>
                            <button id="EditsaveToEditOrder" style="display: none" onclick="saveEditOrder();" type="button" class="ButtonSaveEditToTable btn btn-outline-success">Сохранить изменения<i class="fa fa-save"></i></button>
                        <?php } ?>
<!--Кнопки при формировании распоряжения-->
                        <?php if ($info_order[0]['flag'] == 0){ ?>
                            <?php
                            $_actions = $this->session->userdata('actions');
                            $_department = $this->session->userdata('department');
                                if ( ((($_actions['edit_order']) == 1) || (($_actions['delete_order']) == 1)) ) { ?>
                                    <button id="EditeditToTable" onclick="editOrder();" type="button" class="ButtonEditToTable btn btn-outline-primary">Изменить <i class="fa fa-pencil"></i></button>
                                <?php } ?>
                            <?php if ( ( (($_actions['show_order']) == 1) || (($_actions['show_all_orders']) == 1) ) ) { ?>
                                <button type="button" onclick="ExportXls();" class="ButtonExportXLS btn btn-info">Экспорт в Excel</button>
                            <?php } ?>
                        <?php } ?>
<!--Кнопки при утвержденном распоряжении-->
                        <?php if (($info_order[0]['flag'] == 10) || ($info_order[0]['flag'] == 20) || ($info_order[0]['flag'] == 30) || ($info_order[0]['flag'] == 40)) { ?>
                            <?php
                            $_username = $this->session->userdata('username');
                            $_actions = $this->session->userdata('actions');
                            if ( ( (($_actions['show_order']) == 1) || (($_actions['show_all_orders']) == 1) ) ) { ?>
                                <button type="button" onclick="ExportXls();" class="ButtonExportXLS btn btn-info">Экспорт в Excel</button>
                            <?php } ?>
                        <?php } ?>
                        <button id="delete_selected" onclick="delete_selected_checkbox()" class="ButtonDeleteSelectToTable btn btn-outline-danger" style="display: none" > Удалить выбранные элементы <i class="fa"></i></button>
                    </div>
                </div
        </div>
    </div>
    </section>
<!--Import Order-->
    <?php } elseif (isset($dataInfo)) { ?>
    <section>
        <div class="d-flex">
            <div class="content p-4">
                <div class="card mb-4">
                    <div class="card-header bg-white font-weight-bold">
                        <button type="button" onclick="showOrders();" name="order" class="btn btn-success">Вернуться к распоряжениям</button>
                    </div>
                    <?php foreach($info_order as $item_info): ?>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-2 mb-3">
                                    <label for="number_order_id">Распоряжение №*</label>
                                    <input data-toggle="tooltip" data-html="true" name="number_order_id" id="number_order_id" type="text"
                                           class="number_order form-control"
                                           data-original-title="<font color='red'>Пример 45/12</font> </br> <u>45</u> - Код ресурсного отдела, который инициировал распоряжение. </br> <u>12</u> - Порядковый номер распоряжения проставляется, согласно реестру распоряжений, который ведётся в ресурсном отделе>"
                                           placeholder="" disabled value="<?php if(isset($item_info['number_order'])) { echo($item_info['number_order']); } ?>"
                                           data-id-order="<?php if(isset($item_info['id_all_orders'])) { echo($item_info['id_all_orders']); } ?>"
                                    >
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="date_order_id">От</label>
                                    <input type="text" class="form-control date" id="date_order_id"  disabled
                                           value="<?php if(isset($item_info['date_order'])) { echo(date('d-m-Y', strtotime($item_info['date_order']))); } ?>"
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
                                <div class="col-md-2 mb-3">
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
                                <div class="col-md-3 mb-3">
                                    <label for="author_order">Исполнитель</label>
                                    <?php foreach($author as $item_author): ?>
                                        <input type="text" class="form-control date" id="author_order" name="author_order"  disabled
                                               value="<?php if(isset($item_author['sername'])) { echo($item_author['sername']." ".$item_author['name']." ".$item_author['patronymic'] ); } ?>"
                                        >
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="card-footer bg-white">
                        <form action="" class="form-inline" id="excel-upl" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                            <input type="file" id="validatedCustomFile" name="fileURL" accept=".xlsx" multiple >
                            <button type="submit" name="import" class=" btn btn-primary">Импорт</button>
                        </form>
                    </div>
                </div>
                <div>
                    <table id="myOrder" class="table compact table-bordered table-hover tert" style="width:100%">
                        <thead>
                        <tr style="font-size: 10pt;" class="text-center">
                            <th style="width: 1%;">№</th>
                            <th style="width: 25%;">Код МТР</th>
                            <th style="width: 5%;">Номер партии</th>
                            <th style="width: 50%;">Наименование МТР</th>
                            <th style="width: 5%;">Объект</th>
                            <th style="width: 7%;">Инвентарный номер </br> объекта</th>
                            <th style="width: 5%;">Ед.изм.</th>
                            <th style="width: 5%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                                data-original-title="Кол-во необходим указывать в целых или дробных значениях (Пример: целое - 34, дробное - 34.3)" >Кол-во</th>
                            <th style="width: 10%;">Филиал</th>
                            <th style="width: 5%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                                data-original-title="Режим доставки МТР:</br>
                                    1) <u>Аварийный</u> -(срочная доставка МТР к месту аварии на объектах МГ и КС или с целью исключения возникновения аварийной, сбойной ситуации)</br>
                                    2) <u>Срочный</u> - (доставка МТР для завершения выполненяемых работ, исключения срыва сроков плановых работ и т.п.)</br>
                                    3) <u>Плановый</u> - (доставка МТР поступившего согласно сроков указанных в годовой заявке филиала на приобретение МТР, не требующего срочного вовлечения в производство)</br>
                                    <font color='red'> При указании признаков: <u>аварийный</u>, <u>срочный</u>, в примечании указывается причина, по которой МТР требует внеплановой доставки.</font>" >Режим доставки </br> МТР</th>
                            <th style="width: 5%;">Примечание</th>
                            <th class="ButtonAction">Операция</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dataInfo as $item): ?>
                            <tr>
                                <td></td>
                                <td><textarea style="height:30px" name="codeMTR[]" type="text" class="codeMTR form-control" data-id-order-mtr="<?php if(isset($item['id_order'])) { echo($item['id_order']); } ?>" ><?php if(isset($item['codeMTR'])) { echo($item['codeMTR']); } ?></textarea>
                                </td>
                                <td><textarea style="width:100%; height:30px" name="numberPartMTR[]" type="text" class="numberPartMTR form-control" ><?php if(isset($item['numberPart'])) { echo($item['numberPart']); } ?></textarea></td>
                                <td><textarea style="width:100%; height:30px" name="nameMTR[]" type="text" class="nameMTR form-control" ><?php if(isset($item['nameMTR'])) { echo($item['nameMTR']); }?></textarea></td>
                                <td><select style="width:100%; height:30px" name="ukObjectMTR[]" class="form-control ukObjectMTR" >
                                        <option value=""></option>
                                        <?php foreach($objects as $item_objects): ?>
                                            <?php
                                            $sel=($item['ukObjectMTR']==$item_objects['name_object'])?"selected":""; ?>
                                            <option value="<?php echo($item_objects['name_object']); ?>" <?php echo($sel); ?> ><?php echo($item_objects['name_object']); ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><input style="height:30px" name="numberObjectMTR[]" type="text" value="<?php if(isset($item['numberObjectMTR'])) { echo($item['numberObjectMTR']); } ?>" class="numberObjectMTR form-control input-block"></td>
                                <td><select style="width:100%; height:30px" name="sizeMTR[]" class="form-control sizeMTR" >
                                        <option value=""></option>
                                        <?php foreach($measures as $item_measures): ?>
                                            <?php
                                            $sel=($item['sizeMTR']==$item_measures['name_measure'])?"selected":""; ?>
                                            <option value="<?php echo($item_measures['name_measure']); ?>" <?php echo($sel); ?> ><?php echo($item_measures['name_measure']); ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><input name="sum[]" type="text" value="<?php if(isset($item['sumMTR'])) { echo($item['sumMTR']); } ?>" class="sumMTR form-control input-block" ></td>
                                <td><select style="width:100%; height:30px" name="filialMTR[]" class="form-control filialMTR" >
                                        <option value=""></option>
                                        <?php foreach($lpu as $item_lpu): ?>
                                            <?php
                                            $sel=($item['filialMTR']==$item_lpu['name_lpu'])?"selected":""; ?>
                                            <option value="<?php echo($item_lpu['name_lpu']); ?>" <?php echo($sel); ?> ><?php echo($item_lpu['name_lpu']); ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td>
                                    <select style="width:100%; height:30px" name="deliveryMTR[]" class="form-control deliveryMTR" >
                                        <option value=""></option>
                                        <?php foreach($delivery_modes as $item_delivery_modes): ?>
                                            <?php
                                            $sel=($item['deliveryMTR']==$item_delivery_modes['name_delivery_mode'])?"selected":""; ?>
                                            <option value="<?php echo($item_delivery_modes['name_delivery_mode']); ?>" <?php echo($sel); ?> ><?php echo($item_delivery_modes['name_delivery_mode']); ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td><textarea style="width:100%; height:30px" name="noteMTR[]" class="form-control noteMTR" > <?php if(isset($item['noteMTR'])) { echo($item['noteMTR']); } ?> </textarea></td>
                                <td  class="ButtonAction">
                                    <a href="#" id="deleterow" onclick="deleteRowTable(this);" data-id-row-tablemtr="<?php if(isset($item['id_order'])) { echo($item['id_order']); } ?>" >Удалить</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!--Кнопки управления при первичном занесение данных в БД-->
                        <?php
                        $_username = $this->session->userdata('username');
                        $_actions = $this->session->userdata('actions');
                        if (isset ($_username) && ((($_actions['edit_order']) == 1) || (($_actions['delete_order']) == 1))) { ?>
                            <button id="addToTable" class="ButtonAddToTable btn btn-outline-primary">Добавить <i class="fa fa-plus"></i></button>
                            <button id="saveToTable" onclick="saveOrder();" type="button" class="ButtonSaveToTable btn btn-outline-success">Сохранить <i class="fa fa-save"></i></button>
                        <?php } ?>
                    </div>
                </div>
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
                <?php foreach($info_order as $item_info): ?>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-2 mb-3">
                            <label for="number_order_id">Распоряжение №*</label>
                            <input data-toggle="tooltip" data-html="true" name="number_order_id" id="number_order_id" type="text"
                                   class="number_order form-control"
                                   data-original-title="<font color='red'>Пример 45/12</font> </br> <u>45</u> - Код ресурсного отдела, который инициировал распоряжение. </br> <u>12</u> - Порядковый номер распоряжения проставляется, согласно реестру распоряжений, который ведётся в ресурсном отделе>"
                                   placeholder="" disabled value="<?php if(isset($item_info['number_order'])) { echo($item_info['number_order']); } ?>"
                                   data-id-order="<?php if(isset($item_info['id_all_orders'])) { echo($item_info['id_all_orders']); } ?>"
                            >
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="date_order_id">От</label>
                            <input type="text" class="form-control date" id="date_order_id"  disabled
                                   value="<?php if(isset($item_info['date_order'])) { echo(date('d-m-Y', strtotime($item_info['date_order']))); } ?>" >
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="address_order_id">Прошу отгрузить в адрес</label>
                            <select class="form-control" id="address_order_id" disabled >
                                <?php foreach($filials as $item_address): ?>
                                    <?php $select_filial=($item_address['name_filial']==$item_info['address_order'])?"selected":"";?>
                                    <option value="<?php echo($item_address['name_filial']); ?>" <?php echo($select_filial); ?> ><?php echo($item_address['name_filial']); ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="name_sklad_id">Со склада</label>
                            <select class="form-control" id="name_sklad_id" disabled >
                                <?php foreach($sklads as $item_sklad): ?>
                                    <?php $select_sklad=($item_sklad['name_sklad']==$item_info['name_sklad'])?"selected":"";?>
                                    <option value="<?php echo($item_sklad['name_sklad']); ?>" <?php echo($select_sklad); ?>><?php echo($item_sklad['name_sklad']); ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="author_order">Исполнитель</label>
                            <?php foreach($author as $item_author): ?>
                            <input type="text" class="form-control date" id="author_order" name="author_order"  disabled
                                   value="<?php if(isset($item_author['sername'])) { echo($item_author['sername']." ".$item_author['name']." ".$item_author['patronymic'] ); } ?>"
                            >
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <div class="card-footer bg-white">
                    <form action="" class="form-inline" id="excel-upl" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                        <input type="file" id="validatedCustomFile" name="fileURL" accept=".xlsx" multiple >
                        <button type="submit" name="import" class=" btn btn-primary">Импорт</button>
                    </form>
                </div>
            </div>
            <div>
                <table id="myOrder" class="table compact table-bordered table-hover tert" style="width:100%">
                    <thead>
                    <tr style="font-size: 10pt;" class="text-center">
                        <th style="width: 1%;">№</th>
                        <th style="width: 25%;">Код МТР</th>
                        <th style="width: 5%;">Номер партии</th>
                        <th style="width: 50%;">Наименование МТР</th>
                        <th style="width: 5%;">Объект</th>
                        <th style="width: 7%;">Инвентарный номер </br> объекта</th>
                        <th style="width: 5%;">Ед.изм.</th>
                        <th style="width: 5%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                            data-original-title="Кол-во необходим указывать в целых или дробных значениях (Пример: целое - 34, дробное - 34.3)</font>">Кол-во</th>
                        <th style="width: 10%;">Филиал</th>
                        <th style="width: 5%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                            data-original-title="Режим доставки МТР:</br>
                                    1) <u>Аварийный</u> -(срочная доставка МТР к месту аварии на объектах МГ и КС или с целью исключения возникновения аварийной, сбойной ситуации)</br>
                                    2) <u>Срочный</u> - (доставка МТР для завершения выполненяемых работ, исключения срыва сроков плановых работ и т.п.)</br>
                                    3) <u>Плановый</u> - (доставка МТР поступившего согласно сроков указанных в годовой заявке филиала на приобретение МТР, не требующего срочного вовлечения в производство)</br>
                                    <font color='red'> При указании признаков: <u>аварийный</u>, <u>срочный</u>, в примечании указывается причина, по которой МТР требует внеплановой доставки.</font>" >Режим доставки </br> МТР</th>
                        <th style="width: 5%;">Примечание</th>
                        <th class="ButtonAction">Операция</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td><textarea style="width:100%; height:30px" name="codeMTR[]" type="text" class="codeMTR form-control"></textarea></td>
                        <td><textarea style="width:100%; height:30px" name="numberPartMTR[]" type="text" class="numberPartMTR form-control"></textarea></td>
                        <td><textarea style="width:100%; height:30px" name="nameMTR[]" type="text" class="nameMTR form-control" ></textarea></td>
                        <td><select style="width:100%; height:30px" name="ukObjectMTR[]" class="form-control ukObjectMTR" > <option value=""></option> <?php foreach($objects as $item): ?> <option value="<?php echo($item['name_object']); ?>"><?php echo($item['name_object']); ?></option> <?php endforeach; ?> </select></td>
                        <td><input style="height:30px" name="numberObjectMTR[]" type="text" value="" class="numberObjectMTR form-control input-block" ></td>
                        <td><select style="width:100%; height:30px" name="sizeMTR[]" class="form-control sizeMTR" > <option value=""></option> <?php foreach($measures as $item): ?> <option value="<?php echo($item['name_measure']); ?>"><?php echo($item['name_measure']); ?></option> <?php endforeach; ?> </select></td>
                        <td><input style="height:30px" name="sum[]" type="text" value="" class="sumMTR form-control input-block" ></td>
                        <td><select style="width:100%; height:30px" name="filialMTR[]" class="form-control filialMTR" > <option value=""></option> <?php foreach($lpu as $item_lpu): ?> <option value="<?php echo($item_lpu['name_lpu']); ?>"><?php echo($item_lpu['name_lpu']); ?></option> <?php endforeach; ?> </select></td>
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
                    <?php
                    $_username = $this->session->userdata('username');
                    $_actions = $this->session->userdata('actions');
                    if (isset ($_username) && ((($_actions['edit_order']) == 1) || (($_actions['delete_order']) == 1))) { ?>
                        <button id="addToTable" class="ButtonAddToTable btn btn-outline-primary">Добавить <i class="fa fa-plus"></i></button>
                        <button id="saveToTable" onclick="saveOrder();" type="button" class="ButtonSaveToTable btn btn-outline-success">Сохранить <i class="fa fa-save"></i></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php } ?>
<div class="modal_loading"></div> <!--окно загрузки-->

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
<script language="javascript" type="text/javascript">
    window.onload = function(){ document.getElementById("zv-load").style.display = "none" }
</script>
<!--<script>
    //Кнопка удаление выбранных строк
    var
        $form = $("#our-form"),
        $allCheckboxes = $("input:checkbox", $form);
    $allCheckboxes.change(function() {
        var count = 0;
        $allCheckboxes.each(function (index, el) {
            var $el = $(el);
            if ($el.is(":checked")) {
                count++;
            }
        });
            $('.Checkbox_selected').click(function () {
                if (($(this).is(':checked')) && (count!=0)) {
                    // while (count > 0) {
                        $('#delete_selected').show(100);
                    console.log("я тут");
                    console.log(count);
                    count--;
                    console.log(count);

                } else {
                    console.log("я тут на закрытии");
                    $('#delete_selected').hide(100);
                }
            });
    });
</script>-->
<script>
    $body = $("body");
    $(document).on({
        ajaxStart: function() { $body.addClass("loading");    },
        ajaxStop: function() { $body.removeClass("loading"); }
    });

    $(document).ready(function() {
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
                '<td><textarea style="width:100%; height:30px" name="codeMTR[]" type="text" class="codeMTR form-control"></textarea></td>',
                '<td><textarea style="width:100%; height:30px" name="numberPartMTR[]" type="text" class="numberPartMTR form-control"></textarea></td>',
                '<td><textarea style="width:100%; height:30px" name="nameMTR[]" type="text" class="nameMTR form-control"></textarea></td>',
                '<td><select style="width:100%; height:30px" name="ukObjectMTR[]" class="form-control ukObjectMTR"> <option value=""></option> <?php foreach($objects as $item): ?> <option value="<?php echo($item['name_object']); ?>"><?php echo($item['name_object']); ?></option> <?php endforeach; ?> </select></td>',
                '<td><input style="height:30px" name="numberObjectMTR[]" type="text" value="" class="numberObjectMTR form-control input-block" ></td>',
                '<td><select style="width:100%; height:30px" name="sizeMTR[]" class="form-control sizeMTR"> <option value=""></option> <?php foreach($measures as $item): ?> <option value="<?php echo($item['name_measure']); ?>"><?php echo($item['name_measure']); ?></option> <?php endforeach; ?> </select></td>',
                '<td><input style="width:100%; height:30px" name="sumMTR[]" type="text" value="" required class="form-control sumMTR" ></td>',
                '<td><select style="width:100%; height:30px" name="filialMTR[]" class="form-control filialMTR" > <option value=""></option> <?php foreach($lpu as $item_lpu): ?> <option value="<?php echo($item_lpu['name_lpu']); ?>"><?php echo($item_lpu['name_lpu']); ?></option> <?php endforeach; ?> </select></td>',
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

//Кнопка удаления выбранных строк
    function delete_selected_checkbox(id){
        if (confirm("Вы точно хотите удалить строки безбозвратно?")){
            $('input:checkbox:checked').each(function(){
                var checked_id = ($(this).val());
                $.ajax({
                    type: "POST",
                    url: "<?=base_url();?>Main/deleteCheckedRowTable",
                    data: {id : checked_id},
                    success: function(data) {
                        console.log(data);
                    }
                });
            });
        }
        var t = document.getElementById('number_order_id');
        var JSid_order = t.getAttribute('data-id-order');
        console.log(JSid_order);
        window.location = "<?=base_url();?>Main/formation_order?id_all_order=" + JSid_order;
    }

//Возврат на список распоряжений
    function showOrders(){
        if(confirm ("Вы точно хотите выйти не сохранив изменения?")) {
            window.location.replace("<?=base_url();?>Main/range_date_orders");
        }
    }

    function validation_form() {
        var arr = []; //Счетчик ошибок при заполнении формы
//Валидация Примечания
        var length_noteMTR = document.getElementsByClassName('noteMTR').length;
        var a = 0;
        while (a < length_noteMTR) {
            var noteMTR_element = $('.noteMTR');
            var number_noteMTR = noteMTR_element.eq(a).val();
            var deliveryMTR_element = $('.deliveryMTR');
            var number_deliveryMTR = deliveryMTR_element.eq(a).val();

            if (number_deliveryMTR == 'Плановый') {
                noteMTR_element.eq(a).removeClass('is-invalid');
                deliveryMTR_element.eq(a).removeClass('is-invalid');
                deliveryMTR_element.eq(a).addClass('is-valid');
                noteMTR_element.eq(a).addClass('is-valid');
                arr[arr.length] = 1;
            } else if (number_deliveryMTR == 'Аварийный' || number_deliveryMTR == 'Срочный') {
                if ((number_noteMTR == '') || (number_noteMTR == ' ') || (number_noteMTR == '  ')) {
                    deliveryMTR_element.eq(a).removeClass('is-valid');
                    noteMTR_element.eq(a).removeClass('is-valid');
                    deliveryMTR_element.eq(a).addClass('is-invalid');
                    noteMTR_element.eq(a).addClass('is-invalid');
                    arr[arr.length] = 0;
                } else {
                    deliveryMTR_element.eq(a).removeClass('is-invalid');
                    noteMTR_element.eq(a).removeClass('is-invalid');
                    deliveryMTR_element.eq(a).addClass('is-valid');
                    noteMTR_element.eq(a).addClass('is-valid');
                    arr[arr.length] = 1;
                }
            } else {
                deliveryMTR_element.eq(a).removeClass('is-valid');
                noteMTR_element.eq(a).removeClass('is-valid');
                noteMTR_element.eq(a).addClass('is-invalid');
                deliveryMTR_element.eq(a).addClass('is-invalid');
                arr[arr.length] = 0;
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
//Валидация Кол-ва МТР
        var length_sumMTR = document.getElementsByClassName('sumMTR').length;
        console.log(length_sumMTR);
        var c = 0;
        while (c < length_sumMTR) {
            var sumMTR_element = $('.sumMTR');
            var JSsumMTR = document.getElementsByClassName('sumMTR')[c].value;
            console.log(JSsumMTR);
            var sumMTR = sumMTR_element.eq(c).val();
            console.log("Количество-" + sumMTR);
            var parse_sumMTR = parseFloat(sumMTR);
            console.log("Функция parseFloat-" + parse_sumMTR);
            if (parse_sumMTR == sumMTR) {
                sumMTR_element.eq(c).removeClass('is-invalid');
                sumMTR_element.eq(c).addClass('is-valid');
                arr[arr.length] = 1;
            } else {
                sumMTR_element.eq(c).addClass('is-invalid');
                arr[arr.length] = 0;
            }
            c++;
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
            if (confirm("Вы точно хотите сохранить данные?")) {
                var m = 0;
/*формирование запроса к базе Order_MTR*/
                var massive_JScodeMTR = [];
                var massive_JSnumberPartMTR = [];
                var massive_JSnameMTR = [];
                var massive_JSukObjectMTR = [];
                var massive_JSnumberObjectMTR = [];
                var massive_JSsizeMTR = [];
                var massive_JSsumMTR = [];
                var massive_JSfilialMTR = [];
                var massive_JSdeliveryMTR = [];
                var massive_JSnoteMTR = [];

                var JSnumber_orderMTR = document.getElementById('number_order_id').value;
                var JSdate_orderMTR = document.getElementById('date_order_id').value;
                var JSaddress_orderMTR = document.getElementById('address_order_id').value;
                var JSname_skladMTR = document.getElementById('name_sklad_id').value;
                var JSauthor_order = document.getElementById('author_order').value;
                var t_id_order = document.getElementById('number_order_id');
                var JSid_order = t_id_order.getAttribute('data-id-order');

                var number_codeMTR = document.getElementsByClassName('codeMTR').length;
                while (m < number_codeMTR) {
                    var JScodeMTR = document.getElementsByClassName('codeMTR')[m].value;
                    var JSnumberPartMTR = document.getElementsByClassName('numberPartMTR')[m].value;
                    var JSnameMTR = document.getElementsByClassName('nameMTR')[m].value;
                    var JSukObjectMTR = document.getElementsByClassName('ukObjectMTR')[m].value;
                    var JSnumberObjectMTR = document.getElementsByClassName('numberObjectMTR')[m].value;
                    var JSsizeMTR = document.getElementsByClassName('sizeMTR')[m].value;
                    var JSsumMTR = document.getElementsByClassName('sumMTR')[m].value;
                    var JSfilialMTR = document.getElementsByClassName('filialMTR')[m].value;
                    var JSdeliveryMTR = document.getElementsByClassName('deliveryMTR')[m].value;
                    var JSnoteMTR = document.getElementsByClassName('noteMTR')[m].value;
                    console.log(JSnameMTR);
                    console.log(JSsumMTR);
                    massive_JScodeMTR.push(JScodeMTR);
                    massive_JSnumberPartMTR.push(JSnumberPartMTR);
                    massive_JSnameMTR.push(JSnameMTR);
                    massive_JSukObjectMTR.push(JSukObjectMTR);
                    massive_JSnumberObjectMTR.push(JSnumberObjectMTR);
                    massive_JSsizeMTR.push(JSsizeMTR);
                    massive_JSsumMTR.push(JSsumMTR);
                    massive_JSfilialMTR.push(JSfilialMTR);
                    massive_JSdeliveryMTR.push(JSdeliveryMTR);
                    massive_JSnoteMTR.push(JSnoteMTR);
                    m++;
                }

                var json_JScodeMTR = JSON.stringify(massive_JScodeMTR);
                var json_JSnumberPartMTR = JSON.stringify(massive_JSnumberPartMTR);
                var json_JSnameMTR = JSON.stringify(massive_JSnameMTR);
                var json_JSukObjectMTR = JSON.stringify(massive_JSukObjectMTR);
                var json_JSnumberObjectMTR = JSON.stringify(massive_JSnumberObjectMTR);
                var json_JSsizeMTR = JSON.stringify(massive_JSsizeMTR);
                var json_JSsumMTR = JSON.stringify(massive_JSsumMTR);
                var json_JSfilialMTR = JSON.stringify(massive_JSfilialMTR);
                var json_JSdeliveryMTR = JSON.stringify(massive_JSdeliveryMTR);
                var json_JSnoteMTR = JSON.stringify(massive_JSnoteMTR);
    // console.log(json_JSnameMTR);
                $.ajax({
                    url: "<?=base_url();?>Main/saveOrderMTR",
                    type: "POST",
                    data: {
                        codeMTR: json_JScodeMTR,
                        numberPartMTR: json_JSnumberPartMTR,
                        nameMTR: json_JSnameMTR,
                        ukObjectMTR: json_JSukObjectMTR,
                        numberObjectMTR: json_JSnumberObjectMTR,
                        sizeMTR: json_JSsizeMTR,
                        sumMTR: json_JSsumMTR,
                        filialMTR: json_JSfilialMTR,
                        deliveryMTR: json_JSdeliveryMTR,
                        noteMTR: json_JSnoteMTR,
                        number_orderMTR: JSnumber_orderMTR,
                        date_orderMTR: JSdate_orderMTR,
                        address_orderMTR: JSaddress_orderMTR,
                        name_skladMTR: JSname_skladMTR,
                        author_order: JSauthor_order,
                        id_order: JSid_order
                    },
                    success: function (datax) {
                        console.log(datax);
                        window.location = "<?=base_url();?>Main/formation_order?id_all_order=" + datax;
                    },
                    error:function(data){
                        console.log(data);
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
            if (confirm ("Вы точно хотите сохранить внесенные изменения?")) {
                /*Show and Hide кнопок управления*/
                $('.ButtonAction').hide();
                $('.ButtonSaveToTable').hide();
                $('.ButtonAddToTable').hide();
                $('.ButtonSaveEditToTable').hide();
                $('.ButtonEndTotable').show();
                $('.ButtonEditToTable').show();
                $('.ButtonExportXLS').show();

                /*Show and Hide input table*/
                $(".checkboxMTR").prop("disabled", true);
                $(".codeMTR").prop("disabled", true);
                $(".nameMTR").prop("disabled", true);
                $(".ukObjectMTR").prop("disabled", true);
                $(".numberObjectMTR").prop("disabled", true);
                $(".sizeMTR").prop("disabled", true);
                $(".sumMTR").prop("disabled", true);
                $(".filialMTR").prop("disabled", true);
                $(".deliveryMTR").prop("disabled", true);
                $(".noteMTR").prop("disabled", true);
                
                var m = 0;
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
                    var JSnumberPartMTR = document.getElementsByClassName('numberPartMTR')[m].value;
                    var JSnameMTR = document.getElementsByClassName('nameMTR')[m].value;
                    var JSukObjectMTR = document.getElementsByClassName('ukObjectMTR')[m].value;
                    var JSnumberObjectMTR = document.getElementsByClassName('numberObjectMTR')[m].value;
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
                    console.log(JSnumberPartMTR);
                    console.log(JSnameMTR);
                    console.log(JSukObjectMTR);
                    console.log(JSnumberObjectMTR);
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
                            id_rowMTR: JSid_rowMTR,
                            id_orderMTR: JSid_orderMTR,
                            codeMTR: JScodeMTR,
                            numberPartMTR: JSnumberPartMTR,
                            nameMTR: JSnameMTR,
                            ukObjectMTR: JSukObjectMTR,
                            numberObjectMTR: JSnumberObjectMTR,
                            sizeMTR: JSsizeMTR,
                            sumMTR: JSsumMTR,
                            filialMTR: JSfilialMTR,
                            deliveryMTR: JSdeliveryMTR,
                            noteMTR: JSnoteMTR,
                            number_orderMTR: JSnumber_orderMTR,
                            date_orderMTR: JSdate_orderMTR,
                            name_skladMTR: JSname_skladMTR,
                            address_orderMTR: JSaddress_orderMTR,
                        },
                        success: function (data) {
                            console.log(data);
                            //window.location = "<?//=base_url();?>//Main/formation_order?id_all_order=" + JSid_orderMTR;
                        }
                    });
                    m++;
                }
            }
        } else {
            alert("Обнаружены ошибки при сохранении формы, исправте ошибки и попробуйте снова");
        }
    }

//Режим редактирования распоряжения
    function editOrder(){
/*Show and Hide кнопок управления*/
        $('.ButtonEndTotable').hide();
        $('.ButtonEditToTable').hide();
        $('.ButtonExportXLS').hide();
        $('.ButtonAction').show();
        $('.ButtonAddToTable').show();
        $('.ButtonSaveEditToTable').show();
        $('#delete_selected').show();

/*Show and Hide input table*/
        $(".checkboxMTR").prop("disabled", false);
        $(".codeMTR").prop("disabled", false);
        $(".numberPartMTR").prop("disabled", false);
        $(".nameMTR").prop("disabled", false);
        $(".ukObjectMTR").prop("disabled", false);
        $(".numberObjectMTR").prop("disabled", false);
        $(".sizeMTR").prop("disabled", false);
        $(".sumMTR").prop("disabled", false);
        $(".filialMTR").prop("disabled", false);
        $(".deliveryMTR").prop("disabled", false);
        $(".noteMTR").prop("disabled", false);
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

//Экспорт в Excel
    function sample_order(){
        var t = document.getElementById('number_order_id');

        console.log("Export sample XSL");
        console.log(JSid_order);

        $.ajax({
            url: "<?=base_url();?>Main/sample_order",
            type: "POST",
            data: {JSid_order : JSid_order},
            success: function(data){
                window.location ="<?=base_url();?>Main/sample_order?JSid_order="+JSid_order;
            }
        })
    }

//Отмена последних изменений выход из режима редактирования информации о движении МТР
    function ExitEditMotion(){
        window.location ="<?=base_url();?>Main/range_date_orders";
    }

//передача распоряжения на согласование
    function OrderNach(){
        if(confirm("Вы точно хотите завершить формирование распоряжения и передать его на согласование?")) {
            var t = document.getElementById('number_order_id');
            var JSid_order = t.getAttribute('data-id-order');
            $.ajax({
                type: "POST",
                url: "<?=base_url();?>Main/OrderNach",
                data: {id_order : JSid_order},
                success: function(data){
                    console.log(data);
                    $('.ButtonEndTotable').hide();
                    window.location = "<?=base_url();?>Main/formation_order?id_all_order=" + JSid_order;
                }
            });
        }
    }
</script>