<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/dataTables/jquery.dataTables.min.css" >
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Склады</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?=base_url();?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Справочники</span></li>
                <li><span>Единицы измерения</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>
    <div class="col-md-12">
        <section class="panel">
<!--                форма для создания-->
            <?php if(isset($_POST['button_add_measure'])) { ?>
                <form method="POST" action="<?= base_url(); ?>Main/measures" class="form-horizontal" novalidate="novalidate">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Форма по созданию единиц измерения</h2>
                            <p class="panel-subtitle">
                                Заполните обязательные поля ниже
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Единица измерения<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                        Форма для добавления-->
                                        <input type="text" name="name_measure" class="form-control valid" value="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button type="submit" name="button_create_measure" class="btn btn-primary">Создать</button>
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
                            <h2 class="panel-title">Форма по редактированию единицы измерения</h2>
                            <p class="panel-subtitle">
                                Отредактируйте единицу измерения и нажмите сохранить
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Единица измерения<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                    Форма для редактирования-->
                                        <?php foreach($measure as $item): ?>
                                                <input type="text" name="name_edit_measure" value="<?php echo($item['name_measure']); ?>" class="form-control valid" required>
                                        <?php endforeach; ?>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                <?php foreach($measure as $item): ?>
                                    <button type="button" onclick="save_edit_measure(this);" data-name-measure="<?php echo($item['name_measure']); ?>" data-id-measure="<?php echo($item['id_measure']) ?>" name="button_save_edit_measure" class="btn btn-primary">Сохранить</button>
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
                                <th>Единица измерения</th>
                                <th>Статус</th>
                                <th style="width: 150px">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($measures as $item): ?>
                                <tr>
                                    <td></td>
                                    <td><?php if(isset($item['name_measure'])) echo($item['name_measure']);?></td>
                                    <?php if(($item['show_measures']) == 1) {?>
                                    <td style="color: #d91918;">Отключено</td>
                                    <?php } else { ?>
                                    <td >Включено</td>
                                    <?php } ?>
                                    <td class="actions">
                                        <?php $query = sprintf(" <a data-toggle=\"tooltip\" href=\"measures?id_measure=%d&check=measureEdit\" name=\"\" data-original-title=\"Редактировать единицу измерения\" >Редактировать</a> ", $item['id_measure']);
                                        echo($query); ?>
<!--                                        <a data-toggle="tooltip" href="#" name="--><?php //if(isset($item['id_sklad'])) echo($item['id_sklad']); ?><!--" data-original-title="Редактировать склад" onclick="editSklad(this);" >Редактировать</a>-->
                                        <?php if($item['show_measures'] == 1) { ?>
                                         <a data-toggle="tooltip" href="#" id="<?php if(isset($item['id_measure'])) echo($item['id_measure']); ?>" data-original-title="Включить данную единицу измерения" onclick="OnMeasure(this);" style="color: #369237;">Включить</a>
                                        <?php } else { ?>
                                        <a data-toggle="tooltip" href="#" id="<?php if(isset($item['id_measure'])) echo($item['id_measure']); ?>" data-original-title="Отключение данного значения" onclick="OffMeasure(this);" style="color: #d91918;">Отключить</a>
                                        <?php } ?>
                                        <a data-toggle="tooltip" href="#" id="<?php if(isset($item['id_measure'])) echo($item['id_measure']); ?>" data-original-title="Удаление единицу измерения насовсем" onclick="deleteMeasure(this);" style="color: #d91918;">Удалить</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <form method="POST" action="<?=base_url();?>main/measures">
                            <button type="submit" name="button_add_measure" class="mb-xs mt-xs mr-xs btn btn-success">Добавить единицу измерения</button>
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
        window.location.replace("<?=base_url();?>Main/measures");
    }

//    Функция включения
    function OnMeasure(item) {
        if (confirm("Вы уверены что хотите включить единицу измерения?")) {
            var id_measure = ($(item).attr('id'));
            var checkOn = "off";
            $.ajax({
                type: "POST",
                data: {id_measure: id_measure,
                    checkOn : checkOn},
                url: '<?=base_url();?>Main/measures',
                success: function (data) {
                    console.log(data);
                    window.location.replace("<?=base_url();?>Main/measures");
                }
            });
            console.log(id_measure);
        }
    }
    
//    Функция отключения
    function OffMeasure(item) {
        if (confirm("Вы уверены что хотите отключить единицу измерения?")) {
            var id_measure = ($(item).attr('id'));
            var checkOff = "off";
            $.ajax({
                type: "POST",
                data: {id_measure: id_measure,
                    checkOff : checkOff},
                url: '<?=base_url();?>Main/measures',
                success: function (data) {
                    console.log(data);
                    window.location.replace("<?=base_url();?>Main/measures");
                }
            });
            console.log(id_measure);
        }
    }

//    Функция удаления
    function deleteMeasure(item) {
        if (confirm("Вы уверены что хотите удалить единицу измерения?")) {
            var id_measure = ($(item).attr('id'));
            var checkDel = "off";
            $.ajax({
                type: "POST",
                data: {id_measure: id_measure,
                       checkDel : checkDel},
                url: '<?=base_url();?>Main/measures',
                success: function (data) {
                    console.log(data);
                    window.location.replace("<?=base_url();?>Main/measures");
                }
            });
            console.log(id_measure);
        }
    }

//    Сохранение изменных данных
    function save_edit_measure(item){
        var id_measure = item.getAttribute('data-id-measure');
        var name_measure = document.getElementsByName('name_edit_measure')[0].value;
        console.log(id_measure);
        console.log(name_measure);
        $.ajax({
            type: "POST",
            url: '<?=base_url();?>Main/measures',
            data: {id_measure : id_measure,
                    name_measure : name_measure},
            success: function(data){
                console.log(data);
                window.location.replace("<?=base_url();?>Main/measures");
            }
        })
    }
</script>