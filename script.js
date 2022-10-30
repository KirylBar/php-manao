const signInBtn = document.querySelector('.signin-btn')
const signUpBtn = document.querySelector('.signup-btn')
const formBox = document.querySelector('.form-box')
const body = document.querySelector('body')
const formSignIn = document.querySelector('.form_signin')
const formSignInError = document.querySelector('.login-error')
const formSignUp = document.querySelector('.form_signup')
const inputs = formSignUp.querySelectorAll('input')
const spans = formSignUp.querySelectorAll('span')
const successField = document.querySelector('.user-created')
const fieldLogin = formSignUp.querySelector('[name="login"]')
const fieldName = formSignUp.querySelector('[name="name"]')
const fieldEmail = formSignUp.querySelector('[name="email"]')
const fieldPassword = formSignUp.querySelector('[name="password"]')
const fieldConfirmPassword = formSignUp.querySelector(
  '[name="password_confirm"]'
)
const errorFieldLogin = document.querySelector('.signup__login-error')
const errorFieldName = document.querySelector('.signup__name-error')
const errorFieldEmail = document.querySelector('.signup__email-error')
const errorFieldPassword = document.querySelector('.signup__password-error')
const errorFieldConfirmPassword = document.querySelector(
  '.signup__passwordConfirm-error'
)

signUpBtn.addEventListener('click', () => {
  formBox.classList.add('active')
  body.classList.add('active')
})

signInBtn.addEventListener('click', () => {
  formBox.classList.remove('active')
  body.classList.remove('active')
})

// Шаблон запроса

async function postData(url, data) {
  const result = await fetch(url, {
    method: 'POST',
    body: data,
  })

  return await result.json()
}

// Вспомогательные функции

function clearSpans() {
  spans.forEach((el) => {
    el.textContent = ''
  })
}

function clearInputs() {
  inputs.forEach((el) => {
    el.value = ''
    el.classList.contains('error') ? el.classList.remove('error') : false
    el.classList.contains('success') ? el.classList.remove('success') : false
  })
}

// Форма регистрации

formSignUp.addEventListener('submit', (e) => {
  e.preventDefault()

  const formData = new FormData(formSignUp)
  postData('register.php', formData).then((result) => {
    clearSpans()
    message(result)
  })
})

// Форма входа

formSignIn.addEventListener('submit', (e) => {
  e.preventDefault()

  const formData = new FormData(formSignIn)
  postData('login.php', formData).then((result) => {
    result.error === 'error'
      ? (formSignInError.textContent = 'Не верный пользователь или пароль')
      : location.reload()
  })
})

// Валидация

function message(obj) {
  const createError = (span, errorField, errorText) => {
    if (errorText) {
      errorField.textContent = errorText
      span.classList.add('error')
    } else {
      span.classList.contains('error')
        ? span.classList.replace('error', 'success')
        : span.classList.add('success')
    }
  }

  if (obj === 'success') {
    clearInputs()
    successField.textContent = 'Пользователь создан!'
  } else {
    successField.textContent = ''
    createError(fieldLogin, errorFieldLogin, obj.login)
    createError(fieldName, errorFieldName, obj.name)
    createError(fieldEmail, errorFieldEmail, obj.email)
    createError(fieldPassword, errorFieldPassword, obj.password)
    createError(
      fieldConfirmPassword,
      errorFieldConfirmPassword,
      obj.equalPasswords
    )
  }
}
