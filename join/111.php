<?php
  // 違う階層にあるため
  require('../db_connect.php');

  echo '<br>';
  echo '<br>';
  echo '<br>';
  echo '<br>';

  // POST送信された時入力チェック
  if (!empty($_POST)) {
    // nicknameが空だった時
    if ($_POST['nickname'] == '') {
      $error['nickname'] = 'blank';
    }

    // emailが空だった時
    if ($_POST['email'] == '') {
      $error['email'] = 'blank';
    }

    // passwordが空だった時
    if ($_POST['password'] == '') {
      $error['password'] = 'blank';
    } elseif (mb_strlen($_POST['password']) < 4) {
      // strlen() = 文字の長さ(バイト数)を数字で返してくれる関数
      // mb_strlen() = 文字の長さ(文字数)を数字で返してくれる関数
      // $_POST['password']が4文字以上の時
      $error['password'] = 'length';
    }

    // isset()は値がセットされていればtrue、いなければfalseを返す
    // !は意味が逆になる
    // 例) !isset() はセットされていなければtrue、いればfalseを返す
    // 下の文は入力チェック後に$error配列に値がセットされていなければ処理実行
    if (!isset($error)) {
      // emailの重複チェック
      // DBに同じemailのデータがあるかチェックする
      // なぜ？
      // メールアドレスが重複していた場合、メールでの通知やSELECT文での取得の際に重複してしまう可能性があるため

      // Formタグ内に書いたメールアドレスと被らないような処理を書く必要がある
      $sql = 'SELECT COUNT(email) AS `count` FROM `members` WHERE `email`=?';
      // AS = カラムのキーを任意の文字に変えられる
      $data = array($_POST['email']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      // 重複しているかどうかの結果を取得する
      $email_count = $stmt->fetch(PDO::FETCH_ASSOC);
      // var_dump($email_count);

      // もし$email_count['count']が1以上の時
      if ($email_count['count'] >= 1) {
        $error['email'] = 'duplicated';
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

    <title>SeedSNS</title>

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
        <legend>会員登録</legend>
        <form method="POST" action="" class="form-horizontal" role="form">
          <!-- ニックネーム -->
          <div class="form-group">
            <label class="col-sm-4 control-label">ニックネーム</label>
            <div class="col-sm-8">
              <input type="text" name="nickname" class="form-control" placeholder="例： Seed kun">
              <?php if (isset($error['nickname'])) { ?>
                <p class="error">* ニックネームを入力してください</p>
              <?php } ?>
            </div>
          </div>
          <!-- メールアドレス -->
          <div class="form-group">
            <label class="col-sm-4 control-label">メールアドレス</label>
            <div class="col-sm-8">
              <input type="email" name="email" class="form-control" placeholder="例： seed@nex.com">
              <?php if (isset($error['email']) && $error['email'] == 'blank') { ?>
                <p class="error">* メールアドレスを入力してください</p>
              <?php } elseif (isset($error['email']) && $error['email'] == 'duplicated') { ?>
                <p class="error">* 入力されたメールアドレスは登録済みです</p>
              <?php } ?>
            </div>
          </div>
          <!-- パスワード -->
          <div class="form-group">
            <label class="col-sm-4 control-label">パスワード</label>
            <div class="col-sm-8">
              <input type="password" name="password" class="form-control" placeholder="">
              <?php if (isset($error['password']) && $error['password'] == 'blank') { ?>
                <p class="error">* パスワードを入力してください</p>
              <?php } elseif(isset($error['password']) && $error['password'] == 'length') { ?>
                <p class="error">パスワードは4文字以上入力してください</p>
              <?php } ?>
            </div>
          </div>
          <!-- プロフィール写真 -->
          <div class="form-group">
            <label class="col-sm-4 control-label">プロフィール写真</label>
            <div class="col-sm-8">
              <input type="file" name="picture_path" class="form-control">
            </div>
          </div>

          <input type="submit" class="btn btn-default" value="確認画面へ">
        </form>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets/js/jquery-3.1.1.js"></script>
    <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
  </body>
</html></html>