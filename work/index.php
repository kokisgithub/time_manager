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

require('../work/functions.php');

$dateTime = new DateTime();
$year = $dateTime->format('Y');
$month = $dateTime->format('n');
$date = $dateTime->format('d');
$end_month = $dateTime->format('t');
?>

<div style="text-align:center"><caption><?= h($year)."年 ".h($month)."月" ?></caption></div>
<form action="../PDO/PDO.php" method="post" >
  <table class="button" align="center">
    <tr>
      <th>日付</th>
      <th>開始時間</th>
      <th>終了時間</th>
      <th>確定</th>
    </tr>
    <tr>
        <td>
        <div style="text-align:center"><input type="date" name="date" value="<?= $year.'-'.$month.'-'.$date ?>" 
        min="2000-01-01" max="2999-12-31" class="datebutton" required></div>
        </td>
        <td>
        <div style="text-align:center"><input type="time" name="start" class="timebutton1" required></div>    
        </td>
        <td>
        <div style="text-align:center"><input type="time" name="end" class="timebutton2" required></div>
        </td>    
        <td>
        <div style="text-align:center"><input type="submit"  value="確定" name="submit" class="submitbutton">
        </div>
        </td>      
    </tr>
  </table>
</form>


</body>
</html>
