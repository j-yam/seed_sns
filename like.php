<?php
    session_start();
    require('db_connect.php');

    if (isset($_SESSION['login_id']) && $_SESSION['time'] + 3600 > time()) {
          $_SESSION['time'] = time();
    } else {
          header('Location: login.php');
    }
      if (isset($_GET['like_tweet_id'])) {
            $sql = 'INSERT INTO `likes` SET `tweet_id`=?, `member_id`=?';
            $data = array($_GET['like_tweet_id'], $_SESSION['login_id']);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            header('Location: index.php');
      }
      if (isset($_GET['dislike_tweet_id'])) {
            $sql = 'DELETE FROM `likes` WHERE `tweet_id`=? AND `member_id`=? ';
            $data = array($_GET['dislike_tweet_id'], $_SESSION['login_id']);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            header('Location: index.php');
      }

 ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
  <meta charset="utf-8">
   <title></title>
 </head>
 <body>
    <form action="index.php" method="POST">
      <input type="submit" value="戻る">
    </form>
 </body>
 </html>