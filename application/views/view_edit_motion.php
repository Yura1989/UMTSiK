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
    <a class="navbar-brand" href="#">Информации о движении МТР на базе </a>
    <?php
    $_username = $this->session->userdata('username');
    $_actions = $this->session->userdata('actions');
    if (isset ($_username) && (($_actions['edit_motion']) == 1) ) { ?>
        <button id="editToTable" onclick="endGameMotion();" type="button" class="ButtonEndGameToTable btn btn-outline-warning">Завершить <i class="fa fa-pencil"></i></button>
    <?php } ?>
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
                    <h2 class="text-success id_motion" data-gid_motion="<?php foreach($info_motion as $item_motion): ?><?php if(isset($item_motion['number_motion'])) { echo($item_motion['number_motion']); } ?>"<?php endforeach ?> data-id_motion="<?php foreach($info_motion as $item_motion): ?><?php if(isset($item_motion['id_all_motion'])) { echo($item_motion['id_all_motion']); } ?>"<?php endforeach ?> >Ввод информации о движении МТР на базе</h2>
                </div>
                <div class="card-body">
                    <p>
                        <a class="btn btn-warning" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Дополнительная информация:
                        </a>
                    </p>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <div class="mb-3">
                                <form class="form-inline">
                                    <div class="form-check mr-sm-2">
                                        <label for="validationServer03">Дата изменения:</label>
                                    </div>
                                    <div class="form-check mr-sm-2">
                                        <select class="form-control" id="guid_date_edit_motion" >
                                            <?php foreach($date_edit_motion as $item_date_edit_motion): ?>
                                                <?php if($item_date_edit_motion['date_edit_motion'] != '0000-00-00') { ?>
                                                    <?php $select_date=($_GET['guid_edit_motion']==$item_date_edit_motion['bond_guid_motion_date'])?"selected":"";?>
                                                    <option value="<?php echo($item_date_edit_motion['bond_guid_motion_date']); ?>" <?php echo($select_date); ?> ><?php echo($item_date_edit_motion['date_edit_motion']); ?></option>
                                                <?php }
                                            endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-check mr-sm-2">
                                        <button type="button" onclick="DateEditMotion();" class="ButtonDateMotion btn btn-outline-info">Просмотреть</button>
                                    </div>
                                    <div class="form-check mr-sm-2">
                                        <button type="button" onclick="DateAllEditMotion();" class="ButtonDateMotion btn btn-outline-info">Просмотреть все</button>
                                    </div>
                                </form>
                            </div>
                            <div class="mb-3">
                                <form class="form-inline">
                                    <div class="form-check mr-sm-2">
                                        <button type="button" onclick="ErrorEditMotion();" class="ButtonDateMotion btn btn-outline-primary">Режим исправления ошибок</button>
                                    </div>
                                </form>
                            </div>
                           Сформированно на основании:
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
                </div>
            </div>
                <table id="myMotion" class="table table-bordered hover tert" style="width:100%">
                    <thead>
                    <tr class="text-center" style="background: rgb(224, 78, 57)">
                        <th rowspan="2" scope="row">№</th>
                        <th rowspan="2" style="width: 10%;">Код МТР</th>
                        <th rowspan="2" style="width: 40%;">Наименование МТР</th>
                        <th colspan="3" rowspan="1" style="width: 5%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                            data-original-title="Указывается представителем базы или участка погрузочно-разгрузочных работ по запросу перевозчика">Массогабаритные характеристики***</th>
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
<!--Когда строка еще не использовалась-->
                        <?php if ((($item['bond_guid_motion_date']) == NULL) || (($item['shipped_motion']) == 0) ) {?>
                            <tr>
                                <td></td>
                                <td class="code_mtr_class" data-bond_guid_motion_date="<?php echo($bond_guid_motion_date); ?>"> <?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?></td>
                                <td class="id_order_mtr_class" data-id_motion="<?php if(isset($item['id_motion'])) echo($item['id_motion']); ?>" data-id_order_mtr="<?php if(isset($item['id_order'])) echo($item['id_order']); ?>"><?php if(isset($item['nameMTR'])) echo($item['nameMTR']); ?></td>
                                <td><input name="length_motion[]" type="text" class="length_motion form-control input-block" disabled value="<?php if(isset($item['length_motion'])) echo($item['length_motion']); ?>"></td>
                                <td><input name="width_motion[]" type="text" class="width_motion form-control input-block" disabled value="<?php if(isset($item['width_motion'])) echo($item['width_motion']); ?>"></td>
                                <td><input name="height_motion[]" type="text" class="height_motion form-control input-block" disabled value="<?php if(isset($item['height_motion'])) echo($item['height_motion']); ?>"></td>
                                <td><?php if(isset($item['sizeMTR'])) echo($item['sizeMTR']); ?></td>
                                <td><?php if(isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?></td>
                                <td><?php if(isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?></td>
                                <td class="sum_mtr" data-sum_mtrr="<?php if(isset($item['all_mtr'])) echo($item['all_mtr']); ?>" ><?php if(isset($item['all_mtr'])) echo($item['all_mtr']); ?></td>
                                <td><input name="weight_motion[]" type="text" class="weight_motion form-control input-block" disabled value="<?php if(isset($item['weight_motion'])) echo($item['weight_motion']); ?>"></td>
                                <td><input name="total_motion[]" type="text" class="total_motion form-control input-block" disabled value="<?php if(isset($item['total_motion'])) echo($item['total_motion']); ?>"></td>
                                <td>
                                    <div class="input-group ">
                                        <input name="cargo_motion[]" type="text" class="cargo_motion form-control input-block" disabled value="<?php if(isset($item['cargo_motion'])) echo($item['cargo_motion']); ?>">
                                            <button type="button" disabled onclick="addString2(this);" class="buttonCopy copy btn btn-primary btn-sm btn-icon" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-fw fa-cog"></i></button>
                                    </div>
                                    <button type="button" disabled onclick="addString(this);" class="buttonCopy copy btn btn-primary btn-sm btn-icon" ><i class="fa fa-fw fa-cog"></i></button>
                                    <button type="button" disabled onclick="add_row_mtr(this);" class="buttonCopy copy btn btn-primary btn-sm btn-icon" ><i class="fa fa-fw fa-cog"></i></button>

                                </td>
                                <td><input name="dateRequest_motion[]" type="text" class="dateRequest_motion form-control date_order_id" autocomplete="off" disabled value="<?php if(isset($item['dateRequest_motion'])) echo($item['dateRequest_motion']); ?>"></td>
                                <td><input name="dateShipments_motion[]" type="text" class="dateShipments_motion form-control date_order_id" autocomplete="off" disabled value="<?php if(isset($item['dateShipments_motion'])) echo($item['dateShipments_motion']); ?>"></td>
                                <td><input name="infoShipments_motion[]" type="text" class="infoShipments_motion form-control input-block" disabled value="<?php if(isset($item['length_motion'])) echo($item['infoShipments_motion']); ?>"></td>
                                <td><input name="shipped_motion[]" type="text" class="shipped_motion form-control input-block" disabled value="<?php if(isset($item['shipped_motion'])) echo($item['shipped_motion']); ?>"></td>
                                <td><input name="remains_motion[]" type="text" class="remains_motion form-control input-block" disabled value="<?php if(isset($item['remains_motion'])) echo($item['remains_motion']); ?>"></td>
                                <td><?php if(isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?></td>
                                <td><?php if(isset($item['filialMTR'])) echo($item['filialMTR']); ?></td>
                                <td><input name="numberOverhead_motion[]" type="text" class="numberOverhead_motion form-control input-block" disabled  value="<?php if(isset($item['numberOverhead_motion'])) echo($item['numberOverhead_motion']); ?>"></td>
                                <td><input name="dateOverhead_motion[]" type="text" class="dateOverhead_motion form-control input-block date_order_id" autocomplete="off" disabled value="<?php if(isset($item['dateOverhead_motion'])) echo($item['dateOverhead_motion']); ?>"></td>
                                <td><?php if(isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?></td>
                                <td><?php if(isset($item['noteMTR'])) echo($item['noteMTR']); ?></td>
                                <td><textarea style="width:100%; height:30px" name="note_motion[]" class="form-control note_motion" disabled > <?php if(isset($item['note_motion'])) echo($item['note_motion']); ?></textarea></td>
<!--   Информация заполняемая участками -->
                                <td><input name="dateArrival_motion[]" type="text" class="dateArrival_motion form-control date_order_id" autocomplete="off" disabled value="<?php if(isset($item['dateArrival_motion'])) echo($item['dateArrival_motion']); ?>"></td>
                                <td><input name="numberM15_motion[]" type="text" class="numberM15_motion form-control input-block" disabled value="<?php if(isset($item['numberM15_motion'])) echo($item['numberM15_motion']); ?>"></td>
                                <td><input name="dateM15_motion[]" type="text" class="dateM15_motion form-control input-block date_order_id" autocomplete="off" disabled value="<?php if(isset($item['dateM15_motion'])) echo($item['dateM15_motion']); ?>"></td>
                                <td><input name="dateFilial_motion[]" type="text" class="dateFilial_motion form-control date_order_id" autocomplete="off" disabled value="<?php if(isset($item['dateFilial_motion'])) echo($item['dateFilial_motion']); ?>"></td>
                            </tr>
<!--Заходим в режим редактирования строк-->
                        <?php } elseif ((isset($_GET['guid_edit_motion'])) && (($_GET['guid_edit_motion']) == $item['bond_guid_motion_date'])) { ?>
                            <tr>
                                <td></td>
                                <td class="code_mtr_class" data-bond_guid_motion_date="<?php echo($bond_guid_motion_date); ?>"> <?php if(isset($item['codeMTR'])) echo($item['codeMTR']); ?></td>
                                <td class="id_order_mtr_class" data-id_motion="<?php if(isset($item['id_motion'])) echo($item['id_motion']); ?>" data-id_order_mtr="<?php if(isset($item['id_order'])) echo($item['id_order']); ?>"><?php if(isset($item['nameMTR'])) echo($item['nameMTR']); ?></td>
                                <td><input name="length_motion[]" type="text" class="length_motion form-control input-block" disabled value="<?php if(isset($item['length_motion'])) echo($item['length_motion']); ?>"></td>
                                <td><input name="width_motion[]" type="text" class="width_motion form-control input-block" disabled value="<?php if(isset($item['width_motion'])) echo($item['width_motion']); ?>"></td>
                                <td><input name="height_motion[]" type="text" class="height_motion form-control input-block" disabled value="<?php if(isset($item['height_motion'])) echo($item['height_motion']); ?>"></td>
                                <td><?php if(isset($item['sizeMTR'])) echo($item['sizeMTR']); ?></td>
                                <td><?php if(isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?></td>
                                <td><?php if(isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?></td>
                                <td class="sum_mtr" data-sum_mtrr="<?php if(isset($item['all_mtr'])) echo($item['all_mtr']); ?>" ><?php if(isset($item['all_mtr'])) echo($item['all_mtr']); ?></td>
                                <td><input name="weight_motion[]" type="text" class="weight_motion form-control input-block" disabled value="<?php if(isset($item['weight_motion'])) echo($item['weight_motion']); ?>"></td>
                                <td><input name="total_motion[]" type="text" class="total_motion form-control input-block" disabled value="<?php if(isset($item['total_motion'])) echo($item['total_motion']); ?>"></td>
                                <td>
                                    <div class="input-group ">
                                        <input name="cargo_motion[]" type="text" class="cargo_motion form-control input-block" disabled value="<?php if(isset($item['cargo_motion'])) echo($item['cargo_motion']); ?>">
                                        <button type="button" disabled onclick="infoString(this);" class="buttonCopy copy btn btn-primary btn-sm btn-icon" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-fw fa-cog"></i></button>
                                    </div>
                                </td>
                                <td><input name="dateRequest_motion[]" type="text" class="dateRequest_motion form-control date_order_id" autocomplete="off" disabled value="<?php if(isset($item['dateRequest_motion'])) echo($item['dateRequest_motion']); ?>"></td>
                                <td><input name="dateShipments_motion[]" type="text" class="dateShipments_motion form-control date_order_id" autocomplete="off" disabled value="<?php if(isset($item['dateShipments_motion'])) echo($item['dateShipments_motion']); ?>"></td>
                                <td><input name="infoShipments_motion[]" type="text" class="infoShipments_motion form-control input-block" disabled value="<?php if(isset($item['length_motion'])) echo($item['infoShipments_motion']); ?>"></td>
                                <td><input name="shipped_motion[]" type="text" class="shipped_motion form-control input-block" disabled value="<?php if(isset($item['shipped_motion'])) echo($item['shipped_motion']); ?>"></td>
                                <td><input name="remains_motion[]" type="text" class="remains_motion form-control input-block" disabled value="<?php if(isset($item['remains_motion'])) echo($item['remains_motion']); ?>"></td>
                                <td><?php if(isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?></td>
                                <td><?php if(isset($item['filialMTR'])) echo($item['filialMTR']); ?></td>
                                <td><input name="numberOverhead_motion[]" type="text" class="numberOverhead_motion form-control input-block" disabled  value="<?php if(isset($item['numberOverhead_motion'])) echo($item['numberOverhead_motion']); ?>"></td>
                                <td><input name="dateOverhead_motion[]" type="text" class="dateOverhead_motion form-control input-block date_order_id" autocomplete="off" disabled value="<?php if(isset($item['dateOverhead_motion'])) echo($item['dateOverhead_motion']); ?>"></td>
                                <td><?php if(isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?></td>
                                <td><?php if(isset($item['noteMTR'])) echo($item['noteMTR']); ?></td>
                                <td><textarea style="width:100%; height:30px" name="note_motion[]" class="form-control note_motion" disabled > <?php if(isset($item['note_motion'])) echo($item['note_motion']); ?></textarea></td>
                                <!--   Информация заполняемая участками -->
                                <td><input name="dateArrival_motion[]" type="text" class="dateArrival_motion form-control date_order_id" autocomplete="off" disabled value="<?php if(isset($item['dateArrival_motion'])) echo($item['dateArrival_motion']); ?>"></td>
                                <td><input name="numberM15_motion[]" type="text" class="numberM15_motion form-control input-block" disabled value="<?php if(isset($item['numberM15_motion'])) echo($item['numberM15_motion']); ?>"></td>
                                <td><input name="dateM15_motion[]" type="text" class="dateM15_motion form-control input-block date_order_id" autocomplete="off" disabled value="<?php if(isset($item['dateM15_motion'])) echo($item['dateM15_motion']); ?>"></td>
                                <td><input name="dateFilial_motion[]" type="text" class="dateFilial_motion form-control date_order_id" autocomplete="off" disabled value="<?php if(isset($item['dateFilial_motion'])) echo($item['dateFilial_motion']); ?>"></td>
                            </tr>
<!--Показываем ранее заполненные строки-->
                            <?php } ?>
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td class="code_mtr_class_prev" data-bond_guid_motion_date="--><?php //echo($item['bond_guid_motion_date']); ?><!--"> --><?php //if(isset($item['codeMTR'])) echo($item['codeMTR']); ?><!--</td>-->
<!--                                <td class="id_order_mtr_class_prev" data-id_motion="--><?php //if(isset($item['id_motion'])) echo($item['id_motion']); ?><!--" data-id_order_mtr="--><?php //if(isset($item['id_order'])) echo($item['id_order']); ?><!--">--><?php //if(isset($item['nameMTR'])) echo($item['nameMTR']); ?><!--</td>-->
<!--                                <td><input name="length_motion_prev[]" type="text" class="length_motion_prev form-control input-block" disabled value="--><?php //if(isset($item['length_motion'])) echo($item['length_motion']); ?><!--"></td>-->
<!--                                <td><input name="width_motion_prev[]" type="text" class="width_motion_prev form-control input-block" disabled value="--><?php //if(isset($item['width_motion'])) echo($item['width_motion']); ?><!--"></td>-->
<!--                                <td><input name="height_motion_prev[]" type="text" class="height_motion_prev form-control input-block" disabled value="--><?php //if(isset($item['height_motion'])) echo($item['height_motion']); ?><!--"></td>-->
<!--                                <td>--><?php //if(isset($item['sizeMTR'])) echo($item['sizeMTR']); ?><!--</td>-->
<!--                                <td>--><?php //if(isset($item['ukObjectMTR'])) echo($item['ukObjectMTR']); ?><!--</td>-->
<!--                                <td>--><?php //if(isset($item['numberObjectMTR'])) echo($item['numberObjectMTR']); ?><!--</td>-->
<!--                                <td class="sum_mtr_prev" data-sum_mtrr="--><?php //if(isset($item['all_mtr'])) echo($item['all_mtr']); ?><!--" >--><?php //if(isset($item['all_mtr'])) echo($item['all_mtr']); ?><!--</td>-->
<!--                                <td><input name="weight_motion_prev[]" type="text" class="weight_motion_prev form-control input-block" disabled value="--><?php //if(isset($item['weight_motion'])) echo($item['weight_motion']); ?><!--"></td>-->
<!--                                <td><input name="total_motion_prev[]" type="text" class="total_motion_prev form-control input-block" disabled value="--><?php //if(isset($item['total_motion'])) echo($item['total_motion']); ?><!--"></td>-->
<!--                                <td>-->
<!--                                    <div class="input-group ">-->
<!--                                        <input name="cargo_motion_prev[]" type="text" class="cargo_motion_prev form-control input-block" disabled value="--><?php //if(isset($item['cargo_motion'])) echo($item['cargo_motion']); ?><!--">-->
<!--                                      </div>-->
<!--                                </td>-->
<!--                                <td><input name="dateRequest_motion_prev[]" type="text" class="dateRequest_motion_prev form-control date_order_id" autocomplete="off" disabled value="--><?php //if(isset($item['dateRequest_motion'])) echo($item['dateRequest_motion']); ?><!--"></td>-->
<!--                                <td><input name="dateShipments_motion_prev[]" type="text" class="dateShipments_motion_prev form-control date_order_id" autocomplete="off" disabled value="--><?php //if(isset($item['dateShipments_motion'])) echo($item['dateShipments_motion']); ?><!--"></td>-->
<!--                                <td><input name="infoShipments_motion_prev[]" type="text" class="infoShipments_motion_prev form-control input-block" disabled value="--><?php //if(isset($item['length_motion'])) echo($item['infoShipments_motion']); ?><!--"></td>-->
<!--                                <td><input name="shipped_motion_prev[]" type="text" class="shipped_motion_prev form-control input-block" disabled value="--><?php //if(isset($item['shipped_motion'])) echo($item['shipped_motion']); ?><!--"></td>-->
<!--                                <td><input name="remains_motion_prev[]" type="text" class="remains_motion_prev form-control input-block" disabled value="--><?php //if(isset($item['remains_motion'])) echo($item['remains_motion']); ?><!--"></td>-->
<!--                                <td>--><?php //if(isset($item['address_orderMTR'])) echo($item['address_orderMTR']); ?><!--</td>-->
<!--                                <td>--><?php //if(isset($item['filialMTR'])) echo($item['filialMTR']); ?><!--</td>-->
<!--                                <td><input name="numberOverhead_motion_prev[]" type="text" class="numberOverhead_motion_prev form-control input-block" disabled  value="--><?php //if(isset($item['numberOverhead_motion'])) echo($item['numberOverhead_motion']); ?><!--"></td>-->
<!--                                <td><input name="dateOverhead_motion_prev[]" type="text" class="dateOverhead_motion_prev form-control input-block date_order_id" autocomplete="off" disabled value="--><?php //if(isset($item['dateOverhead_motion'])) echo($item['dateOverhead_motion']); ?><!--"></td>-->
<!--                                <td>--><?php //if(isset($item['noteMTR'])) echo($item['noteMTR']); ?><!--</td>-->
<!--                                <td>--><?php //if(isset($item['deliveryMTR'])) echo($item['deliveryMTR']); ?><!--</td>-->
<!--                                <td><textarea style="width:100%; height:30px" name="note_motion_prev[]" class="form-control note_motion_prev" disabled > --><?php //if(isset($item['note_motion'])) echo($item['note_motion']); ?><!--</textarea></td>-->
<!--                                <!--Информация заполняемая участками-->
<!--                                <td><input name="dateArrival_motion_prev[]" type="text" class="dateArrival_motion_prev form-control date_order_id" autocomplete="off" disabled value="--><?php //if(isset($item['dateArrival_motion'])) echo($item['dateArrival_motion']); ?><!--"></td>-->
<!--                                <td><input name="numberM15_motion_prev[]" type="text" class="numberM15_motion_prev form-control input-block" disabled value="--><?php //if(isset($item['numberM15_motion'])) echo($item['numberM15_motion']); ?><!--"></td>-->
<!--                                <td><input name="dateM15_motion_prev[]" type="text" class="dateM15_motion_prev form-control input-block date_order_id" autocomplete="off" disabled value="--><?php //if(isset($item['dateM15_motion'])) echo($item['dateM15_motion']); ?><!--"></td>-->
<!--                                <td><input name="dateFilial_motion_prev[]" type="text" class="dateFilial_motion_prev form-control date_order_id" autocomplete="off" disabled value="--><?php //if(isset($item['dateFilial_motion'])) echo($item['dateFilial_motion']); ?><!--"></td>-->
<!--                            </tr>-->
<!--                        --><?php //} ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <br />
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
                <div class="form-group">
                    <label for="cargo_motion">Груз сформирован в контейнер/автотранспорт</label>
                    <input name="cargo_motion[]" type="text" class="cargo_motion form-control input-block" disabled value="<?php if(isset($item['cargo_motion'])) echo($item['cargo_motion']); ?>">
                </div>
                <div class="form-group">
                    <label for="shipped_motion">Отгружено</label>
                    <input name="shipped_motion[]" type="text" class="shipped_motion form-control input-block" disabled value="<?php if(isset($item['shipped_motion'])) echo($item['shipped_motion']); ?>">
                </div>
                <div class="form-group">
                    <label for="remains_motion">Остаток</label>
                    <input name="remains_motion[]" type="text" class="remains_motion form-control input-block" disabled value="<?php if(isset($item['remains_motion'])) echo($item['remains_motion']); ?>">
                </div>
            </div>
            <table id="myMotion2" class="table table-bordered hover tert" style="width:100%">
                <thead>
                <tr class="text-center" style="background: rgb(224, 78, 57)">
                    <th rowspan="2" scope="row">№</th>
                    <th rowspan="2" style="width: 10%;">Код МТР</th>
                    <th rowspan="2" style="width: 40%;">Наименование МТР</th>
                    <th colspan="3" rowspan="1" style="width: 5%;" data-toggle="tooltip"  data-placement="left" data-html="true"
                        data-original-title="Указывается представителем базы или участка погрузочно-разгрузочных работ по запросу перевозчика">Массогабаритные характеристики***</th>
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
                </tbody>
            </table>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" onclick="addString2(this);" class="btn btn-primary" data-dismiss="modal">Добавить</button>
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
//            fixedHeader: true,
            "scrollY":   '50vh',
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
                format: 'yyyy-mm-dd'
            });
        });
    } );

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

//Сохранение изменения распоряжения с занесением в базу
    function saveEditMotion() {
        var check_validation = validation_form();
        console.log(check_validation);
//        check_validation = 1;
        if (check_validation == 1 ){
            console.log("true");
            if (confirm ("Вы точно хотите сохранить внесенные изменения?")) {
                /*Show and Hide кнопок управления*/
                $('.ButtonSaveEditToTable').hide();
                $('.ButtonCancelEditMotion').hide();
                $('.ButtonEditToTable').show();
                $('.ButtonExportXLS').show();
                $('.ButtonExitEditMotion').show();
                $('.ButtonDateMotion').show();

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
                $(".shipped_motion").prop("disabled", true);
                $(".remains_motion").prop("disabled", true);
                $(".numberOverhead_motion").prop("disabled", true);
                $(".dateOverhead_motion").prop("disabled", true);
                $(".note_motion").prop("disabled", true);

/*формирование запроса к базам*/
                var id_motion_class = document.getElementsByClassName("id_motion");
                var id_motion = id_motion_class[0].dataset.id_motion;
                var gid_motion = id_motion_class[0].dataset.gid_motion;
                console.log(id_motion);
                console.log(gid_motion);
//GUID для строки внутри отчета "информаиця о движении МТР"
                var id_bond_guid_motion_date = document.getElementsByClassName("code_mtr_class");
                var guid_bond_guid_motion_date = id_bond_guid_motion_date[0].dataset.bond_guid_motion_date;
                console.log(guid_bond_guid_motion_date);

//                var author_motion = document.getElementById("author_order").value;
//                console.log(author_motion);
                var m = 0;
/*формирование запроса к базе all_motion*/
                $.ajax({
                    url : "<?=base_url();?>Main/saveEditAllMotion",
                    type: "POST",
                    data: {
                        id_motion : id_motion
                    },
                    success: function (data_id_all_motion) {
//                        console.log(data_id_all_motion);

                        /*формирование запроса к базе motion*/
                        var n = document.getElementsByClassName("id_order_mtr_class");
                        var n_sumMTR = document.getElementsByClassName("sum_mtr");
                        var n_date_edit_motion = document.getElementsByClassName("date_edit_motion_class"); //Собираем инфу по классу date_edit_motion_class
                        var number_codeMTR = document.getElementsByClassName('sum_mtr').length;
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
                            var number_id_order_mtr = n[m].dataset.id_order_mtr;
                            var number_id_motion = n[m].dataset.id_motion;
//                            var date_edit_motion = n_date_edit_motion[m].dataset.date_edit_motion;
                            var sumMTR = n_sumMTR[m].dataset.sum_mtrr;
//                            console.log(date_edit_motion);
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
                                    guid_bond_guid_motion_date: guid_bond_guid_motion_date,
//                                    date_edit_motion: date_edit_motion
                                },
                                success: function (data) {
                                    console.log(data);
                                    window.location = "<?=base_url();?>Main/edit_motion?id_motion=" + id_motion;
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

//Режим редактирования распоряжения
    function editMotion(){
        /*Show and Hide кнопок управления*/
        $('.ButtonEditToTable').hide();
        $('.ButtonSaveEditToTable').show();
        $('.ButtonCancelEditMotion').show();
        $(".buttonCopy").prop("disabled", false);
        $('.ButtonExportXLS').hide();
        $('.ButtonExitEditMotion').hide();
        $('.ButtonDateMotion').hide();

        /*Show and Hide input table*/
        $(".length_motion").prop("disabled", false);
        $(".width_motion").prop("disabled", false);
        $(".height_motion").prop("disabled", false);
        $(".weight_motion").prop("disabled", false);
        $(".total_motion").prop("disabled", false);
        $(".cargo_motion").prop("disabled", false);
        $(".dateRequest_motion").prop("disabled", false);
        $(".dateShipments_motion").prop("disabled", false);
        $(".infoShipments_motion").prop("disabled", false);
        $(".shipped_motion").prop("disabled", false);
        $(".remains_motion").prop("disabled", false);
        $(".numberDateOverhead_motion").prop("disabled", false);
        $(".numberOverhead_motion").prop("disabled", false);
        $(".dateOverhead_motion").prop("disabled", false);
        $(".note_motion").prop("disabled", false);
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

//Отмена последних изменений выход из режима редактирования информации о движении МТР
    function ExitEditMotion(){
        window.location ="<?=base_url();?>Main/show_motion";
    }

//Переход на выбранную дату редактирования информации о движении МТР
    function DateEditMotion(){
        var id_motion = document.getElementsByClassName("id_motion");
        var id_motion = id_motion[0].dataset.id_motion;
        var guid_edit_motion = document.getElementById('guid_date_edit_motion').value;
        window.location = "<?=base_url();?>Main/date_edit_motion?id_motion=" + id_motion + "&guid_edit_motion=" + guid_edit_motion;
    }

//Переход в режим исправления ошибок
    function ErrorEditMotion(){
        var id_motion = document.getElementsByClassName("id_motion");
        var id_motion = id_motion[0].dataset.id_motion;
        window.location = "<?=base_url();?>Main/error_edit_motion?id_motion=" + id_motion;
    }

//Переход на просмотр всей информации о движении МТР
    function DateAllEditMotion(){
        var id_motion = document.getElementsByClassName("id_motion");
        var id_motion = id_motion[0].dataset.id_motion;
        window.location = "<?=base_url();?>Main/date_all_edit_motion?id_motion=" + id_motion + "&date_all=all";
    }

//Завершающий этап по формированию движения по МТР
    function endGameMotion(){
        var id_motion_n = document.getElementsByClassName("id_motion");
        var id_motion = id_motion_n[0].dataset.id_motion;
        var n = document.getElementsByClassName("id_number_orders");
        var number_codeMTR = document.getElementsByClassName('id_number_orders').length;
        console.log(number_codeMTR);
        var m = 0;
        while (m < number_codeMTR) {
            var number_id_order_mtr = n[m].dataset.id_order;
            console.log(number_id_order_mtr);
            $.ajax({
                url: "<?=base_url();?>Main/endGameMotion",
                type: "POST",
                data: {
                    id_motion : id_motion,
                    number_id_order_mtr : number_id_order_mtr
                },
                success: function(data) {
                    console.log(data);
                    window.location = "<?=base_url();?>Main/edit_motion?id_motion=" + id_motion;
                }
            });
            m++;
        }
    }

//Функция сбора информации со строки
    function infoString(id){
        var row_data = [];
        $(id).closest('tr').find('td').each(function () {
            row_data.push($(this).html());
        });
        console.log(row_data);
        return row_data;
    }

//Функция дублирования строки
    function addString(id){
        var table = $('#myMotion2').DataTable();
        var row_data = [];
        $(id).closest('tr').find('td').each(function () {
            row_data.push($(this).html());
        });
        // you'll need a reference to your DataTable here
        console.log(row_data);
        table.row.add(row_data).draw(false);
    }

    function addString2(id){
        var table = $('#myMotion').DataTable();
        var table2 = $('#myMotion2').DataTable();
        var row_data = [];
        $(id).closest('tr').find('td').each(function () {
            row_data.push($(this).html());
        });
        // you'll need a reference to your DataTable here
        console.log(row_data);
        table.row.add(row_data).draw(false);
        table2.row.add(row_data).draw(false);
    }

    function add_row_mtr(id){
        var name_mtr = document.getElementsByClassName('id_order_mtr_class');
        console.log(name_mtr);

    }

</script>