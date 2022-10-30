<?php require("register.class.php") ?>

<?php

$newUser = new RegisterUser(
  $_POST['login'], 
  $_POST['name'], 
  $_POST['email'],
  $_POST['password'], 
  $_POST['password_confirm']
);
