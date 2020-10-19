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

  $sql = "SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(learning_time))), '%H:%i') AS total_time FROM testtable";
  $sth = $pdo -> prepare($sql);
  $sth -> execute();
  $totaltime = $sth->fetch(PDO::FETCH_COLUMN);
  
  $sql = "SELECT DATE_FORMAT(learning_date, '%Y-%m') AS learning_month, 
  TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(learning_time))), '%H:%i') AS total_time, 
  COUNT(*) AS count FROM testtable GROUP BY learning_month ORDER BY learning_month DESC";
  $sth = $pdo -> prepare($sql);
  $sth -> execute();
  $monthly = $sth->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <div style="text-align:center"><caption>月別</caption></div>
  <div style="margin-bottom:auto; text-align:center"><table border="1" style="border-collapse: collapse" align="center"></div>
  <tr>
  <th>月</th>
  <th>合計時間</th>
  </tr>

<?php
  if(isset($monthly)){
    $monthly = $monthly;
    
    foreach($monthly as $m){
      ?>
   <tr>
     <td><?= h($m['learning_month']); ?></td>
     <td><?= h($m['total_time']); ?></td>
   </tr>
   <?php
   }
  }
  ?>

  
  
  </table>
  <?php

  $sql = "SELECT id, TIME_FORMAT(start_time, '%H:%i') AS start_time, TIME_FORMAT(end_time, '%H:%i') AS end_time, TIME_FORMAT(learning_time, '%H:%i') AS learning_time, learning_date FROM testtable ORDER BY learning_date DESC";
  $sth = $pdo -> prepare($sql);
  $sth -> execute();
  
}catch (PDOException $e){
  echo 'データベース接続に失敗しました。:' . $e->getMessage();
  die();
}

$row = $sth->fetchAll(PDO::FETCH_ASSOC);
$row_count = $sth->rowCount();

$dbh = null;
?>

<div style="text-align:center"><caption>総合</caption></div>
<div style="margin-bottom:auto; text-align:center"><table border='1' style="border-collapse: collapse" align="center"></div>
<tr>
<th>合計</th>
<th>登録件数</th>
</tr>
<tr>
<td><?= $totaltime; ?></td>
<td><?= $row_count; ?></td>
</tr>
</table>

<div style="text-align:center"><caption>登録内容</caption></div>
<div style="text-align:center"><table border='1' style="border-collapse: collapse" align="center"></div>
<tr>
<th>日</th>
<th>開始</th>
<th>終了</th>
<th>時間</th>
<th></th>
</tr>

<?php

if(isset($row)){
$row = $row;

foreach($row as $r){
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

<div style="text-align:center"><p><a href="/time_manager/work/index.php">入力フォーム</a></p></div>

</body>
</html>
