<div class="content p-4">
    <h2 class="mb-4">Матрица доступа</h2>
    <div class="card mb-4">
        <div class="card-header bg-white font-weight-bold">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModalCenter">Добавить пользователя</button>
        </div>
        <div class="card-body">
            <div class="row">
                <table id="myMatrix" class="matrix_table compact table table-bordered table-hover table-sm"
                       style="width: 100%;">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Отдел(группа)</th>
                        <th>Имя компьютера</th>
                        <th>ФИО</th>
                        <th>Система</th>
                        <th>Операции</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($matrix as $item_matrix): ?>
                        <tr role="row" class="odd">
                            <td></td>
                            <td><?php if(isset($item_matrix['id_number_department'])) {echo($item_matrix['id_number_department']);} ?></td>
                            <td><?php if(isset($item_matrix['name_workstation'])) {echo($item_matrix['name_workstation']);} ?></td>
                            <td><?php if(isset($item_matrix['name_user'])) {echo($item_matrix['name_user']);} ?></td>
                            <td><?php if(isset($item_matrix['name_systems'])) {echo($item_matrix['name_systems']);} ?></td>
                            <td class=" actions">
                                <a href="#" class="btn btn-icon btn-pill btn-primary" data-id_name_user_edit="<?php if(isset($item_matrix['id_matrix'])) {echo($item_matrix['id_matrix']);} ?>"
                                   data-toggle="tooltip" title="Изменить"><i class="fa fa-fw fa-edit"></i></a>
                                <a href="#" class="btn btn-icon btn-pill btn-danger" data-id_name_user_del="<?php if(isset($item_matrix['id_matrix'])) {echo($item_matrix['id_matrix']);} ?>"
                                   data-name_user="<?php if(isset($item_matrix['name_user'])) {echo($item_matrix['name_user']);} ?>"
                                   data-toggle="tooltip" onclick="delete_user(this)" title="Удалить"><i class="fa fa-fw fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModalCenter">Добавить пользователя</button>
        </div>
    </div>
</div>

<!--Модальное окно для редактирования пользователя-->
<div class="modal fade" id="EditModalCenter" tabindex="-1" role="dialog" aria-labelledby="EditModalCenter" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditModalCenter">Изменение доступа пользователя</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="EditModalCenter">Название пользователя</label>
                    <div id="html_system_edit"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" id="id_system_edit" onclick="edit_name_system();" class="btn btn-primary" data-dismiss="modal">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<!--Модальное окно для добавления пользователя/-->
<div class="modal fade" id="addModalCenter" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalCenterTitle">Добавление пользователя</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="group">Отдел(группа)</label>
                    <input type="text" id="name_group" value="" autocomplete="off" name=group" class="form-control">
                    <label for="name_user">ФИО пользователя</label>
                    <input type="text" id="name_user" value="" autocomplete="off" name=name_user" class="form-control">
                    <label for="name_PC">Имя компьютера</label>
                    <input type="text" id="name_PC" value="" autocomplete="off" name=name_PC" class="form-control">
                    <label for="exampleFormControlInput1">Доступ к Системе(ам)</label>
                    <?php foreach($systems as $item): ?>
                    <div class="form-check">
                        <input class="form-check-input name_systems" type="checkbox" value="<?php if(isset($item['name_system'])){echo($item['name_system']);} ?>" id="<?php if(isset($item['id_systems'])){echo($item['id_systems']);} ?>">
                        <label class="form-check-label " for="<?php if(isset($item['id_systems'])){echo($item['id_systems']);} ?>">
                            <?php if(isset($item['name_system'])){echo($item['name_system']);} ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" onclick="add_new_users();" class="btn btn-primary" data-dismiss="modal">Добавить</button>
            </div>
        </div>
    </div>
</div>

<script>
    //Добавление нового пользователя в матрицу
    function add_new_users(){
         if(confirm("Вы точно хотите добавить нового пользователя")){
             var name_group = document.getElementById("name_group").value;
             var name_user = document.getElementById("name_user").value;
             var name_PC = document.getElementById("name_PC").value;
             var checkbox_name_systems = document.getElementsByClassName('name_systems');
             var checkbox_name_systems_checked = [];
             for (var index = 0; index < checkbox_name_systems.length; index++){
                 if(checkbox_name_systems[index].checked){
                     checkbox_name_systems_checked.push(checkbox_name_systems[index].value);
                     console.log(checkbox_name_systems_checked);
                 }
             }
             console.log(name_group + name_user + name_PC);
             $.ajax({
                 type: "POST",
                 url: "<?=base_url();?>it/add_name_user_matrix",
                 data: {name_group : name_group,
                     name_user : name_user,
                     name_PC : name_PC,
                     checkbox_name_systems_checked : checkbox_name_systems_checked
                 },
                 success: function(data) {
                     console.log(data);
                     window.location = "<?=base_url();?>it/index";
                 }
             })
         }
    }

    function delete_user(id){
        var id_name_user = id.getAttribute('data-id_name_user_del');
        var name_user = id.getAttribute('data-name_user');
        console.log(id_name_user);
        if(confirm("Вы точно хотите удалить пользователя "+name_user +" ?")){
            var t = $('#myMatrix').DataTable();
            $('#myMatrix').on("click", "a", function(){
                t.row($(this).parents('tr')).remove().draw(false);
            });
            $.ajax({
                type: "POST",
                url: "<?=base_url();?>it/delete_name_user",
                data: {
                    id_name_user:id_name_user
                },
                success: function(data){
                    console.log(data);
                }
            })
        }
    }
</script>