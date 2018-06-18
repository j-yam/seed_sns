<?php 
    session_start();
    require('db_connect.php');
    //var_dump($_SESSION);

    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';

    if (isset($_COOKIE['password'])) {
        $_POST['email'] = $_COOKIE['email'];
        $_POST['email'] = $_COOKIE['password'];
        $_POST['save'] = 'on';
    }

    if (!empty($_POST)) {
          $sql = 'SELECT * FROM `members` WHERE `email`=? AND `password`=?';
          $data = array($_POST['email'], sha1($_POST['password']));
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);
          $member = $stmt->fetch(PDO::FETCH_ASSOC);
           var_dump(sha1($_POST['password']));
           var_dump($_POST);
           var_dump($member);

          if ($member == false) {
                $error['login'] = 'failed';

          } else {
            $_SESSION['login_id'] = $member['member_id'];
            $_SESSION['time'] = time();
              var_dump($SESSION);
            if ($_POST['save'] == 'on') {
              setcookie('email', $_POST['email'], time()+60*60*24*14);
              setcookie('password', $_POST['password'], time()+60*60*24*14);
            }
               header('Location: joind.php');
          }

    }
 

 ?>
 <!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SeedSNS</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

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
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 content-margin-top">
        <legend>ログイン</legend>
        <form method="post" action="" class="form-horizontal" role="form">
          <!-- メールアドレス -->
          <div class="form-group">
            <label class="col-sm-4 control-label">メールアドレス</label>
            <div class="col-sm-8">
              <input type="email" name="email" class="form-control" placeholder="例： seed@nex.com">
            </div>
          </div>
          <!-- パスワード -->
          <div class="form-group">
            <label class="col-sm-4 control-label">パスワード</label>
            <div class="col-sm-8">
              <input type="password" name="password" class="form-control" placeholder="">
            </div>
          </div>
          <!-- 自動ログイン -->
          <div class="form-group">
            <label class="col-sm-4 control-label">自動ログイン</label>
            <div class="col-sm-8">
              <input type="checkbox" name="save" value="on">
            </div>
          </div>
          <!-- ログイン失敗したとき -->
          <?php if (isset($error['login']) && $error['login'] == 'failed') { ?>
            <p class="error">メールアドレス、またはパスワードが一致しません。</p>
          <?php } ?>
          <input type="submit" class="btn btn-default" value="ログイン"> &nbsp;|&nbsp;
          <a href="join/index.php" class="btn btn-default">会員登録</a>
        </form>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery-3.1.1.js"></script>
    <script src="assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>