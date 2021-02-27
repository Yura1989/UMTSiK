<section role="main" class="content-body">
    <header class="page-header">
        <h2>Участки</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?=base_url();?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Справочники</span></li>
                <li><span>Участки</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>
    <div class="col-md-12">
        <section class="panel">
<!--                форма для создания-->
            <?php if(isset($_POST['button_add_filial'])) { ?>
                <form method="POST" action="<?= base_url(); ?>Main/filials" class="form-horizontal" novalidate="novalidate">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Форма по созданию участков</h2>
                            <p class="panel-subtitle">
                                Заполните обязательные поля ниже
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Наименование участка<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                        Форма для добавления-->
                                        <input type="text" name="name_filial" class="form-control valid" value="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button type="submit" name="button_create_filial" class="btn btn-primary">Создать</button>
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
                            <h2 class="panel-title">Форма по редактированию участка</h2>
                            <p class="panel-subtitle">
                                Отредактируйте название участка и нажмите сохранить
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Наименование участка<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                    Форма для редактирования-->
                                        <?php foreach($filial as $item): ?>
                                                <input type="text" name="name_edit_filial" value="<?php echo($item['name_filial']); ?>" class="form-control valid" required>
                                            <?php endforeach; ?>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                <?php foreach($filial as $item): ?>
                                    <button type="button" onclick="save_edit_filial(this);" data-name-filial="<?php echo($item['name_filial']); ?>" data-id-filial="<?php echo($item['id_filial']) ?>" name="button_save_edit_filial" class="btn btn-primary">Сохранить</button>
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
                                <th>Название участка</th>
                                <th style="width: 150px">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($filials as $item): ?>
                                <tr>
                                    <td></td>
                                    <td><?php if(isset($item['name_filial'])) echo($item['name_filial']);?></td>
                                    <td class="actions">
                                        <?php $query = sprintf(" <a data-toggle=\"tooltip\" href=\"filials?id_filial=%d&check=filialEdit\" name=\"\" data-original-title=\"Редактировать филиала\" >Редактировать</a> ", $item['id_filial']);
                                        echo($query); ?>
                                        <a data-toggle="tooltip" href="#" id="<?php if(isset($item['id_filial'])) echo($item['id_filial']); ?>" data-original-title="Удаление филиала насовсем" onclick="deleteFilial(this);" style="color: #d91918;">Удалить</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <form method="POST" action="<?=base_url();?>main/filials">
                            <button type="submit" name="button_add_filial" class="mb-xs mt-xs mr-xs btn btn-success">Добавить участок</button>
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
        window.location.replace("<?=base_url();?>Main/filials");
    }

//    Функция удаления
    function deleteFilial(item) {
        if (confirm("Вы уверены что хотите удалить участок?")) {
            var id_filial = ($(item).attr('id'));
            var checkDel = "delete";
            $.ajax({
                type: "POST",
                data: {id_filial: id_filial,
                       checkDel : checkDel},
                url: '<?=base_url();?>Main/filials',
                success: function (data) {
                    console.log(data);
                    window.location.replace("<?=base_url();?>Main/filials");
                }
            });
            console.log(id_filial);
        }
    }

//    Сохранение изменных данных
    function save_edit_filial(item){
        var id_filial = item.getAttribute('data-id-filial');
        var name_filial = document.getElementsByName('name_edit_filial')[0].value;
        console.log(id_filial);
        console.log(name_filial);
        $.ajax({
            type: "POST",
            url: '<?=base_url();?>Main/filials',
            data: {id_filial : id_filial,
                    name_filial : name_filial},
            success: function(data){
                console.log(data);
                window.location.replace("<?=base_url();?>Main/filials");
            }
        })
    }

</script>