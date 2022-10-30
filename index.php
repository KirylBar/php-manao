<? require_once('logout.php') ?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./style.css" />
    <script defer src="./script.js"></script>
    <title>Document</title>
  </head>
  <body>

  <?php if($_SESSION['user_logged'] == true || $_COOKIE['user_logged'] == 1 ) : ?>
    <article class="container">
      <div class="block">
        <form class="form_logout" action="" method="post">
          <input type="hidden" name="logout" value="logout">
          <span class="form_logout-span">Добро пожаловать <?php echo $_SESSION['username'] ?: $_COOKIE['username'] ?> </span>
          <button class="form_logout-btn form__btn" type="submit">Выход</button>
        </form>
      </div>  
    </article>

  <?php else : ?>
    <article class="container">
      <div class="block">
        <section class="block__item block-item">
          <h2 class="block-item__title">У вас уже есть аккаунт?</h2>
          <button class="block-item__btn signin-btn">Войти</button>
        </section>
        <section class="block__item block-item">
          <h2 class="block-item__title">У вас нет аккаунта?</h2>
          <button class="block-item__btn signup-btn">Зарегистрироваться</button>
        </section>
      </div>
      <div class="form-box">
        <!-- Форма входа -->

        <form action="#" class="form form_signin">
          <h3 class="form__title">Вход</h3>
          <div class="input_container">
            <input
              type="text"
              class="form__input"
              placeholder="Логин"
              name="login"
            />
          </div>
          <div class="input_container">
            <input
              type="password"
              class="form__input"
              placeholder="Пароль"
              name="password"
            />
          </div>
          <div class="input_container">
            <span class="login-error"></span>
            <button class="form__btn form__btn_signin">Войти</button>
          </div>
        </form>

        <!-- Форма регистрации -->

        <form action="#" class="form form_signup">
          <h3 class="form__title">Регистрация</h3>
          <div class="input_container">
            <input
              type="text"
              class="form__input"
              placeholder="Логин"
              name="login"
            />
            <span class="error-message signup__login-error"></span>
          </div>
          <div class="input_container">
            <input
              type="text"
              class="form__input"
              placeholder="Имя"
              name="name"
            />
            <span class="error-message signup__name-error"></span>
          </div>
          <div class="input_container">
            <input
              type="text"
              class="form__input"
              placeholder="Email"
              name="email"
            />
            <span class="error-message signup__email-error"></span>
          </div>
          <div class="input_container">
            <input
              type="password"
              class="form__input"
              placeholder="Пароль"
              name="password"
            />
            <span class="error-message signup__password-error"></span>
          </div>
          <div class="input_container">
            <input
              type="password"
              class="form__input"
              placeholder="Подтвердите пароль"
              name="password_confirm"
            />
            <span class="error-message signup__passwordConfirm-error"></span>
          </div>
          <div class="input_container">
            <span class="user-created"></span>
            <button class="form__btn form__btn_signup">
              Зарегистрироваться
            </button>
          </div>
        </form>
      </div>
    </article>
  <?php endif ?>
  </body>
</html>
