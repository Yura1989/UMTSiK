<div class="content p-4">
    <h2 class="mb-4">Системы Югорского УМТСиК</h2>
    <div class="card mb-4">
        <div class="card-header bg-white font-weight-bold">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModalCenter">Добавить систему</button>
        </div>
        <div class="card-body">
            <div class="row">
                <table id="myMatrix" class="matrix_table compact table table-bordered table-hover table-sm"
                       style="width: 100%;">
                    <thead>
                    <tr style="text-align: center">
                        <th>№</th>
                        <th>Название системы</th>
                        <th>Операции</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($systems as $item): ?>
                    <tr role="row" class="odd">
                        <td></td>
                        <td><?php if(isset($item['name_system'])) { echo ($item['name_system']); } ?></td>
                        <td class=" actions">
                            <a href="#" class="btn btn-icon btn-pill btn-primary" data-toggle="modal" data-target="#EditModalCenter" data-id_name_system="<?php if(isset($item['id_systems'])) { echo ($item['id_systems']); } ?>" onclick="select_system(this);" title="Изменить"><i
                                    class="fa fa-fw fa-edit"></i></a>
                            <a href="#" class="btn btn-icon btn-pill btn-danger" data-id_name_systems="<?php if(isset($item['id_systems'])) { echo ($item['id_systems']); } ?>" onclick="delete_name_systems(this);" title="Удалить"><i
                                    class="fa fa-fw fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModalCenter">Добавить систему</button>
        </div>
    </div>
</div>

<!--Модальное окно для редактирования системы-->
<div class="modal fade" id="EditModalCenter" tabindex="-1" role="dialog" aria-labelledby="EditModalCenter" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditModalCenter">Изменение названия системы</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="EditModalCenter">Название системы</label>
                    <div id="html_system_edit"></div>
<!--                    <input type="text" id="name_system_edit" value="" autocomplete="off" name=name_system" class="form-control">-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" id="id_system_edit" onclick="edit_name_system();" class="btn btn-primary" data-dismiss="modal">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<!--Модальное окно для добавления системы/-->
<div class="modal fade" id="addModalCenter" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalCenterTitle">Добавление системы</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Название системы</label>
                    <input type="text" id="name_system" value="" autocomplete="off" name=name_system" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" onclick="add_name_systems();" class="btn btn-primary" data-dismiss="modal">Добавить</button>
            </div>
        </div>
    </div>
</div>

<script>

    function add_name_systems(){
        if(confirm("Вы точно хотите добавить данную систему?")){
            var name_system = document.getElementById("name_system").value;
            console.log("Добавление системы "+ name_system);
            $.ajax({
                type: "POST",
                url: "<?=base_url();?>it/add_system_it",
                data: {name_system : name_system},
                success: function(data) {
                    console.log(data);
                    window.location = "<?=base_url();?>it/systems_it";
                }
            })
        }
    }

    function delete_name_systems(id){
        if(confirm("Вы точно хотите удалить данную систему?")){
            var id_name_systems = id.getAttribute('data-id_name_systems');
            console.log(id_name_systems);

            var t = $('#myMatrix').DataTable();
            $('#myMatrix').on("click", "a", function(){
                t.row($(this).parents('tr')).remove().draw(false);
            });

            $.ajax({
                type: "POST",
                url: "<?=base_url();?>it/delete_system_it",
                data: {id_name_systems : id_name_systems},
                success: function(data) {
                    console.log(data);
                }
            })
        }
    }

    function select_system(id){
            var id_name_systems = id.getAttribute('data-id_name_system');
            console.log(id_name_systems);

            $.ajax({
                type: "POST",
                url: "<?=base_url();?>it/show_system_it",
                data: {id_name_systems : id_name_systems},
                success: function(data) {
                    console.log(data);
                    $("#html_system_edit").html(data);
                }
            })
    }

    function edit_name_system() {
        if(confirm("Вы точно хотите сохранить внесенные изменения?")){
            var name_system = document.getElementById("name_system_edit").value;
            var id_name_systems = document.getElementById("name_system_edit").getAttribute('data-id_name_system');
            console.log("Внесение изменение системы "+name_system+ " где "+id_name_systems );
            $.ajax({
                type: "POST",
                url: "<?=base_url();?>it/edit_system_it",
                data: {
                       name_system     : name_system,
                       id_name_systems : id_name_systems
                },
                success: function(data) {
                    console.log(data);
                    window.location = "<?=base_url();?>it/systems_it";
                }
            })
        }
    }

</script>