<section role="main" class="content-body">
    <header class="page-header">
        <h2>Объекты</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?=base_url();?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Справочники</span></li>
                <li><span>Объекты</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>
    <div class="col-md-12">
        <section class="panel">
<!--                форма для создания-->
            <?php if(isset($_POST['button_add_object'])) { ?>
                <form method="POST" action="<?= base_url(); ?>Main/objects" class="form-horizontal" novalidate="novalidate">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Форма по созданию объекта</h2>
                            <p class="panel-subtitle">
                                Заполните обязательные поля ниже
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Наименование Объекта<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                        Форма для добавления-->
                                        <input type="text" name="name_object" class="form-control valid" value="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button type="submit" name="button_create_object" class="btn btn-primary">Создать</button>
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
                            <h2 class="panel-title">Форма по редактированию объекта</h2>
                            <p class="panel-subtitle">
                                Отредактируйте название объекта и нажмите сохранить
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Наименование Объекта<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                    Форма для редактирования-->
                                        <?php foreach($object as $item): ?>
                                                <input type="text" name="name_edit_object" value="<?php echo($item['name_object']); ?>" class="form-control valid" required>
                                            <?php endforeach; ?>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                <?php foreach($object as $item): ?>
                                    <button type="button" onclick="save_edit_object(this);" data-name-object="<?php echo($item['name_object']); ?>" data-id-object="<?php echo($item['id_object']) ?>" name="button_save_edit_object" class="btn btn-primary">Сохранить</button>
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
                                <th>Название Объекта</th>
                                <th style="width: 150px">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($objects as $item): ?>
                                <tr>
                                    <td></td>
                                    <td><?php if(isset($item['name_object'])) echo($item['name_object']);?></td>
                                    <td class="actions">
                                        <?php $query = sprintf(" <a data-toggle=\"tooltip\" href=\"objects?id_object=%d&check=objectEdit\" name=\"\" data-original-title=\"Редактировать объекта\" >Редактировать</a> ", $item['id_object']);
                                        echo($query); ?>
                                        <a data-toggle="tooltip" href="#" id="<?php if(isset($item['id_object'])) echo($item['id_object']); ?>" data-original-title="Удаление объекта насовсем" onclick="deleteObject(this);" style="color: #d91918;">Удалить</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <form method="POST" action="<?=base_url();?>main/objects">
                            <button type="submit" name="button_add_object" class="mb-xs mt-xs mr-xs btn btn-success">Добавить объект</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </section>
    </div>
</section>

<script src="<?=base_url();?>assets/javascripts/forms/jquery-3.2.1.min.js"></script>
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
        window.location.replace("<?=base_url();?>Main/objects");
    }

//    Функция удаления
    function deleteObject(item) {
        if (confirm("Вы уверены что хотите удалить объект?")) {
            var id_object = ($(item).attr('id'));
            var checkDel = "delete";
            $.ajax({
                type: "POST",
                data: {id_object: id_object,
                       checkDel : checkDel},
                url: '<?=base_url();?>Main/objects',
                success: function (data) {
                    console.log(data);
                    window.location.replace("<?=base_url();?>Main/objects");
                }
            });
            console.log(id_object);
        }
    }

//    Сохранение изменных данных
    function save_edit_object(item){
        var id_object = item.getAttribute('data-id-object');
        var name_object = document.getElementsByName('name_edit_object')[0].value;
        console.log(id_object);
        console.log(name_object);
        $.ajax({
            type: "POST",
            url: '<?=base_url();?>Main/objects',
            data: {id_object : id_object,
                    name_object : name_object},
            success: function(data){
                console.log(data);
                window.location.replace("<?=base_url();?>Main/objects");
            }
        })
    }

</script>