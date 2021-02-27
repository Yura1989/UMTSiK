<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Информация о движении МТР на базе</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Отчеты</span></li>
                <li><span>Информация о движении МТР</span></li>
            </ol>
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Формирование информации о движении МТР на базе</h2>
            <p>Выберите распоряжения по которым необхожимо сформировать информацию</p>
        </header>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tabs tabs-primary">
                        <ul class="nav nav-tabs">
                            <?php
                            $_username = $this->session->userdata('username');
                            $_actions = $this->session->userdata('actions');
                            if (isset ($_username) && (($_actions['edit_motion']) == 1) ) { ?>
                            <li class="active">
                                <a href="#formation" data-toggle="tab" aria-expanded="true">Формирование</a>
                            </li>
                            <?php } ?>
                            <?php if (isset ($_username) && (($_actions['filial_edit_motion']) == 1) ) { ?>
                                <li class="">
                                    <a href="#filial" onclick="filial_edit_motion();" data-toggle="tab" aria-expanded="true">Для участков</a>
                                </li>
                            <?php } ?>
                            <?php if (isset ($_username) && (($_actions['show_motion']) == 1) ) { ?>
                            <li class="">
                                <a href="#show" onclick="show_motion();" data-toggle="tab" aria-expanded="false">Просмотр / Изменение</a>
                            </li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">
                             <div id="formation" class="tab-pane active">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <form method="POST" action="#">
                                            <div class="form-group" id="rangeDate">
                                                <label class="control-label">Дата создания</label>
                                                <div class="input-daterange input-group" id="datepicker">
                                                    <span class="input-group-addon">от</span>
                                                    <input type="text" autocomplete="off"
                                                           value="<?php if (isset($_POST['start_date'])) echo($_POST['start_date']) ?>"
                                                           class="form-control" name="start_date"/>
                                                    <span class="input-group-addon">до</span>
                                                    <input type="text" autocomplete="off"
                                                           value="<?php if (isset($_POST['end_date'])) echo($_POST['end_date']) ?>"
                                                           class="form-control" name="end_date"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">№ распоряжения </label>
                                                <input data-toggle="tooltip" name="number_order" id="number_order_id"
                                                       value="<?php if (isset($_POST['number_order'])) echo($_POST['number_order']) ?>"
                                                       data-original-title="45 - Код ресурсного отдела, который инициировал распоряжение. 12 - Порядковый номер распоряжения проставляется, согласно реестру распоряжений, который ведётся в ресурсном отделе"
                                                       type="text" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Наименование МТР</label>
                                                <input data-toggle="tooltip" name="nameMTR" id="nameMTR"
                                                       value="<?php if (isset($_POST['nameMTR'])) echo($_POST['nameMTR']) ?>"
                                                       type="text" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Склад</label>
                                                <select name="name_sklad">
                                                    <?php foreach($name_sklad as $item_sklad): ?>
                                                        <?php $select_sklad=($item_sklad['name_sklad'] == $_POST['name_sklad'])?"selected":""; ?>
                                                    <option value="<?php echo($item_sklad['name_sklad']); ?>"  <?php echo($select_sklad); ?>><?php echo($item_sklad['name_sklad']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" name="search_name_order" class="btn btn-primary">Поиск Распоряжений</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if(isset($orders[0])) { ?>
        <section id="create_motion" class="panel">
            <div class="panel-body">
                <form method="POST" action="<?=base_url();?>Main/motion">
                    <div class="">
                        <table id="createMotion" class="table table-hover">
                            <thead>
                            <tr>
                                <th style="width: 50px;">№</th>
                                <th>Распоряжения</th>
                                <th>Дата создания</th>
                                <th>Исполнитель</th>
                                <th>Участок</th>
                                <th>Склад</th>
                                <th>Статус</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($orders as $item): ?>
                                <?php if (($item['flag']) == '20') { ?>
                                    <tr>
                                        <td style="width: 50px;"></td>
                                            <td>
                                                <?php
                                                    $_n_sklad = $this->session->userdata('n_sklad');
                                                    $_actions = $this->session->userdata('actions');
                                                    if( ($item['name_sklad'] == $_n_sklad) || ($_n_sklad == NULL) ) {
                                                ?>
                                                <div class="checkbox-custom checkbox-primary">
                                                        <input type="checkbox" name="id_all_orders_check[]" id="<?php echo($item['id_all_orders']); ?>" value="<?php echo($item['id_all_orders']); ?>" >
                                                        <label for="<?php echo($item['id_all_orders']); ?>">Распоряжение <?php echo($item['number_order']); ?> от <?php echo(date('d-m-Y', strtotime($item['date_order']))); ?> </label>
                                                </div>
                                                <?php } else { ?>
                                                    Распоряжение <?php echo($item['number_order']); ?> от <?php echo(date('d-m-Y', strtotime($item['date_order']))); ?>
                                                <?php } ?>
                                            </td>
                                        <td><?php echo(date('d-m-Y', strtotime($item['date_order']))); ?></td>
                                        <td><?php echo($item['sername']." ".$item['name']." ".$item['patronymic'] ); ?></td>
                                        <td><?php echo($item['address_order']); ?></td>
                                        <td><?php echo($item['name_sklad']); ?></td>
                                        <td><span class="label label-success"> <?php echo('Согласован'); ?></span>
                                            <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php foreach ($orders as $item): ?>
                        <?php if ((($item['flag']) == '20')) { ?>
                            <button type="submit" name="checked_selected_orders" value="TRUE"
                                    class="mb-xs mt-xs mr-xs btn btn-success">Сформировать отчет
                            </button>
                            <?php break; ?>
                        <?php } ?>
                    <?php endforeach; ?>
                </form>
            </div>
        </section>
    <?php  }
    if (isset($flag)) {
        echo("По вашему запросу ничего не найдено");
    } ?>
</section>

<script src="<?=base_url();?>assets/order/jquery-3.3.1.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url();?>assets/vendor/datepicker/locales/bootstrap-datepicker.ru.min.js" charset="UTF-8"></script>

<script>
    $(document).ready(function() {
/*Таблица*/
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
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 2, '' ]]
        });

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

