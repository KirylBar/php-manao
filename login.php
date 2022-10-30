<?php require("login.class.php") ?>

<?php

$User = new LoginUser(
  $_POST['login'], 
  $_POST['password'], 
);