<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style type=text/css>
      div#main {
          padding:30px;
          align:center;
          text-align:center;
      }
    </style>
    <title>TIME MANAGER-登録内容</title>
  </head>
  <body>
      
    <?php

      ini_set('display_errors' , 1);
      require('../work/functions.php');
      
      $delete = filter_input(INPUT_POST, 'delete_id');
      $learning_date = filter_input(INPUT_POST, "date");
      $time1 = filter_input(INPUT_POST, "start");
      $time2 = filter_input(INPUT_POST, "end");
      
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
      
      $dsn = 'mysql:dbname=manager;host=localhost;charset=utf8mb4';
      $user = 'test';
      $password = 'test';
      
      try {
        $pdo = new PDO($dsn, $user, $password);
        
        if(isset($delete)){
          $sql = "DELETE FROM testtable WHERE id = :id";
          $sth = $pdo -> prepare($sql);
          $sth -> bindValue(':id', $delete);
          $sth -> execute();
        }
        
        if(isset($learning_date) && isset($time1) && isset($time2) && isset($diff)){
          validateToken();          
          $sql = "INSERT INTO testtable (learning_date, start_time, end_time, learning_time) VALUES (:learning_date, :start_time, :end_time, :learning_time)";
          $sth = $pdo -> prepare($sql);
          $sth -> bindValue(':learning_date', $learning_date);
          $sth -> bindValue(':start_time', $time1);
          $sth -> bindValue(':end_time', $time2);
        $sth -> bindValue(':learning_time', $diff);
        $sth -> execute();
        unset($_SESSION['token']);
      }
      
      $sql = "SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(learning_time))), '%H:%i') AS total_time FROM testtable";
      $sth = $pdo -> prepare($sql);
      $sth -> execute();
      $totaltime = $sth->fetch(PDO::FETCH_COLUMN);
      
      $sql = "SELECT DISTINCT DATE_FORMAT(learning_date, '%Y-%m-%d') AS total_date, COUNT(*) AS count FROM testtable GROUP BY total_date";
      $sth = $pdo -> prepare($sql);
      $sth -> execute();
      $row_count = $sth->rowCount();
      
      $sql = "SELECT DATE_FORMAT(learning_date, '%Y-%m') AS learning_month, 
      TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(learning_time))), '%H:%i') AS total_time, 
      COUNT(*) AS count FROM testtable GROUP BY learning_month ORDER BY learning_month DESC";
      $sth = $pdo -> prepare($sql);
      $sth -> execute();
      $monthly = $sth->fetchAll(PDO::FETCH_ASSOC);
    ?>

      <div class="container">
        <div id="main">
              
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">全体</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">月別</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">登録内容確認/削除</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">        
              <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th>月</th>
                    <th>合計時間</th>
                  </tr>
                </thead>
                <?php
                  if(isset($monthly)){
                    $monthly = $monthly;
                    foreach($monthly as $m){
                ?>
                <tbody>
                  <tr>
                    <td><?= h($m['learning_month']); ?></td>
                    <td><?= h($m['total_time']); ?></td>
                  </tr>
                  <?php
                    }
                    }
                  ?>
                </tbody>
              </table>
            </div>
                
            <?php
              $sql = "SELECT id, TIME_FORMAT(start_time, '%H:%i') AS start_time, TIME_FORMAT(end_time, '%H:%i') AS end_time, TIME_FORMAT(learning_time, '%H:%i') AS learning_time, learning_date FROM testtable ORDER BY learning_date DESC";
              $sth = $pdo -> prepare($sql);
              $sth -> execute();

              }catch (PDOException $e){
                echo 'データベース接続に失敗しました。:' . $e->getMessage();
                die();
              }

              $row = $sth->fetchAll(PDO::FETCH_ASSOC);
              $dbh = null;
            ?>

            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th>合計時間</th>
                    <th>合計日数</th>
                  </tr>
                </thead>  
                <tbody>
                  <tr>
                    <td><?= h($totaltime); ?></td>
                    <td>
                      <?php
                        if($row_count !== 0){
                        echo h($row_count);
                        }
                      ?>
                    </td>

                  </tr>
                </tbody>  
              </table>
            </div>

            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
              <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th>日</th>
                    <th>開始</th>
                    <th>終了</th>
                    <th>時間</th>
                    <th></th>
                  </tr>
                </thead>
                  <?php              
                    if(isset($row)){
                    $row = $row;
                
                    foreach($row as $r){
                  ?>
                <tbody>
                  <tr>
                    <td><?= h($r['learning_date']); ?></td>
                    <td><?= h($r['start_time']); ?></td>
                    <td><?= h($r['end_time']); ?></td>
                    <td><?= h($r['learning_time']); ?></td>
                    <td>
                    <form action="" method="post" >
                    <button class="btn btn-danger" name="delete_id" value="<?= h($r['id']); ?>">削除</button>
                    </form>
                    </td>
                  </tr>
                  <?php
                    }
                    }
                  ?>
                </tbody>    
              </table>
            </div>
          </div>
            <p><a href="/time_manager/work/index.php">入力フォーム</a></p>
        </div>
      </div>
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>