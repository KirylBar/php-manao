<?php session_start() ?>
<?php    
  function userUnLogged() {
    $_SESSION['user_logged'] = false;
    unset($_SESSION['username']);

    setcookie("user_logged", '', time()-1, "/","", 0);
    setcookie("username", '', time()-1, "/","", 0);
  } 
  
  if(isset($_POST['logout'])){
    userUnLogged();
    unset($_POST['logout']);
    header('Location: index.php');
  }
?>