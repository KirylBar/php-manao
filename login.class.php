<?php

class LoginUser{
  private $userLogin;
  private $userPassword;
  private $storage = "./db/data.json";
  private $stored_users;
  private $response;
  public $flag;

  public function __construct($login,$password){
    $this->userLogin = $login;
    $this->userPassword = $password;
    $this->stored_users = json_decode(file_get_contents($this->storage), true);
    $this->response = [];
    $this->flag = false;

    $this->login();
  }

  private function checkLogin(){
    foreach ($this->stored_users as $user) {
       if($user['login'] == $this->userLogin){
          if(password_verify($this->userPassword, $user['password'])){
            $this->userLogged($this->userLogin);
            return;
        }   
       }
    }
    $this->response['error'] = 'error';
  }

  private function login(){
    $this->checkLogin();
    echo json_encode($this->response);
  }
  
  private function userLogged($username = '') {
    session_start();
    $_SESSION['user_logged'] = true;
    $_SESSION['username'] = $username;

    setcookie("user_logged", true, time()+3600, "/","", 0);
    setcookie("username", $username, time()+3600, "/","", 0);
  }
}