<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>DateTimeカレンダー</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php

$dateTime = new DateTime();
$year = $dateTime->format('Y');
$month = $dateTime->format('n');
// $date = $dateTime->format('d');
$end_month = $dateTime->format('t');

$aryWeek = ['日','月','火','水','木','金','土'];
  $aryCalendar = [];
  
  for ($i = 1; $i <= $end_month; $i++){
    $aryCalendar[$i]['day'] = $i;
    $s = sprintf('%02d', $i);
    $week = new DateTime($year.'-'.$month.'-'.$s);
    $w = $week->format('w');
    $aryCalendar[$i]['week']= $w;      
  } 
  
  ?>

<table class="calendar">
  <caption><?= $year."年 ".$month."月" ?></caption>
  <tr>
    <th>日付</th>
  </tr>
  <?php
  foreach ($aryCalendar as $value){ 
    if($value['week'] == 0){?>
  <tr class= "week0">
  <?php }elseif($value['week'] == 6){ ?>
    <tr class= "week6">
      <?php } ?> 
      <td>
        <?= $value['day']; ?> (<?= $aryWeek[$value['week']]; ?>) 
      </td>
  </tr>
  <?php } ?>
</table>

</body>
</html>
