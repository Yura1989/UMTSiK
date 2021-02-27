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
                <li><span>Склады</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>
    <div class="col-md-12">
        <section class="panel">
<!--                форма для создания-->
            <?php if(isset($_POST['button_add_sklad'])) { ?>
                <form method="POST" action="<?= base_url(); ?>Main/sklads" class="form-horizontal" novalidate="novalidate">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Форма по созданию склада</h2>
                            <p class="panel-subtitle">
                                Заполните обязательные поля ниже
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Наименование склада<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                        Форма для добавления-->
                                        <input type="text" name="name_sklad" class="form-control valid" value="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button type="submit" name="button_create_sklad" class="btn btn-primary">Создать</button>
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
                            <h2 class="panel-title">Форма по редактированию склада</h2>
                            <p class="panel-subtitle">
                                Отредактируйте название склада и нажмите сохранить
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Наименование склада<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                    Форма для редактирования-->
                                        <?php foreach($sklad as $item): ?>
                                                <input type="text" name="name_edit_sklad" value="<?php echo($item['name_sklad']); ?>" class="form-control valid" required>
                                            <?php endforeach; ?>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                <?php foreach($sklad as $item): ?>
                                    <button type="button" onclick="save_edit_sklad(this);" data-name-sklad="<?php echo($item['name_sklad']); ?>" data-id-sklad="<?php echo($item['id_sklad']) ?>" name="button_save_edit_sklad" class="btn btn-primary">Сохранить</button>
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
                                <th>Название Склада</th>
                                <th style="width: 150px">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sklads as $item): ?>
                                <tr>
                                    <td></td>
                                    <td><?php if(isset($item['name_sklad'])) echo($item['name_sklad']);?></td>
                                    <td class="actions">
                                        <?php $query = sprintf(" <a data-toggle=\"tooltip\" href=\"sklads?id_sklad=%d&check=skladEdit\" name=\"\" data-original-title=\"Редактировать склад\" >Редактировать</a> ", $item['id_sklad']);
                                        echo($query); ?>
<!--                                        <a data-toggle="tooltip" href="#" name="--><?php //if(isset($item['id_sklad'])) echo($item['id_sklad']); ?><!--" data-original-title="Редактировать склад" onclick="editSklad(this);" >Редактировать</a>-->
                                        <a data-toggle="tooltip" href="#" id="<?php if(isset($item['id_sklad'])) echo($item['id_sklad']); ?>" data-original-title="Удаление склада насовсем" onclick="deleteSklad(this);" style="color: #d91918;">Удалить</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <form method="POST" action="<?=base_url();?>main/sklads">
                            <button type="submit" name="button_add_sklad" class="mb-xs mt-xs mr-xs btn btn-success">Добавить склад</button>
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
        window.location.replace("<?=base_url();?>Main/sklads");
    }

//    Функция удаления
    function deleteSklad(item) {
        if (confirm("Вы уверены что хотите удалить склад?")) {
            var id_sklad = ($(item).attr('id'));
            var checkDel = "delete";
            $.ajax({
                type: "POST",
                data: {id_sklad: id_sklad,
                       checkDel : checkDel},
                url: '<?=base_url();?>Main/sklads',
                success: function (data) {
                    console.log(data);
                    window.location.replace("<?=base_url();?>Main/sklads");
                }
            });
            console.log(id_sklad);
        }
    }

//    //    Функция редактирования
//    function editSklad(item) {
//        var id_sklad = ($(item).attr('name'));
//        var checkEdit = "edit";
//        $.ajax({
//            type: "POST",
//            data: {
//                id_sklad: id_sklad,
//                check: checkEdit
//            },
//            url: '<?//=base_url();?>//Main/sklads',
//            success: function (data) {
//                console.log(data);
//                window.location.replace("<?//=base_url();?>//Main/sklads?check=" + 1);
//            }
//        });
//        console.log(id_sklad);
//    }

//    Сохранение изменных данных
    function save_edit_sklad(item){
        var id_sklad = item.getAttribute('data-id-sklad');
        var name_sklad = document.getElementsByName('name_edit_sklad')[0].value;
        console.log(id_sklad);
        console.log(name_sklad);
        $.ajax({
            type: "POST",
            url: '<?=base_url();?>Main/sklads',
            data: {id_sklad : id_sklad,
                    name_sklad : name_sklad},
            success: function(data){
                console.log(data);
                window.location.replace("<?=base_url();?>Main/sklads");
            }
        })
    }
//    Функция редактирования
//    function editSklad(item) {
//        var id_sklad = ($(item).attr('name'));
//        var checkEdit = "edit";
//        $.ajax({
//            type: "POST",
//            data: {
//                id_sklad: id_sklad,
//                check: checkEdit
//            },
//            url: '<?//=base_url();?>//Main/sklads',
//            success: function (data) {
//                console.log(data);
//                window.location.replace("<?//=base_url();?>//Main/sklads?check=" + 1);
//            }
//        });
//        console.log(id_sklad);
//    }
</script>