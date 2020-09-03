  <?php 

  $time1 = filter_input(INPUT_POST, 'time1');
  $time2 = filter_input(INPUT_POST, 'time2');

  $t1 = new DateTime($time1);
  $t2 = new DateTime($time2);

  $interval = $t1->diff($t2);

  $interval = $interval->format('%H:%I');

  function interval($interval)
  {  
    if ($interval !== '00:00' || null){
      echo $interval;
     }
  }
  

  ?>