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
            <h2 class="panel-title">Заключительный этап формирования информации о движении МТР на базе(участке)</h2>
            <p>Выберите необхожимую информацию воспользовавшись поиском</p>
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
                            <li class="">
                                <a href="#formation" onclick="CreateMotions();" data-toggle="tab" aria-expanded="true">Формирование</a>
                            </li>
                            <?php } ?>
                            <?php if (isset ($_username) && (($_actions['filial_edit_motion']) == 1) ) { ?>
                                <li class="active">
                                    <a href="#filial" data-toggle="tab" aria-expanded="true">Для участков</a>
                                </li>
                            <?php } ?>
                            <?php if (isset ($_username) && (($_actions['show_motion']) == 1) ) { ?>
                            <li class="">
                                <a href="#show" onclick="show_motion();" data-toggle="tab" aria-expanded="false">Просмотр / Изменение</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if(isset($all_motion[0])) { ?>
        <section id="create_motion" class="panel">
            <div class="panel-body">
                <form method="POST" action="<?=base_url();?>Main/motion">
                    <table id="createMotion" class="table table-hover">
                        <thead>
                        <tr>
                            <th style="width: 50px;">№</th>
                            <th>Информация о движении МТР</th>
                            <th>Дата создания</th>
                            <th>Исполнитель <br/> по движению МТР</th>
                            <th>Исполнитель <br/> по распоряжению</th>
                            <th>Участок(ки)</th>
                            <th>Статус</th>
                            <th>Операции</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($all_motion as $item): ?>
                            <tr>
                                <td style="width: 50px;"></td>
                                <td> Информация по МТР <?php echo($item['number_motion']); ?> от <?php echo(date('d-m-Y', strtotime($item['date_create_motion']))); ?> </br> сформированно из:
                                    <ul>
                                        <?php foreach ($new_mas as $mas => $massiv):
                                            foreach ($massiv as $inner_key => $value):
                                                if ($item['number_motion'] == $value['bond_guid_motion']) {
                                                    ?>

                                                    <li>Распоряжение <?php echo($value['number_order']);?> от <?php echo(date('d-m-Y', strtotime($value['date_order']))); ?></li>
                                                <?php }
                                            endforeach;
                                        endforeach; ?>
                                    </ul>
                                </td>
                                <td><?php echo(date('d-m-Y', strtotime($item['date_create_motion']))); ?></td>
                                <td><?php echo($item['sername']." ".$item['name']." ".$item['patronymic'] ); ?></td>
                                <td>
                                    <ul>
                                        <?php foreach ($new_mas as $mas => $massiv):
                                            foreach ($massiv as $inner_key => $value):
                                                if ($item['number_motion'] == $value['bond_guid_motion']) {
                                                    ?>
                                                    <li><?php echo($value['sername']." ".$value['name']." ".$value['patronymic'] ); ?></li>
                                                <?php }
                                            endforeach;
                                        endforeach; ?>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <?php foreach ($new_mas as $mas => $massiv):
                                            foreach ($massiv as $inner_key => $value):
                                                if ($item['number_motion'] == $value['bond_guid_motion']) {
                                                    ?>
                                                    <li><?php echo($value['address_order']);?></li>
                                                <?php }
                                            endforeach;
                                        endforeach; ?>
                                    </ul>
                                </td>
                                <td>
                                    <?php if ((($item['flag_motion']) == 30)) { ?>
                                    <span class="label label-success"> Завершено </span>
                                    <?php } elseif ((($item['flag_motion']) == 20)) { ?>
                                        <span class="label label-warning"> На участке </span>
                                    <?php } elseif ((($item['flag_motion']) == 10)) { ?>
                                        <span class="label label-success"> Отправлен </span>
                                    <?php } elseif ((($item['flag_motion']) == 0)) { ?>
                                        <span class="label label-warning"> В работе </span>
                                    <?php } else {?>
                                        <span class="label label-danger"> Ошибка </span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ((($item['flag_motion']) == 30)) { ?>
                                        <button type="button" data-id-motion="<?php echo($item['id_all_motion']); ?>"
                                                onclick="filial_edit_motion(this);" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning">
                                            Изменить
                                        </button>
                                        <button type="button" onclick="ExportXls(this);" data-id_motion="<?php echo($item['id_all_motion']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success " title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        <button onclick="return_edit_motion(this);" type="button"
                                                data-id-motion="<?php echo($item['id_all_motion']); ?>"
                                                class="return_edit_motion btn btn-xs btn-outline-warning">Вернуть на доработку <i class="fa fa-pencil"></i>
                                        </button>
                                    <?php } else { ?>
                                        <button type="button" data-id-motion="<?php echo($item['id_all_motion']); ?>"
                                                onclick="filial_edit_motion(this);" class="mb-xs mt-xs mr-xs btn btn-xs btn-info">
                                            В работу
                                        </button>
                                        <button type="button" onclick="ExportXls(this);" data-id_motion="<?php echo($item['id_all_motion']); ?>" class="mb-xs mt-xs mr-xs btn btn-xs btn-success " title="Export xlsx" tabindex="-1" ><span class="fa fa-file-excel-o"></span></button>
                                        <button onclick="return_edit_motion(this);" type="button"
                                                data-id-motion="<?php echo($item['id_all_motion']); ?>"
                                                class="return_edit_motion btn btn-xs btn-outline-warning">Вернуть на доработку <i class="fa fa-pencil"></i>
                                        </button>
                                    <?php } ?>
                                </td>
                            </tr>
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
            } ]
        });

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

//Вывод даты
        $('#rangeDate .input-daterange').datepicker({
            format: "yyyy-mm-dd",
            language: "ru",
            autoclose: true,
            orientation: "bottom"
        });
    });

//Переход на страницу изменения или просмотра движения МТР
    function filial_edit_motion(id){
        if (confirm("Вы точно хотите взять в работу данную информацию")) {
            var id_motion = id.getAttribute('data-id-motion');
            console.log(id_motion);
            window.location ="<?=base_url();?>Main/filial_edit_motion?id_motion=" + id_motion;
        }
    }

//Просмотр заполненной информации о движении МТР
    function show_motion() {
        window.location="<?=base_url();?>Main/show_motion";
    }

//Просмотр заполненной информации о движении МТР
    function CreateMotions(){
        window.location="<?=base_url();?>Main/motion";
    }

//Экспорт в Excel
    function ExportXls(id){
        var id_motion = id.getAttribute('data-id_motion');
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

//Возврат информации о движении на доработку
        function return_edit_motion(id) {
            if (confirm("Вы точно хотите вернуть данную информация на корректировку?")) {
                var id_motion = id.getAttribute('data-id-motion');
                console.log(id_motion);
                $.ajax({
                    url: "<?=base_url();?>Main/return_edit_motion",
                    type: "POST",
                    data: {
                        id_motion: id_motion
                    },
                    success: function (data) {
                        console.log(data);
                        window.location = "<?=base_url();?>Main/show_edit_filial_motion";
                    }
                });
            }
        }
</script>
