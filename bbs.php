  <?php

    session_start();
    if (empty($_SESSION) || !isset($_SESSION['accountname'])) {
      header('Location: ./index.php');
    }
    $accountname = $_SESSION['accountname'];
    //データベースに接続
    require ('dbconnect.php');
    if(!empty($_POST) && isset($_POST['nickname']) && isset($_POST['comment'])) {
      $nickname = htmlspecialchars($_POST['nickname']);
      $comment = htmlspecialchars($_POST['comment']);
      if ($nickname == true && $comment == true) {
        $sql = 'insert into posts (nickname, comment, created) values (?, ?, now())';
        $stmt = $dbh -> prepare($sql);
        $stmt -> execute(array($nickname, $comment));
        header('Location: ./bbs.php');
      }
    }

    if (isset($_GET['action']) && ($_GET['action'] == 'delete')) {
      // $sql = 'delete from posts where id = ?';
      $sql = 'update posts set delete_flag = 1 where id = ?';
      $stmt = $dbh -> prepare($sql);
      $stmt -> execute(array($_GET['id']));
      header('Location: ./bbs.php');
    }

     if (isset($_GET['action']) && ($_GET['action'] == 'count')) {
      $sql = 'update posts set likes = likes + 1 where id = ?';
      $stmt = $dbh -> prepare($sql);
      $stmt -> execute(array($_GET['id']));
      header('Location: ./bbs.php');
    }

    // if (!empty($_POST) && isset($_POST['delete'])) {

    // 	$sql = 'delete from posts where id = ?';
    //   $stmt = $dbh -> prepare($sql);
    //   $stmt -> execute(array($_POST['delete']));
    // }

    // $sql = 'select * from posts order by id desc';
    $sql = 'select * from posts where delete_flag = 0 order by id desc';
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

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/form.css">
    <link rel="stylesheet" href="assets/css/timeline.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="./css/bbs.css">
  </head>
  <body>

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">
                  <span class="strong-title">
                    <i class="fa fa-linux"></i>Oneline bbs <?php if (!empty($_SESSION) && isset($_SESSION['accountname'])) { echo $_SESSION['accountname']; } ?>
                  </span>
                </a>
            </div>
            <div class="logout">
                  <form method="post" action="./index.php">
                    <button type="submit" name="logout" >ログアウト</button>
                  </form>
                </div>
                <div class="clear"></div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-md-4 content-margin-top">
          <form method="post">
            <div class="form-group">
              <div class="input-group">
                <input type="text" name="nickname" class="form-control"
                         id="validate-text" placeholder="nickname" required>

                <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
              </div>
              
            </div>

            <div class="form-group">
              <div class="input-group" data-validate="length" data-length="4">
                <textarea type="text" class="form-control" name="comment" id="validate-length" placeholder="comment" required></textarea>
                <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
              </div>
            </div>

            <button type="submit" class="btn btn-primary col-xs-12" disabled>つぶやく</button>
          </form>
        </div>

        <div class="col-md-8 content-margin-top">

          <div class="timeline-centered">


            <?php
            	foreach ($posts as $post_each) {
            ?>
          		<article class="timeline-entry">
  	            	<div class="timeline-entry-inner">
  		                <div class="timeline-icon bg-success">
  		                    <i class="entypo-feather"></i>
  		                    <i class="fa fa-cogs"></i>
  		                </div>
  	                	<div class="timeline-label">
  					    	<h2>
  					    		<a href="#"><?php echo $post_each['nickname']; ?></a>&nbsp;
  					    		<span>
                      <?php
                        $created = strtotime($post_each['created']);
                        $created = date('Y年m月d日 HH時MM分ss秒', $created);
                      ?>
                    </span>
  					    	</h2>
  					        <p><?php echo $post_each['comment']; ?></p>
                    <a href="bbs.php?action=count&id=<?php echo $post_each['id'] ?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>LIKE <?php echo $post_each['likes'] ?></a>
                    <br />
                    <a href="bbs.php?action=delete&id=<?php echo $post_each['id']; ?>" class="deletebutton" onclick="return confirm('本当に削除しますか？'); ">
                      <i class="fa fa-trash fa-lg"></i>
                    </a>
  	                	</div>
  	            	</div>
          		</article>
         	<?php
         		}
         	?>

          <article class="timeline-entry begin">

              <div class="timeline-entry-inner">

                  <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
                      <i class="entypo-flight"></i> +
                  </div>

              </div>

          </article>

        </div>

      </div>
    </div>





    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/form.js"></script>
  </body>
  </html>



