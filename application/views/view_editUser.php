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

                        <h2 class="panel-title">Информация о пользователе</h2>
                    </header>
                    <div class="col-md-12">

                        <div class="tabs">
                            <ul class="nav nav-tabs tabs-primary">
                                <li class="active">
                                    <a href="#edit" data-toggle="tab" aria-expanded="true">Редактирование</a>
                                </li>
                                <li class="">
                                    <a href="#overview" data-toggle="tab" aria-expanded="false">История</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="overview" class="tab-pane">

                                    <h4 class="mb-xlg">История действий</h4>

                                    <div class="timeline timeline-simple mt-xlg mb-md">
                                        <div class="tm-body">
                                            <div class="tm-title">
                                                <h3 class="h5 text-uppercase">Январь 2018</h3>
                                            </div>
                                            <ol class="tm-items">
                                                <li>
                                                    <div class="tm-box">
                                                        <p class="text-muted mb-none">1 день назад</p>
                                                        <p>
                                                            Создал распоряжение 45/12
                                                        </p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tm-box">
                                                        <p class="text-muted mb-none">Сегодня</p>
                                                        <p>
                                                            Внес изменения в распоряжение 45/12
                                                        </p>
                                                    </div>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                <div id="edit" class="tab-pane active">
                                    <?php foreach ($user as $item): ?>
                                    <form class="form-horizontal" action="<?=base_url();?>Main/editUser?<?php echo "user_id=".$item['id_user'] ?>" method="POST">
                                        <h4 class="mb-xlg">Персональная информация</h4>
                                        <fieldset>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Фамилия<span class="required">*</span></label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user"></i>
                                                            </span>
                                                            <input type="text" name="sername" class="form-control valid" value="<?php if(isset($item['sername'])) echo($item['sername']);?>" placeholder="Иванов" required="">
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
                                                            <input type="text" name="name" value="<?php if(isset($item['name'])) echo($item['name']);?>" class="form-control valid" placeholder="Иван" required="">
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
                                                            <input type="text" name="patronymic" class="form-control valid" value="<?php if(isset($item['patronymic'])) echo($item['patronymic']);?>" placeholder="Иванович" required="">
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
                                                            <input type="email" name="email" class="form-control" value="<?php if(isset($item['email'])) echo($item['email']);?>" title="Пожалуйста введите правильный email адрес" placeholder="email@email.com" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Должность <span class="required">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="position" value="<?php if(isset($item['position'])) echo($item['position']);?>" class="form-control valid" required placeholder="" >
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Отдел(группа) <span class="required">*</span></label>
                                                    <div class="col-sm-9">
                                                    <select name="department" class="form-control">
                                                        <?php foreach ($deparments as $item_department): ?>
                                                            <?php $select_department=($item_department['id_department']==$item['department'])?"selected":"";?>
                                                            <option value="<?php echo($item_department['id_department']); ?>" <?php echo($select_department); ?> ><?php echo($item_department['name_department']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Склад </label>
                                                    <div class="col-sm-9">
                                                        <select name="sklad" class="form-control">
                                                            <?php foreach ($sklad as $item_sklad): ?>
                                                                <?php $select_sklad=($item_sklad['id_sklad']==$item['n_sklad'])?"selected":"";?>
                                                                <option value="<?php echo($item_sklad['id_sklad']); ?>" <?php echo($select_sklad); ?> ><?php echo($item_sklad['name_sklad']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Участок </label>
                                                    <div class="col-sm-9">
                                                        <select name="filial" class="form-control">
                                                            <?php foreach ($filial as $item_filial): ?>
                                                                <?php $select_filial=($item_filial['id_filial']==$item['n_filial'])?"selected":"";?>
                                                                <option value="<?php echo($item_filial['id_filial']); ?>" <?php echo($select_filial); ?> ><?php echo($item_filial['name_filial']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Username<span class="required">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="username" class="form-control valid" value="<?php if(isset($item['username'])) echo($item['username']);?>" id="exampleInputUsername2" placeholder="Username" required="">
                                                    </div>
                                                </div>
                                        </fieldset>

                                        <h4 class="mb-xlg">Права доступа</h4>
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Роль<span class="required">*</span></label>
                                                <div class="col-sm-9">
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-show_order" value="show_order" <?php if ( (isset($item['show_order'])) && (($item['show_order']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-show_order">Просмотр распоряжений своего отдела</label>
                                                    </div>
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-show_all_order" value="show_all_orders" <?php if ( (isset($item['show_all_orders'])) && (($item['show_all_orders']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-show_all_order">Просмотр всех распоряжений</label>
                                                    </div>
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-show_motion" value="show_motion" <?php if ( (isset($item['show_motion'])) && (($item['show_motion']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-show_motion">Просмотр информации о движении МТР участка</label>
                                                    </div>
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-show_all_motion" value="show_all_motions" <?php if ( (isset($item['show_all_motions'])) && (($item['show_all_motions']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-show_all_motion">Просмотр всей информации о движении МТР</label>
                                                    </div>
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-edit_order" value="edit_order" <?php if ( (isset($item['edit_order'])) && (($item['edit_order']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-edit_order">Создание, изменение распоряжений</label>
                                                    </div>
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-edit_motion" value="edit_motion" <?php if ( (isset($item['edit_motion'])) && (($item['edit_motion']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-edit_motion">Создание, изменение информации о движении МТР</label>
                                                    </div>
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-delete_order" value="delete_order" <?php if ( (isset($item['delete_order'])) && (($item['delete_order']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-delete_order">Удаление распоряжений</label>
                                                    </div>
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-delete_motion" value="delete_motion" <?php if ( (isset($item['delete_motion'])) && (($item['delete_motion']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-delete_motion">Удаление информации о движении МТР</label>
                                                    </div>
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-print_orders" value="print_orders" <?php if ( (isset($item['print_orders'])) && (($item['print_orders']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-print_orders">Печать распоряжений</label>
                                                    </div>
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-return_edit_orders" value="return_edit_orders" <?php if ( (isset($item['return_edit_orders'])) && (($item['return_edit_orders']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-return_edit_orders">Вовзрат распоряжения на изменение</label>
                                                    </div>
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-filial_edit_motion" value="filial_edit_motion" <?php if ( (isset($item['filial_edit_motion'])) && (($item['filial_edit_motion']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-filial_edit_motion">Занесении информации о движении МТР на учатке</label>
                                                    </div>
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-edit_datas" value="edit_datas" <?php if ( (isset($item['edit_datas'])) && (($item['edit_datas']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-edit_datas">Изменение справочников</label>
                                                    </div>
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="for-admin" value="admin" <?php if ( (isset($item['admin'])) && (($item['admin']) == TRUE)) { echo ('checked'); } ?> type="checkbox" name="for[]">
                                                        <label for="for-admin">Администратор</label>
                                                    </div>
                                                </div>
                                             </div>
                                        </fieldset>
                                        <?php endforeach ?>
                                        <hr class="dotted tall">
                                        <h4 class="mb-xlg">Смена пароля</h4>
                                        <fieldset class="mb-xl">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="for-new_pw">Изменить пароль</label>
                                                <div class="col-md-8 ">
                                                    <input id="for-new_pw" value="new_pw" type="checkbox" onchange="showMe(this)" name="new_pw">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="profileNewPassword">Новый пароль<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="password" class="form-control" disabled name="password" required id="profileNewPassword" >
                                                    <small><?php echo form_error('password'); ?></small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="profileNewPasswordRepeat">Повторите новый пароль<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="password" class="form-control" disabled name="repassword" required id="profileNewPasswordRepeat" >
                                                    <small><?php echo form_error('repassword'); ?></small>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-md-9 col-md-offset-3">
                                                    <button type="submit" name="BTedituser" class="btn btn-primary">Сохранить</button>
                                                    <button type="button" onclick="showUsers();" class="btn btn-default">Отмена</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
</section>

<script>

    function showMe(temp){
        if(temp.checked == 1) {
            console.log(temp.checked);
            $('#profileNewPassword').prop("disabled", false);
            $('#profileNewPasswordRepeat').prop("disabled", false);

        } else {
            console.log(temp.checked);
            $('#profileNewPassword').prop("disabled", true);
            $('#profileNewPasswordRepeat').prop("disabled", true);
        }
    }

    function showUsers(){
        window.location.replace("<?=base_url();?>Main/showUsers");
    }
</script>