//Вывод даты
        $('#rangeDate .input-daterange').datepicker({
            format: "dd-mm-yyyy",
            language: "ru",
            autoclose: true,
            orientation: "bottom"
        });
    });

//Дичь какая то, надо разобраться или удалить
    function checked_selected_orders() {
        if (confirm("Вы уверены что хотите сформировать информацию о движении МТР на базе?")) {
            var cBox = [];
            $("input[type=checkbox]:checked").each(function () {
                var n = cBox.push($(this).attr("value"));
            });
    
            console.log('сбор чекбоксов');
            console.log(cBox);
            
            $.ajax({
                type: "POST",
                url: "<?=base_url();?>/Main/select_motion",
                data: {cBox: cBox},
                success: function(data) {
                    console.log(data);
                    $("#content").html(data);
                    //window.location="<?=base_url();?>Main/motion";
                }
            });
        }
    }
    
//Просмотр заполненной информации о движении МТР
    function show_motion() {
        window.location="<?=base_url();?>Main/show_motion";
    }

//Переход на страницу поиска информации о движения МТР для участков
    function filial_edit_motion(){
        window.location.replace("<?=base_url();?>Main/show_edit_filial_motion");
    }

//Экспорт в Excel
    function ExportXls(id){
        var id_order = id.getAttribute('data-id_all_order');
        console.log("Export XSL");
        console.log(id_order);

        $.ajax({
            url: "<?=base_url();?>Main/export_Orders",
            type: "POST",
            data: {id_order : id_order},
            success: function(data){
                window.location ="<?=base_url();?>Main/export_Orders?JSid_order="+id_order;
            }
        })
    }

</script>
