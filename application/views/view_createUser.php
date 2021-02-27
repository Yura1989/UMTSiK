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
            <form method="POST" id="form" action="<?=base_url();?>Main/createUser" class="form-horizontal" novalidate="novalidate">
                <section class="panel">
                    <header class="panel-heading">

                        <h2 class="panel-title">Форма по созданию пользователя</h2>
                        <p class="panel-subtitle">
                            Заполните обязательные поля ниже
                        </p>
                    </header>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Фамилия<span class="required">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                    <input type="text" name="sername" class="form-control valid" placeholder="Иванов" required="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Имя<span class="required">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                    <input type="text" name="name" class="form-control valid" placeholder="Иван" required="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Отчество<span class="required">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                    <input type="text" name="patronymic" class="form-control valid" placeholder="Иванович" required="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </span>
                                    <input type="email" name="email" class="form-control" title="Пожалуйста введите правильный email адрес" placeholder="email@email.com" required="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Должность <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="position" class="form-control valid" required placeholder="" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Отдел(группа) <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select name="department" class="form-control">
                                    <?php foreach ($deparments as $item): ?>
                                        <option value="<?php echo($item['id_department']) ?>">
                                            <?php echo($item['name_department']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Склад </label>
                            <div class="col-sm-9">
                                <select name="sklad" class="form-control">
                                    <?php foreach ($sklad as $item_s): ?>
                                        <option value="<?php echo($item_s['id_sklad']) ?>">
                                            <?php echo($item_s['name_sklad']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Участок </label>
                            <div class="col-sm-9">
                                <select name="filial" class="form-control">
                                    <?php foreach ($filial as $item_f): ?>
                                        <option value="<?php echo($item_f['id_filial']) ?>">
                                            <?php echo($item_f['name_filial']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Роль<span class="required">*</span></label>
                            <div class="col-sm-9">
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-show_order" value="show_order" type="checkbox" name="for[]">
                                    <label for="for-show_order">Просмотр распоряжений своего отдела</label>
                                </div>
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-show_all_order" value="show_all_orders" type="checkbox" name="for[]">
                                    <label for="for-show_all_order">Просмотр всех распоряжений</label>
                                </div>
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-show_motion" value="show_motion" type="checkbox" name="for[]">
                                    <label for="for-show_motion">Просмотр информации о движении МТР участка</label>
                                </div>
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-show_all_motions" value="show_all_motions" type="checkbox" name="for[]">
                                    <label for="for-show_all_motions">Просмотр всей информации о движении МТР</label>
                                </div>
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-edit_order" value="edit_order" type="checkbox" name="for[]">
                                    <label for="for-edit_order">Создание, изменение распоряжений</label>
                                </div>
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-edit_motion" value="edit_motion" type="checkbox" name="for[]">
                                    <label for="for-edit_motion">Создание, изменение информации о движении МТР</label>
                                </div>
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-delete_order" value="delete_order" type="checkbox" name="for[]">
                                    <label for="for-delete_order">Удаление распоряжений</label>
                                </div>
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-delete_motion" value="delete_motion" type="checkbox" name="for[]">
                                    <label for="for-delete_motion">Удаление информации о движении МТР</label>
                                </div>
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-print_orders" value="print_orders" type="checkbox" name="for[]">
                                    <label for="for-print_orders">Печать распоряжений</label>
                                </div>
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-return_edit_orders" value="return_edit_orders" type="checkbox" name="for[]">
                                    <label for="for-return_edit_orders">Вовзрат распоряжения на изменение</label>
                                </div>
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-filial_edit_motion" value="filial_edit_motion" type="checkbox" name="for[]">
                                    <label for="for-filial_edit_motion">Занесении информации о движении МТР на учатке</label>
                                </div>
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-edit_datas" value="edit_datas" type="checkbox" name="for[]">
                                    <label for="for-edit_datas">Изменение справочников</label>
                                </div>
                                <div class="checkbox-custom chekbox-primary">
                                    <input id="for-admin" value="admin" type="checkbox" name="for[]">
                                    <label for="for-admin">Администратор</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Username<span class="required">*</span></label>
                            <div class="col-sm-9">
                                    <input type="text" name="username" class="form-control valid" id="exampleInputUsername2" placeholder="Username" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Password<span class="required">*</span></label>
                            <div class="col-sm-9">
                                    <input type="password" name="password" class="form-control valid" id="exampleInputPassword2" placeholder="Password" required="">
                            </div>
                        </div>
                     </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button type="submit" name="buttoncreateuser" class="btn btn-primary">Создать</button>
                                <button type="button" onclick="showUsers();" class="btn btn-default">Отмена</button>
                            </div>
                        </div>
                    </footer>
                </section>
            </form>
</section>

<script>
    function showUsers(){
        window.location.replace("<?=base_url();?>Main/showUsers");
    }
</script>