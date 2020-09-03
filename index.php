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
<?php require('../time_manager/functions.php'); ?>

<table class="calendar">
  <caption><?= $year."年".$month."月" ?></caption>
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
    <?= $value['day']; ?> (<?= $aryWeek[$value['week']]; ?>) 
  </td>
  
  <form action="" method="post">
    <td>
    <div style="text-align:center;"><input type="time" name="time1" class="timebutton1"></div>    
    </td>
    <td>
    <div style="text-align:center;"><input type="time" name="time2" class="timebutton2"></div>
    </td>    
    <td>
    <div style="text-align:center;"><input type="submit" value="確定" class="submitbutton"></div>
  </td>     
</form>
    <td>
      <?php interval($interval); ?>
    </td>
  </tr>
  <?php } ?>
</table>

</body>
</html>