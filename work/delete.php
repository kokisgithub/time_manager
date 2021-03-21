<?php
  require('../work/header.php');
?>
  <title>TIME MANAGER-削除完了</title>
  </head>
  <body>
    <?php
      ini_set('display_errors' , 1);
      require('../work/functions.php');

      $delete = filter_input(INPUT_POST, 'delete_id');
      $dsn = 'mysql:dbname=manager;host=localhost;charset=utf8mb4';
      $user = 'test';
      $password = 'test';

      try {
        if(!empty($_SESSION['token']) && $_SESSION['token'] === filter_input(INPUT_POST,'token')){
          echo '<div class="text-center">削除しました。</div>';
        }
        $pdo = new PDO($dsn, $user, $password);  
        if(isset($delete)){
          validateToken();          
          $sql = "DELETE FROM testtable WHERE id = :id";
          $sth = $pdo -> prepare($sql);
          $sth -> bindValue(':id', $delete);
          $sth -> execute();
          unset($_SESSION['token']);
        }  
      }catch (PDOException $e){
        echo 'データベース接続に失敗しました。:' . $e->getMessage();
        die();
      }
      $dbh = null;
    ?>
    <div class="text-center mt-5"><p><a href="/time_manager/work/result.php">登録内容確認</a></p></div>
    <div class="text-center mt-5"><p><a href="/time_manager/work/index.php">入力フォーム</a></p></div>
<?php
  require('../work/footer.php');
?>