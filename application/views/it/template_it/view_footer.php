</div>

<script src="<?=base_url();?>/vendor/bootadmin/js/jquery.min.js"></script>
<script src="<?=base_url();?>/vendor/bootadmin/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url();?>/vendor/bootadmin/js/datatables.min.js"></script>
<script src="<?=base_url();?>/vendor/bootadmin/js/moment.min.js"></script>
<script src="<?=base_url();?>/vendor/bootadmin/js/fullcalendar.min.js"></script>
<script src="<?=base_url();?>/vendor/bootadmin/js/bootadmin.min.js"></script>
<script>
    $body = $("body");
    $(document).on({
        ajaxStart: function() { $body.addClass("loading");    },
        ajaxStop: function() { $body.removeClass("loading"); }
    });

    $(document).ready(function() {
//Настройки таблицы
        var t = $('#myMatrix').DataTable({
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
            fixedHeader: true,
            "searching": true,
            "paging":    true,
            "ordering":  true,
            "info":      true,
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ]
        });
//Автоматические подсчет строк
        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

    });
</script>

</body>
</html>