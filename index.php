<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>TIME MANAGER</title>
</head>
<body>

<?php
ini_set('display_errors' , 1);
 
  $aryWeek = ['日','月','火','水','木','金','土'];
  $dateTime = new DateTime();
  $year = $dateTime->format('Y');
  $month = $dateTime->format('m');
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

<table class="calender">
  <?php
  foreach ($aryCalendar as $value){ 
  ?> 
  <tr class=>
  <td>
    <?= $value['day']; ?> (<?= $aryWeek[$value['week']]; ?>) 
  </td>    
  <?php } ?>
  <?php require('../time_manager/functions.php'); ?>
 </tr>
</table>

</body>
</html>