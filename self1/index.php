<?php 
    session_start();
    require('../db_connect.php');

    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<pre>';
    var_dump($_SESSION);
    echo '</pre>';
    echo '<pre>';
    var_dump($_COOKIE);
    echo '</pre>';

    if (isset($_SESSION['login_id']) && $_SESSION['time'] +  3600> time()) {
      $_SESSION['time'] = time();
      $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
      $data = array($_SESSION['login_id']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $member_login = $stmt->fetch(PDO::FETCH_ASSOC);
      echo '<pre>';
      var_dump($member_login);
      echo '</pre>';

    } else {
        header('Location: login.php');
    }
    
    if (!empty($_POST['tweet'])) {
        if ($_POST == '') {
          $error['tweet'] = 'blank';
        }

      if (!isset($error)) {

          $sql = 'INSERT INTO `tweets` SET `tweet`=?, `member_id`=?, `reply_tweet_id`=-1, `created`=NOW()';
          $data = array($_POST['tweet'], $member_login['member_id'],);
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);
      }
    }
     if (isset($_GET['page'])) {
           $page = $_GET['page'];
     } else {
           $page = 1;
     }

     $page = max($page, 1);
     $max_page_tweet = 5;


     $page_sql = 'SELECT COUNT(*) AS `count`FROM `tweets` WHERE `delete_flag`=0';
     $page_stmt = $dbh->prepare($page_sql);
     $page_stmt->execute();

     $max_tweets = $page_stmt->fetch(PDO::FETCH_ASSOC);

     $max_page_number = ceil($max_tweets['count'] / $max_page_tweet);
     $page = min($page, $max_page_number);
     $start_page = ($page -1) * $max_page_tweet;

     $tweet_sql = 'SELECT `tweets`.*, `members`.`nickname`, `members`.`email`, `members`.`picture_path` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 AND `reply_tweet_id`=-1 ORDER BY `tweets`.`created` DESC LIMIT '.$start_page.",".$max_page_tweet;
    // $tweet_sql = 'SELECT `tweets`.*, `members`.`nickname`, `members`.`email`, `members`.`picture_path`, `members`.`created` FROM `tweets` LEFT JOIN `members` ON `tweets`.`member_id`=`members`.`member_id` WHERE `delete_flag`=0 ORDER BY `tweets`.`created` DESC LIMIT '.$start_page.",".$max_page_tweet;
    $tweet_stmt = $dbh->prepare($tweet_sql);
    $tweet_stmt->execute();
    // $tweet = $stmt->fetch(PDO::FETCH_ASSOC);
    $tweets = array();
    while (true) {
        $tweet = $tweet_stmt->fetch(PDO::FETCH_ASSOC);
        if ($tweet == false) {
            break;
        }
            $tweets[] = $tweet;
    }
    echo '<pre>';
    var_dump($tweets);
    echo '</pre>';

    $reply_sql = 'SELECT * FROM `tweets` WHERE `reply_tweet_id`!=-1';
    $reply_stmt = $dbh->prepare($reply_sql);
    $reply_stmt->execute();
    $reply_tweet = $reply_stmt->fetch(PDO::FETCH_ASSOC);

    echo '<pre>';
    var_dump($reply_tweet);
    echo '</pre>';

 ?>

 <!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SeedSNS</title>

    <!-- Bootstrap -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/timeline.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">

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
              <a class="navbar-brand" href="index.html"><span class="strong-title"><i class="fa fa-twitter-square"></i> Seed SNS</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">ログアウト</a></li>
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
        <legend>ようこそ<?php echo $member_login['nickname']; ?>さん！</legend>
        <form method="post" action="" class="form-horizontal" role="form">
            <!-- つぶやき -->
            <div class="form-group">
              <label class="col-sm-4 control-label">つぶやき</label>
              <div class="col-sm-8">
                <textarea name="tweet" cols="50" rows="5" class="form-control" placeholder="例：Hello World!"></textarea>
              </div>
            </div>
          <ul class="paging">
            <input type="submit" class="btn btn-info" value="つぶやく">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php if ($page != 1) { ?>
                <li><a href="index.php?page=<?php echo $page -1; ?>" class="btn btn-default">前</a></li>
                <?php } else { ?>
                  <li>前</li>
                <?php } ?>

                &nbsp;&nbsp;|&nbsp;&nbsp;
                <?php if ($page != $max_page_number) { ?>
                <li><a href="index.php?page=<?php echo $page +1; ?>" class="btn btn-default">次</a></li>
                <?php } else { ?>
                  <li>次</li>
                <?php } ?>
          </ul>
        </form>
      </div>

      <div class="col-md-8 content-margin-top">
        <?php foreach ($tweets as $tweet) { ?>
        <div class="msg">
          <img src="../photos/<?php echo $tweet['picture_path']; ?>" width="48" height="48">
          <p>
            <?php echo $tweet['tweet']; ?><span class="name"> <a href="profile.php?member_id=<?php echo $tweet['member_id']; ?>">(<?php echo $tweet['nickname']; ?>)</a> </span>
            [<a href="reply.php?tweet_id=<?php echo $tweet['tweet_id']; ?>">Re</a>]
            <?php if (isset($tweet['tweet_id']) == $reply_tweet['reply_tweet_id']) { ?>
              <p><?php echo $reply_tweet['tweet']; ?></p>
              <p><?php echo $tweet['tweet'] ?></p>
            <?php } ?>
          </p>
          <p class="day">
            <a href="view.php?tweet_id=<?php echo $tweet['tweet_id']; ?>">
              <?php echo $tweet['created']; ?>
            </a>
            <?php  if ($tweet['member_id'] == $member_login['member_id']) { ?>
            [<a href="edit.php?tweet_id=<?php echo $tweet['tweet_id']; ?>" style="color: #00994C;">編集</a>]
            [<a href="delete.php?tweet_id=<?php echo $tweet['tweet_id']; ?>" style="color: #F33;">削除</a>]
            <?php } ?>
          </p>
        </div>
            <?php } ?>
      </div>

    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets/js/jquery-3.1.1.js"></script>
    <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
  </body>
</html>
