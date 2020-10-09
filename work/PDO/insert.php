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
  $sql = "INSERT INTO testtable (learning_date,learning_time) VALUES (:learning_date, :learning_time)";

  $sth = $pdo -> prepare($sql);
  
  $sth -> bindValue(':learning_date', $learning_date);
  $sth -> bindValue(':learning_time', $diff);

  $sth -> execute();
}catch (PDOException $e){
  echo 'データベース接続に失敗しました。:' . $e->getMessage();
  die();
}

$dbh = null;
?>

<p><a href="/time_manager/work/PDO/result.php">登録内容確認</a></p>
<p><a href="/time_manager/work/index.php">入力フォーム</a></p>

</body>
</html>
