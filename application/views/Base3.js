const cars = ['Mazda', 'BMW', 'AUDI', 'Mers']
const fib = [1,1,2,3,5,8,13]


cars.push('Renault')
console.log(cars)

const text = 'Hello, we laening JS'
const reverseText = text.split('').reverse().join('')
console.log(reverseText)

const people = [
    {name: 'Yura', budget: 5000},
    {name: 'Anna', budget:4000},
    {name: 'Asa', budget: 1000}
]

// console.log(people)
// let finderPerson
// for (const person of people){
//     console.log(person)
//     if (person.budget=== 5000){
//         finderPerson = person
//     }
// }
// console.log(finderPerson)
//
// const person2 = people.find(function(person2) {
//     return person2.budget === 1000
// })
// console.log(person2)
//
// console.log (t = cars.includes('Mazda'))
//
// const upperCaseCars =cars.map(car => {
//     return car.toUpperCase()
// })
// console.log(upperCaseCars)
//
// const sqrtFib = fib.map(num => {
//     return num ** 2
// })
// console.log(sqrtFib)
//
// const pow2 = num => num ** 2
// const pow2Fib = fib.map(pow2)
// const filteredNumbers = pow2Fib.filter( num => num > 20)
//
// console.log(pow2Fib)
// console.log(filteredNumbers)

const sumBudget = people
    .filter(person => person.budget > 2000)
    .reduce((acc, person) => {
        acc += person.budget
        return acc
}, 0)
console.log(sumBudget)




