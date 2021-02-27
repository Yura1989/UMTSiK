<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Пользователи</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?=base_url();?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Параметры</span></li>
                <li><span>Пользователи</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Пользователи</h2>
            </header>
            <div class="panel-body">
                <div>
                    <table id="mainTable" class="table table-hover">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Логин</th>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <th>Email</th>
                            <th style="width: 150px">Операции</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $item): ?>
                        <tr>
                            <td></td>
                            <td><?php if(isset($item['username'])) echo($item['username']);?></td>
                            <td><?php if(isset($item['sername'])) echo($item['sername']);?></td>
                            <td><?php if(isset($item['name'])) echo($item['name']);?></td>
                            <td><?php if(isset($item['patronymic'])) echo($item['patronymic']);?></td>
                            <td><?php if(isset($item['email'])) echo($item['email']);?></td>
                            <td class="actions">
                                <?php
                                $query = sprintf("
                                 <a data-toggle=\"tooltip\" title=\"\" href='editUser?user_id=%d' data-original-title=\"Редактировать пользователя\">Редактировать</a>", $item['id_user']);
                                echo ($query);
                                ?>
                                <a style="color: #d91918;" data-toggle="tooltip" id="<?php if(isset($item['id_user'])) echo($item['id_user']); ?>" data-id_user="<?php if(isset($item['id_user'])) echo($item['id_user']); ?>" onclick="deleteUser(this);" title="" href="#" data-original-title="Удаление пользователя насовсем">Удалить</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <form action="<?=base_url();?>main/createUser">
                        <button type="submit" class="mb-xs mt-xs mr-xs btn btn-success">Добавить пользователя</button>
                    </form>
                </div>
            </div>
        </section>

</section>

<script src="<?=base_url();?>assets/vendor/jquery-3.3.1.min.js"></script>
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
//                "searchable": false,
//                "orderable": false,/
                "targets": 0
            } ],
            "order": [[ 1, 'asc' ]]
        });

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });

/*Функция удаления пользователя*/
    function deleteUser(item)
    {
        if (confirm("Вы уверены что хотите удалить пользователя?")) {
            var user_id = ($(item).attr('id'));
            $.ajax({
                type: "POST",
                data: {id: user_id},
                url: '<?=base_url();?>Main/deleteUser',
                success: function (data) {
                    console.log(data);
                    window.location.replace("<?=base_url();?>Main/showUsers");
                }
            });
            console.log(user_id);
        }
    }
</script>