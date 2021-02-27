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
                <li><span>Отчеты</span></li>
                <li><span>Распоряжения</span></li>
            </ol>
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>
<!--Edit Order-->
<?php if(isset($info_order)) { ?>
    <form method="POST" id="form" action="" class="form-horizontal" novalidate="novalidate">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Форма по созданию распоряжения</h2>
                <p class="panel-subtitle">Заполните обязательные поля </p>
            </header>
            <div class="panel-body">
            <?php foreach($info_order as $item_info): ?>
                <div class="form-group">
                    <label for="number_order_id" class="col-sm-3 control-label">Распоряжение №<span class="required">*</span></label>
                    <div class="col-md-3 mb-3">
                        <input data-toggle="tooltip" data-flag="<?php if(isset($item_info['flag'])) { echo($item_info['flag']); } ?>" data-id-order="<?php if(isset($item_info['id_all_orders'])) { echo($item_info['id_all_orders']); } ?>" data-html="true" name="number_order_id" id="number_order_id" type="text" class="number_order form-control" value="<?php if(isset($item_info['number_order'])) { echo($item_info['number_order']); } ?>" disabled
                               data-original-title="<font color='red'>Пример 45/12</font> </br> <u>45</u> - Код ресурсного отдела, который инициировал распоряжение. </br> <u>12</u> - Порядковый номер распоряжения проставляется, согласно реестру распоряжений, который ведётся в ресурсном отделе">
                        <label id="error_number_order_id" style="display: none" for="number_order_id" class="error"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="date_order_id" class="col-sm-3 control-label">От<span class="required">*</span></label>
                    <div class="col-md-3 mb-3 form-inline">
                        <input type="text" class="form-control date" name="date_order_id" id="date_order_id" value="<?php echo(date("d-m-Y")); ?>" value="<?php if(isset($item_info['date_order'])) { echo($item_info['date_order']); } ?>" disabled >
                        <a data-toggle="tooltip" title="" href="#" data-original-title="Дата создрания распоряжения будет формироваться с момента согласования расоряжения начальником ресурсного отдела">info</a>
                        <label id="error_date_order_id" style="display: none" for="date_order_id" class="error">14</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address_order_id" class="col-sm-3 control-label">Прошу отгрузить в адрес<span class="required">*</span></label>
                    <div class="col-md-3 mb-3">
                        <select class="form-control" disabled id="address_order_id"><option></option>
                            <?php foreach($filials as $item_filial): ?>
                                <?php $select_filial=($item_filial['name_filial']== $item_info['address_order'])?"selected":"";?>
                                <option value="<?php echo($item_filial['name_filial']); ?>" <?php echo($select_filial); ?> ><?php echo($item_filial['name_filial']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label id="error_address_order_id" style="display: none" for="address_order_id" class="error">123</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name_sklad_id" class="col-sm-3 control-label">Со склада<span class="required">*</span></label>
                    <div class="col-md-3 mb-3">
                        <select class="form-control" disabled name="name_sklad_id" id="name_sklad_id"><option></option>
                            <?php foreach($sklads as $item_sklad): ?>
                               <?php $select_sklad=($item_sklad['name_sklad'] == $item_info['name_sklad'])?"selected":""; ?>
                                <option value="<?php echo($item_sklad['name_sklad']); ?>" <?php echo($select_sklad); ?>><?php echo($item_sklad['name_sklad']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label id="error_name_sklad_id" style="display: none" for="name_sklad_id" class="error"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name_sklad_id" class="col-sm-3 control-label">Ответственный</label>
                    <div class="col-md-3 mb-3">
                        <?php foreach($author as $item_author): ?>
                            <input type="text" name="author_order_id" class="form-control date" value="<?php if(isset($item_author['sername'])) { echo($item_author['sername']." ".$item_author['name']." ".$item_author['patronymic'] ); } ?>" disabled >
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
<!--// 1 - Распоряжение создано, но еще не заполнено-->
                        <?php if ($info_order[0]['flag'] == 0){ ?>
                            <?php
                            $_username = $this->session->userdata('username');
                            $_actions = $this->session->userdata('actions');
                            if (isset ($_username) && ((($_actions['delete_order']) == 1) || (($_actions['edit_order']) == 1)) ) { ?>
                                <button id="editToTable" onclick="editOrder();" type="button" class="ButtonEditToTable btn btn-primary">Изменить <i class="fa fa-pencil"></i></button>
                                <button id="saveToEditOrder" style="display: none" onclick="saveEditOrder();" type="button" class="ButtonSaveEditToTable btn btn-success">Сохранить изменения <i class="fa fa-save"></i></button>
                                <button id="cancelToEditOrder" style="display: none" onclick="cancelEditOrder();" type="button" class="ButtonCancelEditToTable btn btn-warning">Отмена <i class="fa fa-undo"></i></button>
                            <?php } ?>
                            <?php
                            $_username = $this->session->userdata('username');
                            $_actions = $this->session->userdata('actions');
                            if (isset ($_username) && ((($_actions['delete_order']) == 1) || (($_actions['edit_order']) == 1) || (($_actions['show_order']) == 1)) ) { ?>
                                <button type="button" onclick="formationOrder();" class="ButtonFormationToTable btn btn-success">Сформировать форму</button>
                            <?php } ?>
                        <?php } ?>
<!--// 1 - Формирование распоряжения-->
                        <?php if ($info_order[0]['flag'] == 10){ ?>
                            <?php
                            $_username = $this->session->userdata('username');
                            $_actions = $this->session->userdata('actions');
                            $_department = $this->session->userdata('department');
                            if ( ( (($_actions['delete_order']) == 1) || (($_actions['edit_order']) == 1) || (($_actions['show_order']) == 1) || (($_actions['show_all_orders']) == 1) ) ) { ?>
                                <button type="button" onclick="formationOrder();" class="ButtonFormationToTable btn btn-success">Сформировать форму</button>
                            <?php } ?>

                            <?php
                            if (isset ($_username) && (($_actions['delete_order']) == 1) && (($_department == $info_order[0]['create_department']) || (($_actions['admin']) == 1))  ) { ?>
                                <button id="endToTable" onclick="endOrder();" type="button" class="ButtonEndTotable btn btn-info">Согласовать <i class="fa fa-send"></i></button>
                                <button id="return_edit_order" onclick="edit_endOrder(this);" type="button"
                                        class="Button_Return_edit_order btn btn-outline-warning">Вернуть на доработку <i class="fa fa-pencil"></i>
                                </button>
                            <?php } ?>
                        <?php } ?>
<!--// 2 - Распоряжение утверждено-->
                        <?php if ($info_order[0]['flag'] == 20){ ?>
                            <?php
                            $_username = $this->session->userdata('username');
                            $_actions = $this->session->userdata('actions');
                            $_department = $this->session->userdata('department');
                            if (isset ($_username) && (($_actions['delete_order']) == 1) && ($_department == $info_order[0]['create_department']) ) { ?>
                                <button type="button" onclick="formationOrder();" class="ButtonFormationToTable btn btn-success">Сформировать форму</button>
                            <?php } else { ?>
                                <button type="button" onclick="formationOrder();" class="ButtonFormationToTable btn btn-success">Сформировать форму</button>
                            <?php } ?>
                        <?php } ?>
<!--// 3 - По данному распоряжению начата работа на складе-->
                        <?php if ($info_order[0]['flag'] == 30){ ?>
                            <?php
                            $_username = $this->session->userdata('username');
                            $_actions = $this->session->userdata('actions');
                            $_department = $this->session->userdata('department');
                            if (isset ($_username) && (($_actions['delete_order']) == 1)  && ($_department == $info_order[0]['create_department']) ) { ?>
                                <button type="button" onclick="formationOrder();" class="ButtonFormationToTable btn btn-success">Сформировать форму</button>
                            <?php } else { ?>
                                <button type="button" onclick="formationOrder();" class="ButtonFormationToTable btn btn-success">Сформировать форму</button>
                            <?php } ?>
                        <?php } ?>
<!--// 4 - Склад передал информацию на участок-->
                        <?php if ($info_order[0]['flag'] == 40){ ?>
                            <?php
                            $_username = $this->session->userdata('username');
                            $_actions = $this->session->userdata('actions');
                            if (isset ($_username) && (($_actions['delete_order']) == 1)) { ?>
                                <button type="button" onclick="formationOrder();" class="ButtonFormationToTable btn btn-success">Сформировать форму</button>
                            <?php } ?>
                        <?php } ?>

                    </div>
                </div>
            </footer>
        </section>
    </form>
<?php } else { ?>
<!--New Order-->
    <form method="POST" name="save_order" action="<?=base_url();?>Main\saveAllOrder" class="form-horizontal" novalidate="novalidate">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Форма по созданию распоряжения</h2>
                <p class="panel-subtitle"> Заполните обязательные поля ниже</p>
            </header>
            <div class="panel-body">
                <div class="form-group">
                    <label for="number_order_id" class="col-sm-3 control-label">Распоряжение №<span class="required">*</span></label>
                    <div class="col-md-3 mb-3 ">
                        <input value="<?php foreach($department as $item_dep): echo($item_dep['number_department']); endforeach;?>/<?php print_R($max_id[0]['m']); ?>"
                               data-toggle="tooltip" data-html="true" name="number_order_id" id="number_order_id" type="text" class="number_order form-control"
                               data-original-title="<font color='red'>Пример 45/12</font> </br> <u>45</u> - Код ресурсного отдела, который инициировал распоряжение. </br> <u>12</u> - Порядковый номер распоряжения проставляется, согласно реестру распоряжений, который ведётся в ресурсном отделе">
                        <label id="error_number_order_id" style="display: none" for="number_order_id" class="error"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="date_order_id" class="col-sm-3 control-label">От<span class="required">*</span></label>
                    <div class="col-md-3 mb-3 form-inline">
                        <input type="text" class="form-control date" name="date_order_id" id="date_order_id" autocomplete="off" disabled value="<?php echo(date("d-m-Y")); ?>">
                        <a data-toggle="tooltip" title="" href="#" data-original-title="Дата создрания распоряжения будет формироваться с момента согласования расоряжения начальником ресурсного отдела">info</a>
                        <label id="error_date_order_id" style="display: none" for="date_order_id" class="error">14</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address_order_id" class="col-sm-3 control-label">Прошу отгрузить в адрес<span class="required">*</span></label>
                    <div class="col-md-3 mb-3">
                        <select class="form-control" name="address_order_id" id="address_order_id">
                            <?php foreach($filials as $item): ?>
                                <option value="<?php echo($item['name_filial']); ?>"><?php echo($item['name_filial']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label id="error_address_order_id" style="display: none" for="address_order_id" class="error">123</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name_sklad_id" class="col-sm-3 control-label">Со склада<span class="required">*</span></label>
                    <div class="col-md-3 mb-3">
                        <select class="form-control" name="name_sklad_id" id="name_sklad_id">
                            <?php foreach($sklads as $item): ?>
                                <option value="<?php echo($item['name_sklad']); ?>"><?php echo($item['name_sklad']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label id="error_name_sklad_id" style="display: none" for="name_sklad_id" class="error"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name_sklad_id" class="col-sm-3 control-label">Ответственный</label>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="author_order_id" class="form-control date" value="<?php echo $this->session->userdata('sername'); echo" "; echo $this->session->userdata('name'); echo" "; echo $this->session->userdata('patronymic'); ?>" disabled>
                    </div>
                </div>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button type="button" name="save_order" onclick="saveOrder();" class="btn btn-primary">Сохранить <i class="fa fa-save"></i></button>
                        <button type="button" onclick="showOrders();" class="btn btn-default">Отмена</button>
                    </div>
                </div>
            </footer>
        </section>
    </form>
<?php } ?>
</section>
<div class="modal_loading"></div> <!--окно загрузки-->

<script src="<?=base_url();?>assets/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url();?>assets/vendor/datepicker/locales/bootstrap-datepicker.ru.min.js" charset="UTF-8"></script>

<script>

    $body = $("body");
    $(document).on({
        ajaxStart: function() { $body.addClass("loading");    },
        ajaxStop: function() { $body.removeClass("loading"); }
    });

    $(document).ready(function() {
//Вывод даты
        $('#date_order_id').datepicker({
            orientation: 'bottom',
            uiLibrary: 'bootstrap',
            format: 'dd-mm-yyyy',
            locale: 'ru-ru'
        });
    });

//Возврат на список распоряжений
    function showOrders(){
        if(confirm ("Вы точно хотите выйти не сохранив изменения?")) {
            window.location.replace("<?=base_url();?>Main/range_date_orders");
        }
    }

//Сохранение распоряжение с занесением в базу
    function saveOrder() {
        var check_validation = validation_form();
        console.log("check_validation = "+check_validation);
        if (check_validation == 1 ) {
            // console.log("true");
            if (confirm("Вы точно хотите сохранить данные?")) {
                /*формирование запроса к базе All_order*/
                var JSnumber_order = document.getElementById('number_order_id').value;
                var JSdate_order = document.getElementById('date_order_id').value;
                var JSaddress_order = document.getElementById('address_order_id').value;
                var JSname_sklad = document.getElementById('name_sklad_id').value;
                // console.log(JSnumber_order);
                // console.log(JSdate_order);
                // console.log(JSaddress_order);
                // console.log(JSname_sklad);
                $.ajax({
                    url: "<?=base_url();?>Main/saveOrder",
                    type: "POST",
                    data: {
                        number_order: JSnumber_order,
                        date_order: JSdate_order,
                        address_order: JSaddress_order,
                        name_sklad: JSname_sklad
                    },
                    success: function (data) {
                        console.log(data);
                        window.location = "<?=base_url();?>Main/create_edit_order?id_order=" + data;
                    }
                });
            }
        }  else {
                alert("Обнаружены ошибки при сохранении формы, исправте ошибки и попробуйте снова");
           }
    }

//Отмена последних изменений выход из режима редактирования распоряжения
    function cancelEditOrder(){
        var t = document.getElementById('number_order_id');
        var JSid_order = t.getAttribute('data-id-order');
        console.log(JSid_order);
        window.location ="<?=base_url();?>Main/create_edit_order?id_order=" + JSid_order;
    }

//Режим редактирования распоряжения
    function editOrder(){
        /*Show and Hide кнопок управления*/
        $('.ButtonEndTotable').hide();
        $('.ButtonEditToTable').hide();
        $('.ButtonFormationToTable').hide();
        $('.ButtonCancelToTable').hide();
        $('.ButtonSaveEditToTable').show();
        $('.ButtonCancelEditToTable').show();

        /*Show and Hide input table*/
        $("#number_order_id").prop("disabled", false);
//        $("#date_order_id").prop("disabled", false);
        $("#address_order_id").prop("disabled", false);
        $("#name_sklad_id").prop("disabled", false);
    }

//Сохранение изменения распоряжения с занесением в базу
   function saveEditOrder() {
        // var check_validation = validation_form();
       check_validation = 1;
        console.log(check_validation);
        if (check_validation == 1 ){
            console.log("true");
            var el_order_name = document.getElementById('number_order_id');
            el_order_name.classList.add('is-valid');
            if (confirm ("Вы точно хотите сохранить внесенные изменения?")) {
                /*Show and Hide кнопок управления*/
                $('.ButtonSaveEditToTable').hide();
                $('.ButtonCancelEditToTable').hide();
                $('.ButtonEndTotable').show();
                $('.ButtonEditToTable').show();
                $('.ButtonFormationToTable').show();
                $('.ButtonCancelToTable').show();

                /*Show and Hide input table*/
                $("#number_order_id").prop("disabled", true);
                $("#date_order_id").prop("disabled", true);
                $("#address_order_id").prop("disabled", true);
                $("#name_sklad_id").prop("disabled", true);

                /*формирование запроса к базе All_order*/
                var JSnumber_order = document.getElementById('number_order_id').value;
                var JSdate_order = document.getElementById('date_order_id').value;
                var JSaddress_order = document.getElementById('address_order_id').value;
                var JSname_sklad = document.getElementById('name_sklad_id').value;
                var t = document.getElementById('number_order_id');
                var JSid_order = t.getAttribute('data-id-order');
                console.log(JSnumber_order);
                console.log(JSdate_order);
                console.log(JSaddress_order);
                console.log(JSname_sklad);
                console.log(JSid_order);
                $.ajax({
                    type: "POST",
                    url: "<?=base_url();?>Main/saveEditOrder",
                    data: {
                        number_order: JSnumber_order,
                        date_order: JSdate_order,
                        name_sklad: JSname_sklad,
                        address_order: JSaddress_order,
                        id_order: JSid_order
                    },
                    success: function (data) {
                        console.log(data);
                        window.location ="<?=base_url();?>Main/create_edit_order?id_order=" + JSid_order;
                    }
                });
            }
        } else {
            alert("Обнаружены ошибки при сохранении формы, исправте ошибки и попробуйте снова");
        }
    }
 var arrr; //Счетчик ошибок при заполнении формы
//Валидация формы (извлечение из базы номер распоряжения для последующей проверки)
    function validation_form(){
        var JSnumber_order = document.getElementById('number_order_id').value;
        $.ajax({
            url: "<?=base_url();?>Main/validation_order_number",
            type: "POST",
            data: {
                number_order: JSnumber_order,
            },
            async: false,
            success: function (data_id_order_test) {
                data_id_order = data_id_order_test;
                arrr = validation_form_test();
            }
        });
        if (arrr == 1){
            console.log("Good");
            return 1;
        } else {
            console.log("Bad");
            return 0;
        }
    }

//Валидация всей формы
    function validation_form_test() {

        var pattern_date = /^[0-9]{2}-[0-9]{2}-[0-9]{4}$/; //Дата распоряжения
        var pattern_name_order = /^[0-9/\\]+$/; //Номер распоряжения
        var arr = []; //Счетчик ошибок при заполнении формы

//Валидация номера распоряжения
        var order_name_element = $('#number_order_id');
        var class_error_order_name_element = order_name_element.parent().parent();
            if (order_name_element.val() != '') {
                if (order_name_element.val().search(pattern_name_order) == 0) {
                    if(data_id_order == 1){
                        class_error_order_name_element.removeClass('has-error');
                        class_error_order_name_element.addClass('has-success');
                        $('#error_number_order_id').hide();
                        arr[arr.length] = 1;
                    } else {
                        class_error_order_name_element.addClass('has-error');
                        $('#error_number_order_id').show();
                        $('#error_number_order_id').html('Распоряжение с таким номером уже сущесвует!');
                        arr[arr.length] = 0;
                    }
                } else {
                    class_error_order_name_element.addClass('has-error');
                    $('#error_number_order_id').show();
                    $('#error_number_order_id').html('Error');
                    arr[arr.length] = 0;
                }
            } else {
                class_error_order_name_element.addClass('has-error');
                $('#error_number_order_id').show();
                $('#error_number_order_id').html('Поле не должно быть пустым!');
                arr[arr.length] = 0;
            }

//Валидация даты распоряжения
        var date_order_element = $('#date_order_id');
        var class_error_date_order_element = date_order_element.parent().parent();
            if (date_order_element.val() != '') {
                if (date_order_element.val().search(pattern_date) == 0) {
                    class_error_date_order_element.removeClass('has-error');
                    class_error_date_order_element.addClass('has-success');
                    $('#error_date_order_id').hide();
                    arr[arr.length] = 1;
                } else {
                    class_error_date_order_element.addClass('has-error');
                    $('#error_date_order_id').show();
                    $('#error_date_order_id').html('Error');
                    arr[arr.length] = 0;
                }
            } else {
                class_error_date_order_element.addClass('has-error');
                $('#error_date_order_id').show();
                $('#error_date_order_id').html('Поле не должно быть пустым!');
                arr[arr.length] = 0;
            }
//Валидация адрес отгрузки
        var address_order_element = $('#address_order_id');
        var class_error_address_order_element = address_order_element.parent().parent();
            if (address_order_element.val() != '') {
                class_error_address_order_element.removeClass('has-error');
                class_error_address_order_element.addClass('has-success');
                $('#error_address_order_id').hide();
                arr[arr.length] = 1;
            } else {
                class_error_address_order_element.addClass('has-error');
                $('#error_address_order_id').show();
                $('#error_address_order_id').html('Поле не должно быть пустым!');
                arr[arr.length] = 0;
            }
//Валидация склада
        var name_sklad_element = $('#name_sklad_id');
        var class_error_name_sklad_element = name_sklad_element.parent().parent();
            if (name_sklad_element.val() != '') {
                class_error_name_sklad_element.removeClass('has-error');
                class_error_name_sklad_element.addClass('has-success');
                $('#error_name_sklad_id').hide();
                arr[arr.length] = 1;
            } else {
                class_error_name_sklad_element.addClass('has-error');
                $('#error_name_sklad_id').show();
                $('#error_name_sklad_id').html('Поле не должно быть пустым!');
                arr[arr.length] = 0;
            }

//Итоги валидации
        console.log(arr);
        var search = arr.indexOf(0);
        if (search == -1){
            console.log("Good");
            return 1;
        } else {
            console.log("Bad");
            return 0;
        }
    }

//Переход на шаг заполнения распоряжения
    function formationOrder(){
        var t = document.getElementById('number_order_id');
        var JSid_order = t.getAttribute('data-id-order');
        console.log(JSid_order);
        window.location ="<?=base_url();?>Main/formation_order?id_all_order=" + JSid_order;
    }

//Заключительный этап приема распоряжение - Завершить
    function endOrder(){
        if(confirm("Вы точно хотите завершить прием распоряжения и передать его на склад?")) {
            var t = document.getElementById('number_order_id');
            var JSid_order = t.getAttribute('data-id-order');
            $.ajax({
                type: "POST",
                url: "<?=base_url();?>Main/endAllOrder",
                data: {id_order : JSid_order},
                success: function(data){
                    console.log(data);
                    $('.ButtonEndTotable').hide();
                    window.location ="<?=base_url();?>Main/create_edit_order?id_order=" + JSid_order;
                }
            });
        }
    }

//Возрат распоряжения на этап формирования
    function edit_endOrder(){
        if(confirm("Вы точно хотите вернуть распоряжение на этап создание?")) {
            var t = document.getElementById('number_order_id');
            var JSid_order = t.getAttribute('data-id-order');
            $.ajax({
                type: "POST",
                url: "<?=base_url();?>Main/editendAllOrder",
                data: {id_order : JSid_order},
                success: function(data){
                    console.log(data);
                    window.location ="<?=base_url();?>Main/create_edit_order?id_order=" + JSid_order;
                }
            });
        }
    }

</script>