<?php
  
  //関数化 & MVC2モデルで
  //POST送信が行われたら、下記の処理を実行
  //テストコメント
  //データベースに接続
  require ('dbconnect.php');
  if(!empty($_POST) && isset($_POST['nickname']) && isset($_POST['comment'])) {
    $nickname = htmlspecialchars($_POST['nickname']);
    $comment = htmlspecialchars($_POST['comment']);
    if ($nickname == true && $comment == true) {
      $sql = 'insert into posts (nickname, comment, created) values (?, ?, now())';
      // $sql = sprintf('insert into posts (nickname, comment, created) values (\'%s\',\'%s\',now())', $nickname, $comment);
      $stmt = $dbh -> prepare($sql);
      $stmt -> execute(array($nickname, $comment));
    } else {
      echo '入力されていない項目があります。値を入力してください。';
    }
  }

  $sql = 'select * from posts';
  $stmt = $dbh -> prepare($sql);
  $stmt -> execute();
  $posts = array();
  while(1) {
    $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
    if (!$rec) {
      break;
    }
    $posts[] = $rec;
  }
  $dbh = null;
  
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>

</head>
<body>
    <form method="post">
      <input type="text" name="nickname" placeholder="nickname" required="true">
      <textarea type="text" name="comment" placeholder="comment" required></textarea>
      <button type="submit" >つぶやく</button>
    </form>
    
    <?php
      foreach ($posts as $post_each) {
        echo sprintf('<h2><a href="#">%s</a>&nbsp;<span>%s</span></h2>', $post_each['nickname'], $post_each['created']);
        echo sprintf('<p>%s</p>', $post_each['comment']);
      }
    ?>
</body>
</html>