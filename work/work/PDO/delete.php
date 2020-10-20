<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>TIME MANAGER-削除完了</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php

ini_set('display_errors' , 1);

$delete = filter_input(INPUT_POST, 'delete_id');

$dsn = 'mysql:dbname=manager;host=localhost;charset=utf8mb4';
$user = 'test';
$password = 'test';

try {
  $pdo = new PDO($dsn, $user, $password);
  echo '削除しました。<br>';
  
  $sql = "DELETE FROM testtable WHERE id = :id";
  $sth = $pdo -> prepare($sql);
  $sth -> bindValue(':id', $delete);
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
