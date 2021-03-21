<?php
  function h($str){

    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }

  function createToken()
  {
    if(!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(random_bytes(32));
    } 
  }

  function validateToken()
  {
    if(empty($_SESSION['token']) ||
      $_SESSION['token'] !== filter_input(INPUT_POST,'token')  
    ){
      exit('不正なアクセス:もう一度やり直してください');
    } 
  }
  session_start();