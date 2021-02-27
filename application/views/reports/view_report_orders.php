<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Отчеты</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Отчеты</span></li>
            </ol>
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

Данный раздел находится в разработке
    
</section>

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
            format: "yyyy-mm-dd",
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