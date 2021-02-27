<section role="main" class="content-body">
    <header class="page-header">
        <h2>Режим доставки</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?=base_url();?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Справочники</span></li>
                <li><span>Режим доставки</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>
    <div class="col-md-12">
        <section class="panel">
<!--                форма для создания-->
            <?php if(isset($_POST['button_add_delivery_mode'])) { ?>
                <form method="POST" action="<?= base_url(); ?>Main/delivery_modes" class="form-horizontal" novalidate="novalidate">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Форма по созданию режимов доставки</h2>
                            <p class="panel-subtitle">
                                Заполните обязательные поля ниже
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Режим доставки<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                        Форма для добавления-->
                                        <input type="text" name="name_delivery_mode" class="form-control valid" value="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button type="submit" name="button_create_delivery_mode" class="btn btn-primary">Создать</button>
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
                                Отредактируйте режим доставки и нажмите сохранить
                            </p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Режим доставки<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </span>
<!--                                    Форма для редактирования-->
                                        <?php foreach($delivery_mode as $item): ?>
                                                <input type="text" name="name_edit_delivery_mode" value="<?php echo($item['name_delivery_mode']); ?>" class="form-control valid" required>
                                            <?php endforeach; ?>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                <?php foreach($delivery_mode as $item): ?>
                                    <button type="button" onclick="save_edit_delivery_mode(this);" data-name-delivery_mode="<?php echo($item['name_delivery_mode']); ?>" data-id-delivery_mode="<?php echo($item['id_delivery_mode']) ?>" name="button_save_edit_delivery_mode" class="btn btn-primary">Сохранить</button>
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
                                <th>Режим доставки</th>
                                <th style="width: 150px">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($delivery_modes as $item): ?>
                                <tr>
                                    <td></td>
                                    <td><?php if(isset($item['name_delivery_mode'])) echo($item['name_delivery_mode']);?></td>
                                    <td class="actions">
                                        <?php $query = sprintf(" <a data-toggle=\"tooltip\" href=\"delivery_modes?id_delivery_mode=%d&check=delivery_modeEdit\" name=\"\" data-original-title=\"Редактировать режим доставки\" >Редактировать</a> ", $item['id_delivery_mode']);
                                        echo($query); ?>
                                        <a data-toggle="tooltip" href="#" id="<?php if(isset($item['id_delivery_mode'])) echo($item['id_delivery_mode']); ?>" data-original-title="Удаление режима доставки насовсем" onclick="deleteDelivery_mode(this);" style="color: #d91918;">Удалить</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <form method="POST" action="<?=base_url();?>main/delivery_modes">
                            <button type="submit" name="button_add_delivery_mode" class="mb-xs mt-xs mr-xs btn btn-success">Добавить режим доставки</button>
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
        window.location.replace("<?=base_url();?>Main/delivery_modes");
    }

//    Функция удаления
    function deleteDelivery_mode(item) {
        if (confirm("Вы уверены что хотите удалить режим доставки?")) {
            var id_delivery_mode = ($(item).attr('id'));
            var checkDel = "delete";
            $.ajax({
                type: "POST",
                data: {id_delivery_mode: id_delivery_mode,
                       checkDel : checkDel},
                url: '<?=base_url();?>Main/delivery_modes',
                success: function (data) {
                    console.log(data);
                    window.location.replace("<?=base_url();?>Main/delivery_modes");
                }
            });
            console.log(id_delivery_mode);
        }
    }

//    Сохранение изменных данных
    function save_edit_delivery_mode(item){
        var id_delivery_mode = item.getAttribute('data-id-delivery_mode');
        var name_delivery_mode = document.getElementsByName('name_edit_delivery_mode')[0].value;
        console.log(id_delivery_mode);
        console.log(name_delivery_mode);
        $.ajax({
            type: "POST",
            url: '<?=base_url();?>Main/delivery_modes',
            data: {id_delivery_mode : id_delivery_mode,
                    name_delivery_mode : name_delivery_mode},
            success: function(data){
                console.log(data);
                window.location.replace("<?=base_url();?>Main/delivery_modes");
            }
        })
    }

</script>