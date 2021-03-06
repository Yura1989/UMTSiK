<section role="main" class="content-body">
    <header class="page-header">
        <h2>Реестр центровозов МТР</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Отчеты</span></li>
                <li><span>Реестр</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>
            </div>
            <h2 class="panel-title">Реестр центровозов МТР</h2>
        </header>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-md">
                        <button id="addToTable" class="btn btn-primary">Добавить <i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped mb-none" id="datatable-details">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Код МТР</th>
                        <th>Наименование</th>
                        <th>Ук.объект КР, либо ук. ПЭН.</th>
                        <th>Ед.изм.</th>
                        <th>Кол-во</th>
                        <th>Филиал</th>
                        <th>Режим доставки МТР, условия транспортировки **</th>
                        <th>Примечание</th>
                        <th>Операция</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="gradeX">
                         <td>Trident</td>
                        <td>Internet Explorer 4.0 </td>
                        <td>Win 95+</td>
                        <td>Win 95+</td>
                        <td>Win 95+</td>
                        <td>Win 95+</td>
                        <td>Win 95+</td>
                        <td>Win 95+</td>
                        <td>Win 95+</td>
                        <td class="actions">
                            <a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>
                            <a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
                            <a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                            <a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</section>
    <!-- end: page -->
<script src="<?=base_url();?>assets/javascripts/tables/examples.datatables.editable.js"></script>