// import $ from '../../../assets/order/jquery-3.3.1';

function consoleTest(e) {
  e.preventDefault();
  console.log("API");
  checkingOfError('.table__input_error_otgrugeno', '.table__span_error_otgrugeno', handleError);
}

function handleError (checkingValue) {
  const newTweetContainer = document.createElement('div');
  newTweetContainer.textContent = checkingValue;
  document.body.append(newTweetContainer);
}

function checkingOfError (checkingValue, containerSelector, callback) {
  const inputOtgrugenoValue = document.querySelector(checkingValue);
  const spanErrorOtgrugeno = document.querySelectorAll(containerSelector);
  console.log('inputOtgrugenoValue =', inputOtgrugenoValue);

  if(inputOtgrugenoValue == null) {
    callback(checkingValue);
    return;
  }

  spanErrorOtgrugeno.textContent = checkingValue;

  console.log('inputOtgrugenoValue =', inputOtgrugenoValue.value);
  console.log('spanErrorOtgrugeno', spanErrorOtgrugeno);
}

const getSelectedMTR = (e) => {
  e.preventDefault();
  const selectedMTR = document.querySelectorAll('.table__checkbox-row');
  const array_selectedMTR = [];
  selectedMTR.forEach(item => {
    if(item.checked == true) {
      array_selectedMTR.push(item.dataset.id_order);
    }
  })
  console.log("array_selectedMTRr= ", array_selectedMTR);
  API(array_selectedMTR);
}

const myApi = async (array_selectedMTR) => {
  console.log("array_selectedMTR", array_selectedMTR);
  let form = document.querySelector("#user-form"); //собираем всю инфу с полей ввода.
  let data = new FormData(form);
  data.append('array_selectedMTR', array_selectedMTR);

  const response = await fetch('/mtr/Main/setValueServer', {
    method: 'POST',
    body: data
  });
  if (!response.ok) {
    throw new Error(`Ошибка по адресу ${url}, статус ошибки ${response.status}`);
  }
  return await response.text();
}

function API(array_selectedMTR) {
  myApi(array_selectedMTR)
    .then((response) => {
      console.log(response);
  })
    .catch((err) => console.error(err))
}

document.getElementById('setValueApi').addEventListener('click', getSelectedMTR);
// document.querySelector('.API_button').addEventListener('click', ajaxApi);
