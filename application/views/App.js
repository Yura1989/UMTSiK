// const person = {
// 	name: 'Maxim',
// 	age: 24,
// 	greet: function(){
// 		console.log('Greet!')
// 	}
// }

// const person = new Object({
// 	name: 'Maxim',
// 	age: 25,
// 	greet: function(){
// 		console.log('Greet!');
// 	}
// })
//
// Object.prototype.sayHello = function () {
// 	console.log('Hello')
// }
//
// const lena = Object.create(person)
// lena.name = 'Elena'
//
// const str = new String ('I am string')


function Hello (){
	console.log('Hello', this)
}

const person = {
	name:'Yura',
	age: 32,
	sayHello: Hello,
	sayHelloWindow: Hello.bind(document),
	logInfo: function (job, phone) {
		console.group(`${this.name} info:`)
		console.log(`Name is ${this.name}`)
		console.log(`Age is ${this.age}`)
		console.log(`Job is ${job}`)
		console.log(`Phone is ${phone}`)
		console.groupEnd()
	}
}

const lena = {
	name: 'Lena',
	age: 28
}

// const fnLenaInfoLog = person.logInfo.bind(lena, 'frontend', '8-999...')
// fnLenaInfoLog()
person.logInfo.bind(lena, 'frontend', '8-999...')()
// person.logInfo.call(lena, 'frontend', '8-999...')
// person.logInfo.apply(lena, ['frontend', '8-999...'])

//Example

const array = [1, 2, 3, 4, 5]

// function multBy(arr, n){
// 	return arr.map(function (i) {
// 		return i*n
// 	})
// }

// console.log(multBy(array, 5))


Array.prototype.multBy = function (n) {
		return this.map(function (i) {
		return i*n
	})
}

console.log(array.multBy(5));

// function createCalcFunction (n){
// 	return function (){
// 		console.log(1000*n)
// 	}
// }
//
// const calc = createCalcFunction(42);
// console.log(calc)
// calc()

// function createIncrementor(n) {
// 	return function (num){
// 		return n + num
// 	}
// }
// const addOne = createIncrementor(1)
// const addTen = createIncrementor(10)
//
// console.log(addOne(10))
// console.log(addOne(41))
//
// console.log(addTen(10))
// console.log(addTen(41))

// function urlGeberator (domain) {
// 	return function (url) {
// 		return `https://${url}.${domain}`
// 	}
// }
//
// const comUrl = urlGeberator('com')
// const ruUrl = urlGeberator('ru')
//
// console.log(comUrl('google'))
// console.log(comUrl('netflix'))
// console.log(ruUrl('yandex'))

function bind (contex, fn) {
	return function (...args) {
		fn.apply(contex, args)
	}
}

function logPerson () {
	console.log(`Person ${this.name}, age: ${this.age}, job: ${this.job}`)
}

const person1 = {
	name: 'Михаил',
	age: '22',
	job: 'Frontend'
}

const person2 = {
	name: 'Елена',
	age: '19',
	job: 'SMM'
}

bind (person1, logPerson)(
