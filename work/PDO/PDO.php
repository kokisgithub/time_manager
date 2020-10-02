<?php

ini_set('display_errors' , 1);

require('../PDO/time.php'); 

$dsn = 'mysql:dbname=manager;host=localhost;charset=utf8mb4';
  $user = 'test';
  $password = 'test';

try {
  $pdo = new PDO($dsn, $user, $password);
  echo '学習時間を登録しました。<br>';
  $sql = "INSERT INTO testtable (learning_date,learning_time) VALUES (:learning_date, :learning_time)";

  $sth = $pdo -> prepare($sql);
  
  $sth -> bindValue(':learning_date', $learning_date);
  $sth -> bindValue(':learning_time', $diff);

  $sth -> execute();
}catch (PDOException $e){
  print('接続に失敗しました。:'.$e->getMessage());
  die();
}

$dbh = null;