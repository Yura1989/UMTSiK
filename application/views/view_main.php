<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Главная</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Главная</span></li>
            </ol>
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

<!-- start: page -->
    <section class="panel">
        <header class="panel-heading panel-heading-transparent">
            <h2 class="panel-title">Распоряжения</h2>
        </header>
        <div class="panel-body">
            <div class="">
                <table id="mainTable" class="mainTable table compact table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Распоряжение</th>
                        <th>Дата согласования </br> распоряжения</th>
                        <th>Исполнитель по распоряжению</th>
                        <th>Склад</th>
                        <th>Статус</th>
                        <th>Прогресс</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($orders as $item_order): ?>
                    <tr>
                        <td></td>
                        <td>Распоряжение № <?php echo($item_order['number_order']); ?> от <?php if(isset($item_order['date_order'])) { echo(date('d-m-Y', strtotime($item_order['date_order']))); } ?></td>
                        <td><?php if(isset($item_order['date_order'])) { echo(date('d-m-Y', strtotime($item_order['date_order']))); } ?></td>
                        <td><?php echo($item_order['sername']." ".$item_order['name']." ".$item_order['patronymic'] ); ?></td>
                        <td><?php echo($item_order['name_sklad']); ?></td>
                            <?php
                            if ($item_order['flag'] == 0) { ?>
                        <td> <span class="label label-info"> <?php echo('Создание'); ?></span></td>
                                <td>
                                    <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                                            10%
                                        </div>
                                    </div>
                                </td>
                            <?php } elseif ($item_order['flag'] == 10) { ?>
                        <td> <span class="label label-warning"> <?php echo('На согласовании'); ?></span></td>
                                <td>
                                    <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                            25%
                                        </div>
                                    </div>
                                </td>
                            <?php } elseif ($item_order['flag'] == 20) { ?>
                        <td> <span class="label label-success"> <?php echo('Согласован'); ?></span></td>
                                <td>
                                    <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                            50%
                                        </div>
                                    </div>
                                </td>
                            <?php } elseif ($item_order['flag'] == 30) { ?>
                                <td> <span class="label label-warning"> <?php echo('В работе'); ?></span></td>
                                <td>
                                    <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                            50%
                                        </div>
                                    </div>
                                </td>
                            <?php } elseif ($item_order['flag'] == 40) { ?>
                                <td> <span class="label label-success"> <?php echo('Отправлен'); ?></span></td>
                                <td>
                                    <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
                                            70%
                                        </div>
                                    </div>
                                </td>
                            <?php } elseif ($item_order['flag'] == 50) { ?>
                                <td> <span class="label label-warning"> <?php echo('На участке'); ?></span></td>
                                <td>
                                    <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">
                                            90%
                                        </div>
                                    </div>
                                </td>
                            <?php } elseif ($item_order['flag'] == 60) { ?>
                                <td> <span class="label label-success"> <?php echo('Завершен'); ?></span></td>
                                <td>
                                    <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                            100%
                                        </div>
                                    </div>
                                </td>
                            <?php } else { ?>
                                <td> <span class="label label-danger"> <?php echo('Ошибка'); ?></span></td>
                                <td>
                                    <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                            50%
                                        </div>
                                    </div>
                                </td>
                            <?php }?>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section class="panel">
        <header class="panel-heading panel-heading-transparent">
            <h2 class="panel-title">Информация о движении МТР</h2>
        </header>
        <div class="panel-body">
            <form method="POST" action="">
                <table id="mainTable2" class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Информация о движении МТР</th>
                        <th>Дата создания </br> информации о движении МТР</th>
                        <th>Исполнитель по движению МТР</th>
                        <th>Участок(ки)</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($all_motion as $item): ?>
                        <tr>
                            <td></td>
                            <td>Информация по МТР <?php echo($item['number_motion']); ?> от <?php echo($item['date_create_motion']); ?> </br> сформированно из:
                                <ul>
                                    <?php foreach ($new_mas as $mas => $massiv):
                                        foreach ($massiv as $inner_key => $value):
                                            if ($item['number_motion'] == $value['bond_guid_motion']) {
                                                ?>

                                                <li>Распоряжение <?php echo($value['number_order']);?> от <?php if(isset($value['date_order'])) { echo(date('d-m-Y', strtotime($value['date_order']))); } ?></li>
                                            <?php }
                                        endforeach;
                                    endforeach; ?>
                                </ul>
                            </td>
                            <td><?php if(isset($item['date_create_motion'])) { echo(date('d-m-Y', strtotime($item['date_create_motion']))); } ?></td>
                            <td><?php echo($item['author_motion']); ?></td>
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
                                <span class="label label-success"> Завершен </span>
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
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        </div>
    </section>
</section>
    <!-- end: page -->
<script src="<?=base_url();?>assets/order/jquery-3.3.1.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        /*Таблица*/
        var t = $('#mainTable').DataTable({
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

        var t2 = $('#mainTable2').DataTable({
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

        t2.on( 'order.dt search.dt', function () {
            t2.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

    })
</script>
