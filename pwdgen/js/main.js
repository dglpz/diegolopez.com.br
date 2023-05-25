// DOM element
const clipboard = document.querySelector('#clipboard')
const password = document.querySelector('#result')
const passLength = document.querySelector('#length')
const range = document.querySelector('#range');
const lowercaseLetter = document.querySelector('#lowercase')
const uppercaseLetter = document.querySelector('#uppercase')
const number = document.querySelector('#numbers')
const symbol = document.querySelector('#symbols')
const generateButton = document.querySelector('#generate')

// range and number 
range.addEventListener('input', rangeAndNumber)
passLength.addEventListener('input', rangeAndNumber)
function rangeAndNumber(e) {
    const value = e.target.value
    range.value = value
    passLength.value = value
}
//generator function
const getLowerLetter = () => String.fromCharCode(Math.floor(Math.random() * 26) + 97)
const getUpperLetter = () => String.fromCharCode(Math.floor(Math.random() * 26) + 65)
const getNumber = () => String.fromCharCode(Math.floor(Math.random() * 10) + 48)
const getSymbol = () => {
    const symbol = '!.,?<=>&*%$#@)({}[]/~^*';
    return symbol[Math.floor(Math.random() * symbol.length)]
}

const randomFunc = {
    lower: getLowerLetter,
    upper: getUpperLetter,
    number: getNumber,
    symbol: getSymbol
}

generateButton.addEventListener('click', () => {
    const passLen = +passLength.value
    const isUpper = uppercaseLetter.checked
    const isLower = lowercaseLetter.checked
    const isNumber = number.checked
    const isSymbol = symbol.checked
    password.innerText = generatePassword(passLen, isUpper, isLower, isNumber, isSymbol)

});
// generate password
function generatePassword(passLen, upper, lower, number, symbol) {
    let randomPass = ''
    let checkedCount = upper + lower + number + symbol

    let checkedArr = [{ upper }, { lower }, { number }, { symbol }].filter(v => Object.values(v)[0])

    if (checkedCount === 0) {
        return ''
    }
    for (let i = 0; i < passLen; i += checkedCount) {
        checkedArr.forEach(value => {
            const funcName = Object.keys(value)[0]
            randomPass += randomFunc[funcName]()
        })
    }
    return randomPass.slice(0,passLen)
}

// copy to clipboard

clipboard.addEventListener('click', ()=>{
    const textarea=document.createElement('textarea')
    const pass=password.innerText
    if(!pass){
        return;
    }
    textarea.value=pass
    document.body.appendChild(textarea)
    textarea.select()
    document.execCommand('copy')
    textarea.remove()
    alert('Password copied! :)')
})


