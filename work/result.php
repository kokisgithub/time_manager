<?php
  require('../work/header.php');
?>
  <title>TIME MANAGER-登録内容</title>
  </head>
  <body>
    <div class="container">
      <div id="main">
        <?php
          ini_set('display_errors' , 1);
          require('../work/functions.php');

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
            createToken();
            $sql = "SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(learning_time))), '%H:%i') AS total_time FROM testtable";
            $sth = $pdo -> prepare($sql);
            $sth -> execute();
            $totaltime = $sth->fetch(PDO::FETCH_COLUMN);
      
            $sql = "SELECT DATE_FORMAT(learning_date, '%Y-%m') AS learning_month, 
            TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(learning_time))), '%H:%i') AS total_time, 
            COUNT(*) AS count FROM testtable GROUP BY learning_month ORDER BY learning_month DESC";
            $sth = $pdo -> prepare($sql);
            $sth -> execute();
            $monthly = $sth->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <h3 class="bg-dark text-light">月別</h3>
        <table class="table table-striped">
          <tr>
            <th>月</th>
            <th>合計時間</th>
          </tr>
          <?php
            if(isset($monthly)){
              $monthly = $monthly;
              
              foreach($monthly as $m){
          ?>
          <tr>
            <td><?= h($m['learning_month']); ?></td>
            <td><?= h($m['total_time']); ?></td>
          </tr>
          <?php
            }
            }
          ?>
        </table>
        <?php
            $sql = "SELECT id, TIME_FORMAT(start_time, '%H:%i') AS start_time, TIME_FORMAT(end_time, '%H:%i') AS end_time, TIME_FORMAT(learning_time, '%H:%i') AS learning_time, learning_date FROM testtable ORDER BY learning_date DESC";
            $sth = $pdo -> prepare($sql);
            $sth -> execute();
          }catch (PDOException $e){
            echo 'データベース接続に失敗しました。:' . $e->getMessage();
            die();
          }
          $row = $sth->fetchAll(PDO::FETCH_ASSOC);
          $row_count = $sth->rowCount();
          $dbh = null;
        ?>
        <h3 class="bg-dark text-light mt-1">総合</h3>
        <table class="table table-striped">
          <tr>
            <th>合計</th>
            <th>登録件数</th>
          </tr>
          <tr>
            <td><?= h($totaltime); ?></td>
            <td><?= h($row_count); ?></td>
          </tr>
        </table>
        <h3 class="bg-dark text-light mt1">登録内容</h3>
        <table class="table table-striped">
          <tr>
            <th>日</th>
            <th>開始</th>
            <th>終了</th>
            <th>時間</th>
            <th></th>
          </tr>

          <?php
            if(isset($row)){
            $row = $row;

            foreach($row as $r){
          ?>
            <tr>
              <td><?= h($r['learning_date']); ?></td>
              <td><?= h($r['start_time']); ?></td>
              <td><?= h($r['end_time']); ?></td>
              <td><?= h($r['learning_time']); ?></td>
              <td>
                <form action="../work/delete.php" method="post" >
                  <button class="btn btn-danger" name="delete_id" value="<?= h($r['id']); ?>">削除</button>
                  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                </form>
              </td>
            </tr>
          <?php
            }
            }
          ?>
        </table>
        <p><a href="/time_manager/work/index.php">入力フォーム</a></p>
<?php
  require('../work/footer.php');
?>