  <?php 

  $time1 = filter_input(INPUT_POST, "start".$value['day']);
  $time2 = filter_input(INPUT_POST, "end".$value['day']);

  $t1 = new DateTime($time1);
  $t2 = new DateTime($time2);

  $interval = $t1->diff($t2);
  $interval = $interval->format('%H:%I');

 
  ?>