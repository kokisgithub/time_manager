
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>TIME MANAGER</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
ini_set('display_errors' , 1);

require('../time_manager/functions.php');

$aryWeek = ['日','月','火','水','木','金','土'];
$dateTime = new DateTime();
$year = $dateTime->format('Y');
  $month = $dateTime->format('n');
  $end_month = $dateTime->format('t');

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
  <caption><?= h($year)."年 ".h($month)."月" ?></caption>
  <tr>
    <th>日付</th>
    <th>開始時間</th>
    <th>終了時間</th>
    <th>確定</th>
    <th>合計時間</th>
  </tr>
  <?php
  foreach ($aryCalendar as $value){ 
    if($value['week'] == 0){?>
  <tr class= "week0">
  <?php }elseif($value['week'] == 6){ ?>
    <tr class= "week6">
      <?php } ?> 
      <td>
        <?= h($value['day']); ?> (<?= h($aryWeek[$value['week']]); ?>) 
      </td>
  
  <?php require('../time_manager/time.php'); ?>

  <form action="" method="post" >
    <td>
      <div style="text-align:center;"><input type="time" name="start<?= h($value['day']); ?>" class="timebutton1" required></div>    
    </td>
    <td>
      <div style="text-align:center;"><input type="time" name="end<?= h($value['day']); ?>" class="timebutton2" required></div>
    </td>    
    <td>
      <div style="text-align:center;"><input type="submit"  value="確定" name="submit<?= h($value['day']) ?>" class="submitbutton">
      </div>
    </td>     
  </form>


    <td>
      <?= h($diff);?>
    </td>
  </tr>
  <?php } ?>
</table>

</body>
</html>