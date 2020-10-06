<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>TIME MANAGER-登録内容</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php

ini_set('display_errors' , 1);

require('../PDO/time.php'); 
require('../functions.php');

$dsn = 'mysql:dbname=manager;host=localhost;charset=utf8mb4';
  $user = 'test';
  $password = 'test';

try {
  $pdo = new PDO($dsn, $user, $password);
  
  $sql = "SELECT * FROM testtable";

  $sth = $pdo -> prepare($sql);
  $sth -> execute();

  $row_count = $sth->rowCount();
  

  while($row = $sth->fetch()){
    $rows[] = $row;
  }

}catch (PDOException $e){
  echo '接続に失敗しました。:' . $e->getMessage();
  die();
}

$dbh = null;
?>


登録件数:<?= $row_count; ?>

<table border='1'>
<tr><td>学習日</td><td>学習時間</td></tr>

<?php
foreach($rows as $r){
?>
<tr>
  <td><?= h($r['learning_date']); ?></td>
  <td><?= h($r['learning_time']); ?></td>
</tr>
<?php
}
?>
</table>

<p><a href="/time_manager/work/index.php">入力フォーム</a></p>

</body>
</html>
