<?php 

    session_start();

    require('dbcon.php');

    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    var_dump($_POST);
    var_dump($_FILES);

    if (!empty($_POST)) {
        if ($_POST['name'] == '') {
            $error['name'] = 'blank';
        }
        if ($_POST['mail'] == '') {
            $error['mail'] = 'blank';
        }
        if ($_POST['password'] == '') {
            $error['password'] = 'blank';
        } elseif (mb_strlen($_POST['password']) < 6) {
          $error['password'] = 'length';
        }


          if (!isset($error)) {
              $sql = 'SELECT COUNT(mail) AS `check` FROM `future` WHERE `mail`=?';
              $data = array($_POST['mail']);
              $stmt = $dbh->prepare($sql);
              $stmt->execute($data);

              $mail_count = $stmt->fetch(PDO::FETCH_ASSOC);
              if ($mail_count['check'] >= 1) {
                $error['mail'] = 'already';
              }
              if (!isset($error)) {
                  $ext = substr($_FILES['photo']['name'], -3);
                  if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif') {
                  $photo_name = date('Y.m.d') . $_FILES['photo']['name'];
                  move_uploaded_file($_FILES['photo']['tmp_name'], '../photos_name/' . $photo_name);
                  move_uploaded_file($_FILES['photo']['tmp_name'], '../picture_path/' . $photo_name);
                  var_dump($photo_name);
                  
                  
                  $_SESSION['join1'] = $_POST;
                  $_SESSION['join1']['photo'] = $photo_name;
                 var_dump($_SESSION);
                    header('Location: check_jo.php');




                  } else {
                    $error['photo'] = 'type';
                  }
              }
          }
    }




 ?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Joya</title>

    <!-- Bootstrap -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/timeline.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
    <!--
      designフォルダ内では2つパスの位置を戻ってからcssにアクセスしていることに注意！
     -->

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
              <span class="strong-title"><i class="fa fa-twitter-square"></i> Joya Yamashita</span>

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
        <legend>見たければ会員登録してね。</legend>
        <form method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">
          <!-- ニックネーム -->
          <div class="form-group">
            <label class="col-sm-4 control-label">ニックネーム</label>
            <div class="col-sm-8">
              <input type="text" name="name" class="form-control" placeholder="">
              <?php if (isset($error['name']) == 'blank'): ?>
                <p>* ニックネームを書いてください。</p>
              <?php endif ?>

            </div>
          </div>
          <!-- メールアドレス -->
          <div class="form-group">
            <label class="col-sm-4 control-label">メールアドレス</label>
            <div class="col-sm-8">
              <input type="email" name="mail" class="form-control" placeholder="">
              <?php if (isset($error['mail']) && $error['mail'] == 'blank' ) { ?>
                <p>* メールアドレスを記入してください。</p>
              <?php } elseif (isset($error['mail']) && $error['mail'] == 'already') { ?>
                 <p>* すでに登録されています。</p>
              <?php } ?>

            </div>
          </div>
          <!-- パスワード -->
          <div class="form-group">
            <label class="col-sm-4 control-label">パスワード</label>
            <div class="col-sm-8">
              <input type="password" name="password" class="form-control" placeholder="">
              <?php if (isset($error['password']) && $error['password'] == 'blank') { ?>
                <p>* パスワードを入力してください。</p>
              <?php } elseif (isset($error['password']) && $error['password'] == 'length') { ?>
                <p>* 6文字以上入力してください。</p>
              <?php } ?>
            </div>
          </div>
          <!-- プロフィール写真 -->
          <div class="form-group">
            <label class="col-sm-4 control-label">プロフィール写真</label>
            <div class="col-sm-8">
              <input type="file" name="photo" class="form-control">
              <?php if (isset($error['photo']) && $error['photo'] == 'type') { ?>
                <p>写真がありません。</p>
              <?php } ?>
            </div>
          </div>

          <input type="submit" class="error" value="次へ">
        </form>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets/js/jquery-3.1.1.js"></script>
    <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
  </body>
</html>
