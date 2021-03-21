<?php
  require('../work/header.php');
?>
  <title>TIME MANAGER-入力フォーム</title>
  </head>
  <body>
    <div class="container">
      <div id="main">
        <?php
          ini_set('display_errors' , 1);
          require('../work/functions.php');

          createToken();

          $dateTime = new DateTime();
          $year = $dateTime->format('Y');
          $month = $dateTime->format('n');
          $date = $dateTime->format('d');
        ?>

        <h3 mb-2>TIME MANAGER</h3>
        <p mb-5>ー学習時間や練習時間を記録するアプリー</p>
        <form class="form" action="../work/result.php" method="post" >
          <div class="form-group">  
              <label class="control-label mt-2">日付</label>
              <input type="date" name="date" value="<?= $year.'-'.$month.'-'.$date ?>" min="2000-01-01" max="2999-12-31" required>
          </div>
          <div class="form-group">      
              <label class="control-label">開始時間</label>
              <input type="time" name="start" required>
          </div>
          <div class="form-group">      
              <label class="control-label">終了時間</label>
              <input type="time" name="end" required>
          </div>
          <div class="form-group">      
              <input class="btn btn-primary" type="submit" value="確定" name="submit">
          </div>
              <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>

        <p><a href="/time_manager/work/result.php">登録内容確認</a></p>
<?php
  require('../work/footer.php');
?>