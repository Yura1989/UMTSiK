<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Распоряжения</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Отчеты</span></li>
                <li><span>Распоряжения</span></li>
            </ol>
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>
    <?php
    $_username = $this->session->userdata('username');
    $_actions = $this->session->userdata('actions');
    if (isset ($_username) && ((($_actions['edit_order']) == 1))) { ?>
        <div class="row">
            <div class="col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        <h2 class="panel-title">Для добавления распоряжения нажмите кнопку "Добавить распоряжение"</h2>
                    </header>
                    <div class="panel-body">
                        <button type="button" onclick="add_New_Order();" name="order" class="mb-xs mt-xs mr-xs btn btn-success">Добавить распоряжение</button>
                    </div>
                </section>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        <h2 class="panel-title">Поиск распоряжений</h2>
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <form method="POST" action="" >
                                    <div class="form-group" id="rangeDate">
                                        <label class="control-label">Дата создания</label>
                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon">от</span>
                                            <input type="text" autocomplete="off" value="<?php if(isset($_POST['start_date'])) echo($_POST['start_date']) ?>" class="form-control" name="start_date" />
                                            <span class="input-group-addon">до</span>
                                            <input type="text" autocomplete="off" value="<?php if(isset($_POST['end_date'])) echo($_POST['end_date']) ?>" class="form-control" name="end_date" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">№ распоряжения </label>
                                        <input data-toggle="tooltip" name="number_order" id="number_order_id" value="<?php if(isset($_POST['number_order'])) echo($_POST['number_order']) ?>"
                                               data-original-title="45 - Код ресурсного отдела, который инициировал распоряжение. 12 - Порядковый номер распоряжения проставляется, согласно реестру распоряжений, который ведётся в ресурсном отделе" type="text" class="form-control" >
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Наименование МТР</label>
                                        <input name="name_MTR" id="name_MTR_id" value="<?php if(isset($_POST['name_MTR'])) echo($_POST['name_MTR']) ?>" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="search_name_order" class="btn btn-primary">Поиск распоряжений</button>
                                    </div>
                                </form>
                             </div>
                        </div>
                    </div>
                </section>
        </div>
    </div>

    <?php if(isset($orders[0])) { ?>
    <section class="panel ">
        <header class="panel-heading ">
            <p class="panel-subtitle">Распоряжения</p>
        </header>
        <div class="panel-body">
            <table id="showOrders" class="table table-hover">
                <thead>
                <tr>
                    <th style="width: 50px;">№</th>
                    <th>Распоряжения</th>
                    <th>Дата создания</th>
                    <th>Исполнитель</th>
                    <th>Статус</th>
                    <th>Операция</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($orders as $item): ?>
                    <?php  $_department_value = $this->session->userdata('department');
                    if (isset ($item['create_department'])) {
                        $_department = (integer)$_department_value;
                        $item_department= (integer)$item['create_department'];
                        if($_department == $item_department || $_department == 'Admin' || (($_actions['show_all_orders']) == 1) ) { ?>
                        <tr>
                            <td style="width: 50px;"></td>
                            <td>Распоряжение <?php echo($item['number_order']); ?>
                                от <?php echo(date('d-m-Y', strtotime($item['date_order']))); ?> </td>
                            <td><?php echo(date('d-m-Y', strtotime($item['date_order']))); ?></td>
                            <td><?php echo($item['author_order']); ?></td>
                            <td>
                                <?php
                                if ($item['flag'] == 0) { ?>
                                    <span class="label label-info"> <?php echo('Создание'); ?></span>
                                <?php } elseif ($item['flag'] == 10) { ?>
                                    <span class="label label-warning"> <?php echo('На согласовании'); ?></span>
                                <?php } elseif ($item['flag'] == 20) { ?>
                                    <span class="label label-success"> <?php echo('Согласован'); ?></span>
                                <?php } elseif ($item['flag'] == 30) { ?>
                                    <span class="label label-warning"> <?php echo('В работе'); ?></span>
                                <?php } elseif ($item['flag'] == 40) { ?>
                                    <span class="label label-success"> <?php echo('Отправлен'); ?></span>
                                <?php } elseif ($item['flag'] == 50) { ?>
                                    <span class="label label-warning"> <?php echo('На участке'); ?></span>
                                <?php } elseif ($item['flag'] == 60) { ?>
                                    <span class="label label-success"> <?php echo('Завершено'); ?></span>
                                <?php } else { ?>
                                    <span class="label label-danger"> <?php echo('Ошибка'); ?></span>
                                <?php }
                                ?>
                            </td>
                            <td>
                                <?php if ($item['flag'] == 30) { ?>
                                    <button type="button" data-id-orders="<?php echo($item['id_all_orders']); ?>"
                                            onclick="editOrder(this);" class="mb-xs mt-xs mr-xs btn btn-sm btn-info">
                                        Просмотреть
                                    </button>
                                    <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="btn btn-success btn-sm btn-default" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                    <?php
                                    if (isset ($_username) && (($_actions['return_edit_orders']) == 1) ) { ?>
                                        <button id="return_edit_order" onclick="return_edit_order(this);" type="button"
                                                data-id-orders="<?php echo($item['id_all_orders']); ?>"
                                                class="Button_Return_edit_order btn btn-outline-warning">Вернуть на доработку <i class="fa fa-pencil"></i>
                                        </button>
                                    <?php } ?>
                                <?php } elseif ($item['flag'] == 20) { ?>
                                    <button type="button" data-id-orders="<?php echo($item['id_all_orders']); ?>"
                                            onclick="editOrder(this);" class="mb-xs mt-xs mr-xs btn btn-sm btn-info">
                                        Просмотреть
                                    </button>
                                    <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="btn btn-success btn-sm btn-default" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                    <?php
                                    if (isset ($_username) && (($_actions['return_edit_orders']) == 1) ) { ?>
                                        <button id="return_edit_order" onclick="return_edit_order(this);" type="button"
                                                data-id-orders="<?php echo($item['id_all_orders']); ?>"
                                                class="Button_Return_edit_order btn btn-outline-warning">Вернуть на доработку <i class="fa fa-pencil"></i>
                                        </button>
                                    <?php } ?>
                                <?php } elseif ($item['flag'] == 10) { ?>
                                    <button type="button" data-id-orders="<?php echo($item['id_all_orders']); ?>"
                                            onclick="editOrder(this);" class="mb-xs mt-xs mr-xs btn btn-sm btn-info">
                                        Просмотреть
                                    </button>
                                    <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="btn btn-success btn-sm btn-default" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                    <?php
                                    if (( ($_department == $item['create_department']) && ((($_actions['delete_order']) == 1))) || (($_actions['admin']) == 1) ) { ?>
                                        <button id="return_edit_order" onclick="return_edit_order(this);" type="button"
                                                data-id-orders="<?php echo($item['id_all_orders']); ?>"
                                                class="Button_Return_edit_order btn btn-outline-warning">Вернуть на доработку <i class="fa fa-pencil"></i>
                                        </button>
                                        <button type="button" id="button"
                                                data-id-orders="<?php echo($item['id_all_orders']); ?>"
                                                name="delete_order" onclick="deleteOrder(this);"
                                                class="mb-xs mt-xs mr-xs btn btn-sm btn-danger">Удалить
                                        </button>
                                    <?php } ?>
                                <?php } elseif ($item['flag'] == 0) { ?>
                                    <button type="button" data-id-orders="<?php echo($item['id_all_orders']); ?>"
                                            onclick="editOrder(this);" class="mb-xs mt-xs mr-xs btn btn-sm btn-info">
                                        Просмотреть
                                    </button>
                                    <button type="button" onclick="ExportXls(this);" data-id_all_order="<?php echo($item['id_all_orders']); ?>" class="btn btn-success btn-sm btn-default" title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                    <?php
                                    if ( ( ($_department == $item['create_department']) && ((($_actions['edit_order']) == 1) || (($_actions['delete_order']) == 1))) || (($_actions['admin']) == 1) ) { ?>
                                        <button type="button" data-id-orders="<?php echo($item['id_all_orders']); ?>"
                                                name="delete_order" onclick="deleteOrder(this);"
                                                class="mb-xs mt-xs mr-xs btn btn-sm btn-danger">Удалить
                                        </button>
                                    <?php }
                                } else { ?>
                                    <button type="button" data-id-orders="<?php echo($item['id_all_orders']); ?>"
                                            onclick="editOrder(this);" class="mb-xs mt-xs mr-xs btn btn-sm btn-info">
                                        Просмотреть
                                    </button>
                                <?php } ?>
                            </td>
                        </tr>
                <?php } } ?>
                <?php endforeach; ?>
                </tbody>
            </table>
            </form>
        </div>
    </section>
    <?php  }
    if (isset($flag)) {
        echo("По вашему запросу ничего не найдено");
    } ?>

<script src="<?=base_url();?>assets/order/jquery-3.3.1.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url();?>assets/vendor/datepicker/locales/bootstrap-datepicker.ru.min.js" charset="UTF-8"></script>
<script>

    $(document).ready(function() {
        /*Таблица*/
        var t = $('#showOrders').DataTable({
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
            } ]
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
            autoclose: true
        });
    });

