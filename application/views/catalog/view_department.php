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
                <li><span>Отдел(группа)</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>
    <div class="col-md-12">
        <section class="panel">
<!--                форма для создания-->
            <?php if(isset($_POST['button_add_department'])) { ?>
                <form method="POST" action="<?= base_url(); ?>Main/departments" class="form-horizontal" novalidate="novalidate">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Форма по созданию отдела(группы)</h2>
                            <p class="panel-subtitle">
                                Заполните обязательные поля ниже
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Наименование отдела(группы)<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                        Форма для добавления-->
                                        <input type="text" name="name_department" class="form-control valid" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Номер отдела(группы)<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
                                       <input type="text" name="number_department" value="" class="form-control valid" required>
                                </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button type="submit" name="button_create_department" class="btn btn-primary">Создать</button>
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
                            <h2 class="panel-title">Форма по редактированию отдела(группы)</h2>
                            <p class="panel-subtitle">
                                Отредактируйте название отдела(группы) и нажмите сохранить
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Наименование отдела(группы)<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!-- Форма для редактирования-->
                                        <?php foreach($department as $item): ?>
                                                <input type="text" name="name_edit_department" value="<?php echo($item['name_department']); ?>" class="form-control valid" required>
                                            <?php endforeach; ?>
                                      </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Номер отдела(группы)<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
 <!-- Форма для редактирования-->
                                        <?php foreach($department as $item): ?>
                                            <input type="text" name="number_edit_department" value="<?php echo($item['number_department']); ?>" class="form-control valid" required>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                <?php foreach($department as $item): ?>
                                    <button type="button" onclick="save_edit_department(this);" data-name-department="<?php echo($item['name_department']); ?>" data-id-department="<?php echo($item['id_department']) ?>" name="button_save_edit_department" class="btn btn-primary">Сохранить</button>
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
                    <div class="table-responsive">
                        <table class="table tert table-hover mb-none">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Название Отдела(группы)</th>
                                <th>Номер Отдела(группы)</th>
                                <th style="width: 150px">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($departments as $item): ?>
                                <tr>
                                    <td></td>
                                    <td><?php if(isset($item['name_department'])) echo($item['name_department']);?></td>
                                    <td><?php if(isset($item['number_department'])) echo($item['number_department']);?></td>
                                    <td class="actions">
                                        <?php $query = sprintf(" <a data-toggle=\"tooltip\" href=\"departments?id_department=%d&check=departmentEdit\" name=\"\" data-original-title=\"Редактировать отдел(группу)\" >Редактировать</a> ", $item['id_department']);
                                        echo($query); ?>
<!--                                        <a data-toggle="tooltip" href="#" name="--><?php //if(isset($item['id_sklad'])) echo($item['id_sklad']); ?><!--" data-original-title="Редактировать склад" onclick="editSklad(this);" >Редактировать</a>-->
                                        <a data-toggle="tooltip" href="#" id="<?php if(isset($item['id_department'])) echo($item['id_department']); ?>" data-original-title="Удаление отдела(группы) насовсем" onclick="deleteDepartment(this);" style="color: #d91918;">Удалить</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <form method="POST" action="<?=base_url();?>main/departments">
                            <button type="submit" name="button_add_department" class="mb-xs mt-xs mr-xs btn btn-success">Добавить отдел(группу)</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </section>
    </div>
</section>

<script src="<?=base_url();?>assets/vendor/jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('.tert tbody tr').each(function(i) {
            var number = i + 1;
            $(this).find('td:first').text(number+".");
        });
    });

//    Отмена операции
    function resetButton(){
        console.log("123");
        window.location.replace("<?=base_url();?>Main/departments");
    }

//    Функция удаления
    function deleteDepartment(item) {
        if (confirm("Вы уверены что хотите удалить отдел(группу)?")) {
            var id_department = ($(item).attr('id'));
            var checkDel = "delete";
            $.ajax({
                type: "POST",
                data: {id_department: id_department,
                       checkDel : checkDel},
                url: '<?=base_url();?>Main/departments',
                success: function (data) {
                    console.log(data);
                    window.location.replace("<?=base_url();?>Main/departments");
                }
            });
            console.log(id_department);
        }
    }

//    Сохранение изменных данных
    function save_edit_department(item){
        var id_department = item.getAttribute('data-id-department');
        var name_department = document.getElementsByName('name_edit_department')[0].value;
        var number_department = document.getElementsByName('number_edit_department')[0].value;
        console.log(id_department);
        console.log(name_department);
        console.log(number_department);
        $.ajax({
            type: "POST",
            url: '<?=base_url();?>Main/departments',
            data: {id_department : id_department,
                    name_department : name_department,
                    number_department : number_department},
            success: function(data){
                console.log(data);
                window.location.replace("<?=base_url();?>Main/departments");
            }
        })
    }
</script>