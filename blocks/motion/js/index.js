
function openAccordion(selector, selectorButton) {
  const accordion = document.querySelector(`.${selector}`);
  const accordionButton = document.querySelector(`.${selectorButton}`);
  accordion.classList.toggle('header__accordion_visible');
  accordionButton.classList.toggle('header__button_active');
}

function openAccordionInfoMtr() {
  openAccordion('header__accordion_info_mtr', 'header__button_info_mtr');

}

function openAccordionInfoEnterMtr() {
  openAccordion('header__accordion_info_enter_mtr', 'header__button_info_enter_mtr');
}

function checkboxAll(e) {
  const allCheckboxRow = document.querySelectorAll('.table__checkbox-row');
  if (e.target.checked) {
    allCheckboxRow.forEach(item => {
      item.checked = true;
    });
  } else {
    allCheckboxRow.forEach(item => {
      item.checked = false;
    });
  }
}

function addRowTable(e) {
  // console.log('e', e);
  console.log('data-id', e.target.dataset.id);

  const idRow = e.target.dataset.id;
  const rowData = document.querySelector(`.row_${idRow}`);
  const columnData = document.querySelector(`.column_${idRow}`);
  // console.log('columnData', columnData.rowSpan);
  let rowSpan = columnData.rowSpan;
  // columnData.rowSpan = rowSpan+1;
  rowData.insertAdjacentHTML('afterend', `<tr class="row_e1e1e1e1e1e1">
    <td colspan="9">
      <fieldset class="table__fieldset">
        <legend class="table__fieldset-add-row">Информация по МТР</legend>
        <fieldset>
          <legend>Массогобаритные характеристики</legend>
          <div class="table__dimensions">
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Длина, м</span>
            </div>
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Ширина, м</span>
            </div>
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Высота, м</span>
            </div>
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Вес одной единицы</span>
            </div>
          </div>
        </fieldset>
        <fieldset class="table__fieldset-group table__fieldset-group_grid">
          <legend>Дополнительная информация</legend>
          <div class="table__group">
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Дата заявки на отгрузку</span>
            </div>
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Заявка на контейнер/автотранспорт</span>
            </div>
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Дата отгрузки</span>
            </div>
          </div>
          <div class="table__group">
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Груз сформирован в контейнер/автотранспорт</span>
            </div>
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Отгружено</span>
            </div>
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Остаток</span>
            </div>
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Наименование транзитного* или конечного получателя груза</span>
            </div>
          </div>
        </fieldset>
        <fieldset class="table__fieldset-group">
          <legend>Накладная формы М11</legend>
          <div class="table__dimensions">
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Дата</span>
            </div>
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">Номер</span>
            </div>
          </div>
        </fieldset>
        <fieldset class="table__fieldset-group">
          <legend>Примечание</legend>
          <div class="table__dimensions">
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">по доставке</span>
            </div>
            <div class="table__options">
              <input class="table__input"></input>
              <span class="table__span">общие примечания</span>
            </div>
          </div>
        </fieldset>
      </fieldset>
      <button type="button" data-id="e1e1e1e1e1e1" name="table_add_row" class="table__button-add table__button_add_row">+ добавить</button>
    </td>
  </tr>`);
}

document.querySelector('.header__button_info_mtr').addEventListener('click', openAccordionInfoMtr);
document.querySelector('.header__button_info_enter_mtr').addEventListener('click', openAccordionInfoEnterMtr);
document.querySelector('.table__button-checkbox-all').addEventListener('click', checkboxAll);

const buttonAddRow = document.querySelectorAll('.table__button_add_row');
buttonAddRow.forEach(item => {
  item.addEventListener('click', addRowTable);
});