/*Функция перехода на старницу добавления нового распоряжения в новом интерфейсе*/
    function add_New_Order(){
        if(confirm ("Вы точно хотите создать новое распоряжение?")) {
            window.location.replace("<?=base_url();?>Main/create_edit_order");
        }
    }

/*Функция удаления распоряжения по ID*/
    function deleteOrder(id){
        if (confirm("Вы точно хотите удалить данное распоряжение?")) {
            var id_order = id.getAttribute('data-id-orders');
            console.log(id_order);
            $.ajax({
                type: "POST",
                url: "<?=base_url();?>Main/deleteOrder",
                data: {id : id_order},
                success: function (data){
                    console.log(data);
                    var id_section = id.parentNode.parentNode;
                    console.log(id_section);
                    id_section.parentNode.removeChild(id_section);
                    $('#button').click( function () {
                        table.row('.selected').remove().draw( false );
                    } );
                }
            });
        }
    }

    function editOrder(id){
        if (confirm("Вы точно хотите просмотреть(изменить) данное распоряжение")) {
            var id_order = id.getAttribute('data-id-orders');
            console.log(id_order);
            window.location ="<?=base_url();?>Main/create_edit_order?id_order=" + id_order;
        }
    }

//Возврат распоряжения на доработку
    function return_edit_order(id){
        var id_order = id.getAttribute('data-id-orders');
            $.ajax({
                url: "<?=base_url();?>Main/return_edit_order",
                type: "POST",
                data: {
                    id_order : id_order
                },
                success: function(data) {
                    console.log(data);
                    window.location = "<?=base_url();?>Main/range_date_orders";
                }
            });
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