<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Филиалы</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?=base_url();?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Справочники</span></li>
                <li><span>Филиалы</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>
    <div class="col-md-12">
        <section class="panel">
<!--                форма для создания-->
            <?php if(isset($_POST['button_add_lpu'])) { ?>
                <form method="POST" action="<?= base_url(); ?>Main/lpu" class="form-horizontal" novalidate="novalidate">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Форма по созданию филиала</h2>
                            <p class="panel-subtitle">
                                Заполните обязательные поля ниже
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Наименование Участка<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
                                        <!--Форма для добавления-->
                                        <select name="locations" class="form-control" required>
                                            <option value=""></option>
                                            <?php foreach($locations as $item_locations): ?>
                                                <option value="<?php echo($item_locations['id_filial']); ?>"><?php echo($item_locations['name_filial']); ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Наименование Филиала<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                        Форма для добавления-->
                                        <input type="text" name="name_lpu" class="form-control valid" value="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button type="submit" name="button_create_lpu" class="btn btn-primary">Создать</button>
                                    <button type="button" onclick="resetButton();" class="btn btn-default">Отмена</button>
                                </div>
                            </div>
                        </footer>
                    </section>
                </form>

            <?php } elseif (isset($_GET['check'])) { ?>
                <form method="POST" action="#" class="form-horizontal" novalidate="novalidate">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Форма по редактированию филиала</h2>
                            <p class="panel-subtitle">
                                Отредактируйте название филиала и нажмите сохранить
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Наименование Участка<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
                                        <!--Форма для редактирования-->
                                        <select name="locations" class="form-control" required>
                                            <option value=""></option>
                                            <?php foreach($lpus as $item): ?>
                                                <?php foreach($locations as $item_locations):
                                                    $sel=($item['id_bond_filials']==$item_locations['id_filial'])?"selected":""; ?>
                                                    <option value="<?php echo($item_locations['id_filial']);?>" <?php echo($sel); ?> ><?php echo($item_locations['name_filial']); ?></option>
                                                <?php endforeach ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Наименование Филиала<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                    Форма для редактирования-->
                                        <?php foreach($lpus as $item): ?>
                                                <input type="text" name="name_edit_lpu" value="<?php echo($item['name_lpu']); ?>" class="form-control valid" required>
                                        <?php endforeach; ?>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                <?php foreach($lpus as $item): ?>
                                    <button type="button" onclick="save_edit_lpu(this);" data-name-lpu="<?php echo($item['name_lpu']); ?>" data-id-lpu="<?php echo($item['id_lpu']) ?>" name="button_save_edit_lpu" class="btn btn-primary">Сохранить</button>
                <?php endforeach; ?>
                                    <button type="button" onclick="resetButton();" class="btn btn-default">Отмена</button>
                                </div>
                            </div>
                        </footer>
                    </section>
                </form>

            <?php } else {?>
<!--                    форма для просмотра-->
                <div class="panel-body">
                    <div>
                        <table id="mainTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Название Участка</th>
                                <th>Название Филиала</th>
                                <th>Статус</th>
                                <th style="width: 150px">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($lpu as $item): ?>
                                <tr>
                                    <td></td>
                                    <td><?php if(isset($item['name_filial'])) echo($item['name_filial']);?></td>
                                    <td><?php if(isset($item['name_lpu'])) echo($item['name_lpu']);?></td>
                                    <?php if(($item['show_lpu']) == 1) {?>
                                        <td style="color: #d91918;">Отключено</td>
                                    <?php } else { ?>
                                        <td >Включено</td>
                                    <?php } ?>
                                    <td class="actions">
                                        <?php $query = sprintf(" <a data-toggle=\"tooltip\" href=\"lpu?id_lpu=%d&check=lpuEdit\" name=\"\" data-original-title=\"Редактировать филиала\" >Редактировать</a> ", $item['id_lpu']);
                                        echo($query); ?>
                                        <?php if($item['show_lpu'] == 1) { ?>
                                            <a data-toggle="tooltip" href="#" id="<?php if(isset($item['id_lpu'])) echo($item['id_lpu']); ?>" data-original-title="Включить данный филиал" onclick="OnLpu(this);" style="color: #369237;">Включить</a>
                                        <?php } else { ?>
                                            <a data-toggle="tooltip" href="#" id="<?php if(isset($item['id_lpu'])) echo($item['id_lpu']); ?>" data-original-title="Отключение данный филиал" onclick="OffLpu(this);" style="color: #d91918;">Отключить</a>
                                        <?php } ?>
                                        <a data-toggle="tooltip" href="#" id="<?php if(isset($item['id_lpu'])) echo($item['id_lpu']); ?>" data-original-title="Удаление филиала насовсем" onclick="deletelpu(this);" style="color: #d91918;">Удалить</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <form method="POST" action="<?=base_url();?>Main/lpu">
                            <button type="submit" name="button_add_lpu" class="mb-xs mt-xs mr-xs btn btn-success">Добавить филиал</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </section>
    </div>
</section>

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

//    Отмена операции
    function resetButton(){
        console.log("123");
        window.location.replace("<?=base_url();?>Main/lpu");
    }

//    Функция включения
    function OnLpu(item) {
        if (confirm("Вы уверены что хотите включить данный филиал?")) {
            var id_lpu = ($(item).attr('id'));
            var checkOn = "off";
            $.ajax({
                type: "POST",
                data: {id_lpu: id_lpu,
                    checkOn : checkOn},
                url: '<?=base_url();?>Main/lpu',
                success: function (data) {
                    console.log(data);
                    window.location.replace("<?=base_url();?>Main/lpu");
                }
            });
            console.log(id_lpu);
        }
    }

//    Функция отключения
    function OffLpu(item) {
        if (confirm("Вы уверены что хотите отключить данный филиал?")) {
            var id_lpu = ($(item).attr('id'));
            var checkOff = "off";
            $.ajax({
                type: "POST",
                data: {id_lpu: id_lpu,
                    checkOff : checkOff},
                url: '<?=base_url();?>Main/lpu',
                success: function (data) {
                    console.log(data);
                    window.location.replace("<?=base_url();?>Main/lpu");
                }
            });
            console.log(id_lpu);
        }
    }
    
//    Функция удаления
    function deletelpu(item) {
        if (confirm("Вы уверены что хотите удалить филиал?")) {
            var id_lpu = ($(item).attr('id'));
            var checkDel = "delete";
            $.ajax({
                type: "POST",
                data: {id_lpu: id_lpu,
                       checkDel : checkDel},
                url: '<?=base_url();?>Main/lpu',
                success: function (data) {
                    console.log(data);
                    window.location.replace("<?=base_url();?>Main/lpu");
                }
            });
            console.log(id_lpu);
        }
    }

//    Сохранение изменных данных
    function save_edit_lpu(item){
        var id_lpu = item.getAttribute('data-id-lpu');
        var name_lpu = document.getElementsByName('name_edit_lpu')[0].value;
        var location = document.getElementsByName('locations')[0].value;
        console.log(id_lpu);
        console.log(name_lpu);
        console.log(location);
        $.ajax({
            type: "POST",
            url: '<?=base_url();?>Main/lpu',
            data: {id_lpu : id_lpu,
                    name_lpu : name_lpu,
                    location : location},
            success: function(data){
                console.log(data);
                window.location.replace("<?=base_url();?>Main/lpu");
            }
        })
    }

</script>