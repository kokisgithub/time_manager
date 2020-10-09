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
  

  
}catch (PDOException $e){
  echo 'データベース接続に失敗しました。:' . $e->getMessage();
  die();
}

$dbh = null;
?>


登録件数:<?= $row_count; ?>

<table border='1'>
<tr><th>学習日</th><th>学習時間</th><th></th></tr>

<?php
while($row = $sth->fetch(PDO::FETCH_ASSOC)){
  $rows[] = $row;
}

foreach($rows as $r){
?>
<tr>
  <td><?= h($r['learning_date']); ?></td>
  <td><?= h($r['learning_time']); ?></td>
  <td>
  <form action="../PDO/delete.php" method="post" >
  <button name="delete_id" value="<?= h($r['id']); ?>">削除</button>
  </form>
  </td>
</tr>
<?php
}
?>
</table>

<p><a href="/time_manager/work/index.php">入力フォーム</a></p>

</body>
</html>
