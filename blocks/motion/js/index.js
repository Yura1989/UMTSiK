
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

function addRowTable(e) {
    // console.log('e', e);
    console.log('data-id', e.target.dataset.id);
    // console.log('className', e.target.classList);
    const idRow = e.target.dataset.id;
    const te = '<span class="table__span">Ширина, м</span><input class="table__input"></input>'
    const scr = document.querySelector(`.${idRow}`);
    console.log('scr', scr);
    scr.insertAdjacentHTML('afterbegin', '<td>\n' +
        '                            <div class="table__dimensions">\n' +
        '                                <div class="table__options">\n' +
        '                                    <span class="table__span">Длина, м</span>\n' +
        '                                    <input class="table__input"></input>\n' +
        '                                </div>\n' +
        '                                <div class="table__options">\n' +
        '                                    <span class="table__span">Ширина, м</span>\n' +
        '                                    <input class="table__input"></input>\n' +
        '                                </div>\n' +
        '                                <div class="table__options">\n' +
        '                                    <span class="table__span">Высота, м</span>\n' +
        '                                    <input class="table__input"></input>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                        </td>\n' +
        '                        <td><input class="table__input"></input></td>\n' +
        '                        <td><input class="table__input"></input></td>')

}

document.querySelector('.header__button_info_mtr').addEventListener('click', openAccordionInfoMtr);
document.querySelector('.header__button_info_enter_mtr').addEventListener('click', openAccordionInfoEnterMtr);

const buttonAddRow = document.querySelectorAll('.table__button_add_row');
buttonAddRow.forEach(item => {
    item.addEventListener('click',  addRowTable);
});

