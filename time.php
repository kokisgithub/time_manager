  <?php 

  $time1 = filter_input(INPUT_POST, "start".$value['day']);
  $time2 = filter_input(INPUT_POST, "end".$value['day']);

  if($time1 >= $time2){
    $time1 = null;
    $time2 = null;
  }else{
    $time1 = $time1;
    $time2 = $time2;
  }

  $t1 = new DateTime($time1);
  $t2 = new DateTime($time2);

  $interval = $t1->diff($t2);
  $diff = $interval->format('%H:%I');

  $diff = $diff !== '00:00' || null ? $diff : null; 
  
  ?>