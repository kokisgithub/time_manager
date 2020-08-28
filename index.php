<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>TIME MANAGER</title>
</head>
<body>







<form action="" method="post">
  <input type="time" name="time1">
  <input type="time" name="time2">
  <input type="submit" value="送信">
  </form>
  


<?php 

$time1 = filter_input(INPUT_POST, 'time1');
$time2 = filter_input(INPUT_POST, 'time2');

$t1 = new DateTime($time1);
$t2 = new DateTime($time2);

$interval = $t1->diff($t2);

$interval = $interval->format('%H:%I');

if($interval !== '00:00' || null){  
  echo $interval;
}

?>











</body>
</html>