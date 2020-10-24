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
          background-color: #efefef;
          align:center;
          text-align:center;
      }
    </style>
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

      </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>
