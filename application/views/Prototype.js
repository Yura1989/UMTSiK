// const Animal = function (options) {
// 	this.name = options.name
// 	this.color = options.color
//
// 	// this.voice = function (){
// 	// 	console.log('Base voice from', this.name)
// 	// }
// }
//
// Animal.prototype.voice = function () {
// 	console.log('Base voice from', this.name)
// }
//
// // console.log(Animal.prototype);
//
// const dog = new Animal ({name: 'Rex', color: '#fff'})
//
// // const dog = {name: 'Rex', color: '#fff'}
// // dog.voice()
//
// // console.log(dog)
//
// const Cat = function(options) {
// 	Animal.apply(this, arguments)
// 	this.hasTail = options.hasTail
// 	this.type = 'cat'
// }
//
// Cat.prototype = Object.create(Animal.prototype)
// Cat.prototype.constructor = Cat
//
// Animal.prototype.voice = function () {
// 	console.log('This sound goes from', this.name)
// }
//
// Cat.prototype.voice = function (){
// 	Animal.prototype.voice.apply(this, arguments)
// 	console.log(this.name + ' says myay')
// }
//
// const cat = new Cat({name: 'Aca', color: '#000', hasTail: true})
// console.log(cat)

// class Animal {
// 	constructor(options) {
// 		this.name = options.name
// 		this.color = options.color
// 	}
//
// 	vioce() {
// 		console.log('Base voice from ', this.name)
// 	}
// }
//
// const dog = new Animal({name : 'Rex', color : '#fff'})
//
// class Cat extends Animal {
// 	constructor(options) {
// 		super(options)
//
// 		this.hasTail = options.hasTail
// 		this.type = 'cat'
// 	}
//
// 	voice() {
// 		super.vioce()
// 		console.log(this.name + 'says maya')
// 	}
//
// }
//
// const cat = new Cat({name : 'Asaya', color : '#000', hasTail : true})
//
// //Examples
//  Object.prototype.print = function () {
// 	console.log('I am object ', this)
//  }
//
// cat.print()
//
// Array.prototype.myMapAndLog = function (){
// 	console.log('Arrya this log: ', this)
// 	return this.map.apply(this, arguments)
// }
//
// console.log([1, 2, 3, 4].myMapAndLog(x => x ** 2))
//
// String.prototype.toTag = function (tagName) {
// 	return `<${tagName}>${this}</${tagName}>`
// }
//
// console.log('Eminem'.toTag('strong'))
//
// Number.prototype.toBigInt = function (){
// 	return BigInt(this)
// }
//
// const number = 42
// console.log(number.toBigInt())























