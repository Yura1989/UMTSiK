// window.alert("What your the name?")
const heading = document.getElementById('hello')
// const heading2 = document.getElementsByTagName('h2')[0]
// const heading2 = document.getElementsByClassName('h2-class')[0]
// const heading2 = document.querySelector('h2')
// const heading2 = document.querySelector('.h2-class')
const heading2 = document.querySelector('#id-h2') //всегда первый элемент
// const heading3 = heading2.nextElementSibling
const h2list = document.querySelectorAll('h2')
console.log(heading2)
const heading3 = h2list[1]
// const heading3 = h2list[h2list.length-1]
console.log(heading3)


setTimeout( () => {
    addStylesTo(heading, 'JavaScript', 'black')
}, 1500)

setTimeout( () => {
    addStylesTo(heading2, 'Hello world', 'yellow', '2rem')
}, 2500)

const link = heading3.querySelector('a')
link.addEventListener('click', () => {
    event.preventDefault()
    console.log('click', event.target.getAttribute('href'))
    const url = event.target.getAttribute('href')
    window.location = url
})

setTimeout( () => {
    addStylesTo(link, 'NICE')
}, 3500)

function addStylesTo (node, text, color = 'red', fontSize) {
    node.textContent = text
    node.style.textAlign = 'center'
    node.style.color = color
    node.style.backgroundColor = 'blue'
    node.style.display = 'block'
    node.style.width = '100%'
    if (fontSize) {
        node.style.fontSize = fontSize
    }
}

heading.onclick = () => {
    if (heading.style.color === 'red'){
        heading.style.color = '#000'
        heading.style.backgroundColor = '#fff'
    } else {
        heading.style.color = 'red'
        heading.style.backgroundColor = '#000'
    }
}

heading2.addEventListener('dblclick', () => {
    if (heading2.style.color === 'red'){
    heading2.style.color = '#000'
    heading2.style.backgroundColor = '#fff'
} else {
    heading2.style.color = 'red'
    heading2.style.backgroundColor = '#000'
}
})

