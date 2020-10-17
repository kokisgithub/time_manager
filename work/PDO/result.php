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

  //月別の合計時間の取得
  $sql = "SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(learning_time))), '%H:%i') AS total_time FROM testtable";
  // $sql = "SELECT id, TIME_FORMAT(learning_time, '%H:%i') AS learning_time, DATE_FORMAT(learning_date, '%Y-%m') AS learning_month "
  $sth = $pdo -> prepare($sql);
  $sth -> execute();
  $totaltime = $sth->fetch(PDO::FETCH_COLUMN);
  
  $sql = "SELECT id, TIME_FORMAT(start_time, '%H:%i') AS start_time, TIME_FORMAT(end_time, '%H:%i') AS end_time, TIME_FORMAT(learning_time, '%H:%i') AS learning_time, learning_date FROM testtable ORDER BY learning_date";
  $sth = $pdo -> prepare($sql);
  $sth -> execute();

  $row_count = $sth->rowCount();
  

  
}catch (PDOException $e){
  echo 'データベース接続に失敗しました。:' . $e->getMessage();
  die();
}

$dbh = null;
?>

<p align="center" margin="0px";>
登録件数:<?= $row_count; ?><br>
合計時間:<?= $totaltime; ?>
</p>
<table border='1' text-align="center" align="center">
<tr>
<th>実施日</th>
<th>開始</th>
<th>終了</th>
<th>実施時間</th>
<th></th>
</tr>

<?php

while($row = $sth->fetch(PDO::FETCH_ASSOC)){
  $rows[] = $row;
}

if(isset($rows)){
$rows = $rows;

foreach($rows as $r){
  ?>
<tr>
  <td><?= h($r['learning_date']); ?></td>
  <td><?= h($r['start_time']); ?></td>
  <td><?= h($r['end_time']); ?></td>
  <td><?= h($r['learning_time']); ?></td>
  <td>
  <form action="../PDO/delete.php" method="post" >
  <button name="delete_id" value="<?= h($r['id']); ?>">削除</button>
  </form>
  </td>
</tr>
<?php
}
}
?>
</table>

<p><a href="/time_manager/work/index.php" style="text-align:center">入力フォーム</a></p>

</body>
</html>
