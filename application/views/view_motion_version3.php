<!doctype html>
<html lang="ru">
<head>
    <title>МТР</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?=base_url();?>assets/order/favicon.png" type="image/png">
    <link rel="stylesheet" href="<?=base_url();?>blocks/motion/style/index.css">
</head>
<body class="main_yura">
    <header class="header">
        <nav>
            <ul class="header__menu">
                <li>
                    <button type="button" name="info_mtr" class="header__button header__button_info_mtr">Информация о движении МТР на базе</button>
                </li>
                <li>
                    <button type="button" name="info_enter_mtr" class="header__button header__button_info_enter_mtr">Множественная вставка значений</button>
                </li>
            </ul>
        </nav>
        <h2 class="header__text">Приложение № 3</h2>
    </header>

    <div id="info_mtr" class="header__accordion header__accordion_info_mtr header__accordion_visible">
        <p class="header__title">Text text text info_mtr</p>
    </div>

    <div id="info_enter_mtr" class="header__accordion header__accordion_info_enter_mtr header__accordion_visible">
        <p class="header__title">Text text text info_enter_mtr</p>
    </div>

    <section class="info">
        <div class="">
            <table id="createMotion" class="table">
                <thead>
                    <tr>
                        <th># п/п</th>
                        <th>МТР</th>
                        <th>Количество/ед.изм</th>
                        <th>Объект</th>
                        <th>Массогобаритные характеристики***</th>
                        <th>Заявка на контейнер/автотранспорт</th>
                        <th>Операции</th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <tr class="e1e1e1e1e1e1">
                        <td>1</td>
                        <td>
                            <div class="table__dimensions">
                                <div class="table__options">
                                    <span class="table__span">Наименование:</span>
                                    <p class="table__text">труба № 2</p>
                                </div>
                                <div class="table__options">
                                    <span class="table__span">Код:</span>
                                    <p class="table__text">32</p>
                                </div>
                                <div class="table__options">
                                    <span class="table__span">Номер партии:</span>
                                    <p class="table__text">232</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="table__dimensions">
                                <div class="table__options">
                                    <span class="table__span">Ед. изм.:</span>
                                    <p>метр</p>
                                </div>
                                <div class="table__options">
                                    <span class="table__span">Количество:</span>
                                    <p>32</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="table__dimensions">
                                <div class="table__options">
                                    <span class="table__span">Филиал:</span>
                                    <p>Краснотуринское ЛПУМГ</p>
                                </div>
                                <div class="table__options">
                                    <span class="table__span">Объект:</span>
                                    <p>ПЭН</p>
                                </div>
                                <div class="table__options">
                                    <span class="table__span">Инвентарный номер объекта:</span>
                                    <p>23</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="table__dimensions">
                                <div class="table__options">
                                    <span class="table__span">Длина, м</span>
                                    <input class="table__input"></input>
                                </div>
                                <div class="table__options">
                                    <span class="table__span">Ширина, м</span>
                                    <input class="table__input"></input>
                                </div>
                                <div class="table__options">
                                    <span class="table__span">Высота, м</span>
                                    <input class="table__input"></input>
                                </div>
                            </div>
                        </td>
                        <td><input class="table__input"></input></td>
                        <td><input class="table__input"></input></td>
                        <td>
                            <button type="button" data-id="e1e1e1e1e1e1" name="table_add_row" class="table__button table__button_add_row">+</button>
                            <button>Удалить</button>
                        </td>
                    </tr>



                </tbody>
                <tfoot>
                    <td colspan="2">footer-3</td>
                    <td>footer-3</td>
                </tfoot>
            </table>
        </div>
    </section>

    <footer>

    </footer>
<script src="<?=base_url();?>blocks/motion/js/index.js"></script>
</body>
</html>