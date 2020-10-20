<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>TIME MANAGER-登録完了</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php

ini_set('display_errors' , 1);

require('../PDO/time.php'); 

  $dsn = 'mysql:dbname=manager;host=localhost;charset=utf8mb4';
  $user = 'test';
  $password = 'test';

try {
  $pdo = new PDO($dsn, $user, $password);
  echo '登録しました。<br>';
  $sql = "INSERT INTO testtable (learning_date, start_time, end_time, learning_time) VALUES (:learning_date, :start_time, :end_time, :learning_time)";

  $sth = $pdo -> prepare($sql);
  
  $sth -> bindValue(':learning_date', $learning_date);
  $sth -> bindValue(':start_time', $time1);
  $sth -> bindValue(':end_time', $time2);
  $sth -> bindValue(':learning_time', $diff);

  $sth -> execute();
}catch (PDOException $e){
  echo 'データベース接続に失敗しました。:' . $e->getMessage();
  die();
}

$dbh = null;
?>

<div style="text-align:center"><p><a href="/time_manager/work/PDO/result.php">登録内容確認</a></p></div>
<div style="text-align:center"><p><a href="/time_manager/work/index.php">入力フォーム</a></p></div>

</body>
</html>
