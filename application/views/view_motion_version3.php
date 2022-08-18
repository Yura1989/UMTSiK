<!doctype html>
<html lang="ru">

<head>
  <title>МТР</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/order/favicon.png" type="image/png">
  <link rel="stylesheet" href="<?= base_url(); ?>blocks/motion/style/index.css">
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
    <table id="createMotion" class="table">
      <thead class="sticky">
        <tr class="table__header">
          <th># п/п</th>
          <th>Код МТР</th>
          <th>Номер партии</th>
          <th>Наименование МТР</th>
          <th>Объект</th>
          <th>Инвентарный номер объекта</th>
          <th>Единицы измерений</th>
          <th>Количество</th>
          <th>Филиал</th>
        </tr>
        <tr class="table__header">
          <th>1 <input type="checkbox" class="table__button-checkbox-all"></th>
          <th>2</th>
          <th>3</th>
          <th>4</th>
          <th>5</th>
          <th>6</th>
          <th>7</th>
          <th>8</th>
          <th>9</th>
        </tr>
      </thead>
      <tbody class="tbody">
        <?php $n = 0;
        $accordion_flag = 0;
        foreach ($orders as $item) : ?>
          <tr class="table__row">
            <td class="column_checkbox">
              <span class="table__span-number-row"><?php if (isset($item['codeMTR'])) echo ($n + 1); ?></span>
              <input type="checkbox" data-id_order="<?php if (isset($item['id_order'])) echo ($item['id_order']); ?>" class="table__checkbox-row">
            </td>
            <td><?php if (isset($item['codeMTR'])) echo ($item['codeMTR']); ?></td>
            <td><?php if (isset($item['numberPart'])) echo ($item['numberPart']); ?></td>
            <td><?php if (isset($item['nameMTR'])) echo ($item['nameMTR']); ?></td>
            <td><?php if (isset($item['ukObjectMTR'])) echo ($item['ukObjectMTR']); ?></td>
            <td><?php if (isset($item['numberObjectMTR'])) echo ($item['numberObjectMTR']); ?></td>
            <td><?php if (isset($item['sizeMTR'])) echo ($item['sizeMTR']); ?></td>
            <td><?php if (isset($item['sumMTR'])) echo ($item['sumMTR']); ?></td>
            <td><?php if (isset($item['filialMTR'])) echo ($item['filialMTR']); ?></td>
          </tr>

        <?php
          $n = $n + 1;
          $accordion_flag = $accordion_flag + 1;
        endforeach;
        ?>
      </tbody>
      <tfoot class="table__row">
        <td></td>
        <td>footer-3</td>
      </tfoot>
    </table>
  </section>

  <form method="POST" id="user-form">
  <div class="row__checked">
    <fieldset class="table__fieldset">
      <legend class="table__fieldset-add-row">Информация по МТР</legend>
      <fieldset class="table__fieldset-border-radius">
        <legend>Массогабаритные характеристики</legend>
        <div class="table__dimensions">
          <div class="table__options">
            <input type="text" name="length_motion" class="table__input" value=""></input>
            <span class="table__span">Длина, м</span>
          </div>
          <div class="table__options">
            <input type="text" name="width_motion" class="table__input"></input>
            <span class="table__span">Ширина, м</span>
          </div>
          <div class="table__options">
            <input type="text" name="height_motion" class="table__input"></input>
            <span class="table__span">Высота, м</span>
          </div>
          <div class="table__options">
            <input type="text" name="weight_motion" class="table__input"></input>
            <span class="table__span">Вес одной единицы</span>
          </div>
        </div>
      </fieldset>
      <fieldset class="table__fieldset-group table__fieldset-group_grid">
        <legend>Дополнительная информация</legend>
        <div class="table__group">
          <div class="table__options">
            <input type="date" name="dateRequest_motion" class="table__input"></input>
            <span class="table__span">Дата заявки на отгрузку</span>
          </div>
          <div class="table__options">
            <input type="text" name="infoShipments_motion" class="table__input"></input>
            <span class="table__span">Заявка на контейнер/автотранспорт</span>
          </div>
          <div class="table__options">
            <input type="date" name="dateShipments_motion" class="table__input"></input>
            <span class="table__span">Дата отгрузки</span>
          </div>
        </div>
        <div class="table__group">
          <div class="table__options">
            <input type="text" name="cargo_motion" class="table__input"></input>
            <span class="table__span">Груз сформирован в контейнер/автотранспорт</span>
          </div>
          <div class="table__options">
            <input type="text" name="height_motion" class="table__input table__input_error_otgrugeno"></input>
            <span class="table__span table__span_error_otgrugeno">Отгружено</span>
          </div>
          <div class="table__options">
            <input type="text" disabled name="shipped_motion" class="table__input"></input>
            <span class="table__span">Остаток</span>
          </div>
          <div class="table__options">
            <input type="text" name="tranzit_motion" class="table__input"></input>
            <span class="table__span">Наименование транзитного* или конечного получателя груза</span>
          </div>
        </div>
      </fieldset>
      <fieldset class="table__fieldset-group">
        <legend>Накладная формы М11</legend>
        <div class="table__dimensions">
          <div class="table__options">
            <input type="date" name="dateOverhead_motion" class="table__input"></input>
            <span class="table__span">Дата</span>
          </div>
          <div class="table__options">
            <input type="text" name="numberOverhead_motion" class="table__input"></input>
            <span class="table__span">Номер</span>
          </div>
        </div>
      </fieldset>
      <fieldset class="table__fieldset-group">
        <legend>Примечание</legend>
        <div class="table__dimensions">
          <div class="table__options">
            <input type="text" name="note_motion" class="table__input"></input>
            <span class="table__span">по доставке</span>
          </div>
          <div class="table__options">
            <input type="text" name="general_notes_motion" class="table__input"></input>
            <span class="table__span">общие примечания</span>
          </div>
        </div>
      </fieldset>
    </fieldset>
    <button type="submit" id="setValueApi" name="table_save" class="table__button table__button_save table__button_save_row_API">сохранить</button>
    </form>
    <button type="button" data-id="api_button" name="api" class="table__button API_button">Сделать запрос API</button>
  </div>



  <footer>
        <?php print_r($_SESSION); ?>
  </footer>

  <!-- <script src="<?=base_url();?>assets/order/jquery-3.3.1.js" type="text/javascript"></script> -->
  <script src="<?=base_url(); ?>blocks/motion/js/index.js"></script>
  <script src="<?=base_url(); ?>blocks/motion/js/api.js"></script>

</body>
</html>
