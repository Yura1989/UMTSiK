const name = 'Yura';
const age = 382;
let n = 111;
console.log(age);
console.log('Имя человек: ' + name + ' age: ' + age);
console.log(age)
// const sername = prompt('Enter sername?');
// console.log('Имя человек: ' + name + ' age: ' + age + ' sername ' + sername);


function createUUID() {
    var s = [];
    var hexDigits = "0123456789ABCDEF";
    for (var i = 0; i < 32; i++) {
        s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1);
    }
    s[12] = "4";  // bits 12-15 of the time_hi_and_version field to 0010
    s[16] = hexDigits.substr((s[16] & 0x3) | 0x8, 1);  // bits 6-7 of the clock_seq_hi_and_reserved to 01

    var uuid = s.join("");
    return uuid;
}
function hello ()
{
    var n = createUUID();
    console.log(n);
    console.log("hello");
}

hello();

const isProgrammer = true
const name2 = 'Yura'
console.log(typeof isProgrammer)

const courseStatus = 'ready'

if (courseStatus === 'ready'){
    console.log('True')
}else if (courseStatus === 'fail'){
    console.log('False')
}else {
    console.log('Fail')
}

if (courseStatus) {
    console.log('Boolean')
} else {
    console.log('noBoolean')
}
courseStatus ? console.log('boolean') : console.log('hal')

function calculateAge (year){
    return 2020-year
}

const myAge = calculateAge(1989)
console.log(myAge)

function infoPeople(name, year){
    const age = calculateAge (year)
    console.log('name= '+ name +' Year = ' + age)
}

infoPeople('Yura',1987);

const cars = ['Masda', 'Porsche', 'Audi']

console.log(cars)

for (let i = 0; i < cars.length; i++){
    console.log(i)
    const car = cars[i]
    console.log(car)
}

for (let car of cars){
    console.log(car)
}

const person = {
    firstName : 'Yura',
    lastName : 'Dudin',
    year : 1989,
    language : ['Russia', 'England'],
    hasWife : true,
    greet : function(){
        console.log('greet from person')
    }
}

console.log(person)
console.log(person.firstName)
console.log(person['lastName'])
person.greet()
person.isProgrammer = true



























































