<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Settings</title>

    <script src="<?=base_url();?>assets/order/jquery-3.3.1.js" type="text/javascript"></script>
    <script src="<?=base_url();?>assets/order/datepicker4/js/gijgo.min.js" type="text/javascript"></script>
    <script src="<?=base_url();?>assets/order/datepicker4/js/messages/messages.ru-ru.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/order/datepicker4/css/gijgo.min.css" />

    <!--    url links for datepickers-->
    <!--    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>-->
    <!--    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />-->
    <!--    <script src="https://unpkg.com/gijgo@1.9.13/js/messages/messages.ru-ru.js" type="text/javascript"></script>-->
</head>

<body>
    <h1>Настройки</h1>
    <h2>Параметры даты</h2>
    <div>
        <input class="datepicker_rows" width="300" />
        <input class="datepicker_rows" width="300" />
        <input class="datepicker_rows" width="300" />
        <input class="datepicker_rows" width="300" />
    </div>

    <input id="datepicker" width="276" />

        <script>
        $(document).ready(function() {
            date_row();
            date_rows();
        });

        function date_row() {
            $('#datepicker').datepicker();
        }

        function date_rows() {
            $('.datepicker_rows').each(function(){
                $(this).datepicker({
                    locale: 'ru-ru',
                    format: 'dd-mm-yyyy'
                });
            });
        }
    </script>
</body>
</html>
