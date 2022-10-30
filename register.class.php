<?php 

class RegisterUser{
  private $userLogin;
  private $userName;
  private $userEmail;
  private $userPassword;
  private $userPasswordConfirm;
  private $userPasswordEncrypted;
  private $new_user;
  private $storage = "./db/data.json";
  private $stored_users;
  private $errorsArr;

  public function __construct($login,$name,$email,$password,$password_confirm){
    $this->userLogin = filter_var(trim($login), FILTER_SANITIZE_STRING); 
    $this->userName = filter_var(trim($name), FILTER_SANITIZE_STRING);
    $this->userEmail = filter_var(trim($email), FILTER_SANITIZE_STRING);
    $this->userPassword = filter_var(trim($password), FILTER_SANITIZE_STRING);
    $this->userPasswordConfirm = filter_var(trim($password_confirm), FILTER_SANITIZE_STRING);
    $this->userPasswordEncrypted = password_hash($password, PASSWORD_DEFAULT);
    $this->stored_users = json_decode(file_get_contents($this->storage), true);
    $this->errorsArr = [];

    $this->new_user = [
      "login" => $this->userLogin,
      "name" => $this->userName,
      "email" => $this->userEmail,
      "password" => $this->userPasswordEncrypted,
   ];

    if($this->checkValid() == TRUE){
      $this->insertUser();
      echo json_encode('success');
    }else{
      echo json_encode($this->errorsArr);
    }
  }

  //Валидация
  private function loginCheck(){
    if(empty($this->userLogin)){
      $this->errorsArr['login'] = 'Обязательное поле';
      return;
    }

    if(mb_strlen($this->userLogin) < 6){
      $this->errorsArr['login'] = 'Минимальное число символов 6';
      return;
  }

   foreach ($this->stored_users as $user) {
    if($this->userLogin == $user['login']){
       $this->errorsArr['login'] = 'Логин занят';
       return;
    }
  }
 }

  private function nameCheck(){
    if(empty($this->userName)){
      $this->errorsArr['name'] = 'Обязательное поле';
      return;
    }

    if(mb_strlen($this->userName) < 2){
      $this->errorsArr['name'] = 'Минимальное число символов 2';
      return;
  }

    if(!preg_match('/^[a-zа-яё]+$/iu', $this->userName)){
      $this->errorsArr['name'] = 'Имя должно содержать только буквы';
      return;
  }
}

  private function emailCheck(){
    if(empty($this->userEmail)){
      $this->errorsArr['email'] = 'Обязательное поле';
      return;
    }

    foreach ($this->stored_users as $user) {
      if($this->userEmail == $user['email']){
        $this->errorsArr['email'] = 'Email занят';
        return;
      }
    }

    if (!filter_var($this->userEmail, FILTER_VALIDATE_EMAIL)) {
      $this->errorsArr['email'] = 'Не верный формат записи';
      return;
    }
  }

  private function passwordCheck() {
    if(empty($this->userPassword)){
      $this->errorsArr['password'] = 'Обязательное поле';
      return;
    }

    if(mb_strlen($this->userPassword) < 6){
      $this->errorsArr['password'] = 'Минимальное число символов 6';
      return;
    }

    if(!preg_match('/^(?=.*\d)(?=.*[a-z])[a-z0-9]+$/i', $this->userPassword)){
      $this->errorsArr['password'] = 'Должен состоять из цифр и латинских букв';
      return;
    }
  }

  private function equalPasswords() {
    if($this->userPassword != $this->userPasswordConfirm){
       $this->errorsArr['equalPasswords'] = 'Пароли должны совпадать';
       return;
    }

    if(empty($this->userPasswordConfirm)){
      $this->errorsArr['equalPasswords'] = 'Обязательное поле';
      return;
    }
  }


  private function checkValid(){
    $this->loginCheck();
    $this->nameCheck();
    $this->emailCheck();
    $this->passwordCheck();
    $this->equalPasswords();
    if(count($this->errorsArr) == 0){
       return true;
    }else{
       return false;
    }
 }

  private function insertUser(){
    array_push($this->stored_users, $this->new_user);
    file_put_contents($this->storage, json_encode($this->stored_users, JSON_UNESCAPED_UNICODE));
  }
}