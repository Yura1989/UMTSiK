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
            <h2 class="panel-title">Инструкция по работе с распоряжением</h2>
        </header>
        <div class="panel-body">
            <div class=""><a href="<?=base_url();?>assets/manual/Инструкция по работе с распоряжением.docx" download=""> <button class="ButtonExportXLS btn btn-sm btn-info"> <i class="fa fa-file-excel"></i> Скачать</button> </a></div>
        </div>
    </section>
    <section class="panel">
        <header class="panel-heading panel-heading-transparent">
            <h2 class="panel-title">Инструкция по формированию информации о движении МТР</h2>
        </header>
        <div class="panel-body">
            <div class=""><a href="<?=base_url();?>assets/manual/Инструкция по формированию информации о движении МТР.docx" download=""> <button class="ButtonExportXLS btn btn-sm btn-info"> <i class="fa fa-file-excel"></i> Скачать</button> </a></div>
        </div>
    </section>
    <section class="panel">
        <header class="panel-heading panel-heading-transparent">
            <h2 class="panel-title">Инструкция по формированию информации о движении МТР на участке</h2>
        </header>
        <div class="panel-body">
            <div class=""><a href="<?=base_url();?>assets/manual/Инструкция по формированию информации о движении МТР на участке.docx" download=""> <button class="ButtonExportXLS btn btn-sm btn-info"> <i class="fa fa-file-excel"></i> Скачать</button> </a></div>
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
