const name = 'Yura';
const age = 382;
let n = 111;
let pow = 10e3
console.log(n)

console.log(Math.pow(2, 53)-1)
console.log(Number.MIN_SAFE_INTEGER)

const stringFloat = '42.42'
console.log(Number.parseInt(stringFloat) + 2)
console.log(parseFloat((0.4+0.2).toFixed(1)))

console.log(Math.pow(5, 4));
console.log(Math.max(34, 43,5,2,12,564))
console.log(Math.round(3.7))

function getRandomBetween(min,max){
    return Math.floor(Math.random() * (max - min + 1) + min)
}

console.log(getRandomBetween(12, 326))

const output = `Hello, my name is ${name} and my ${age}`
console.log(output);

//function Declaration
function yourname(name){
    console.log("Your nama = "+name);
}

yourname('Yura5');

//function Expression
const yourname2 = function yourname2(name){
    console.log('YOur nama = '+ name)
}

yourname2("Anna");

console.dir(yourname2)

let counter = 0
//Анонимные функции
const interval = setInterval(function () {
    if (counter === 5){
        clearInterval(interval)
    } else{
        console.log(++counter)
    }
}, 1000)

// Стрелочные функции
const arrow = (name) => {
    console.log("Hello - ", name)
}
arrow("Yuranchik")

const summ = (a = 40, b =9) => a+b
console.log(summ())

function sumAll(...all){
    let result = 0
    for (let num of all){
        result += num
    }
    return result
}

const res = sumAll(1,3,4,5)
console.log(res)


























