<?php 
    session_start();
    require('db_connect.php');
     // var_dump($_SESSION);
       
       if (!isset($_SESSION['login_id'])) {
           header('index.php');
       }

    if (!empty($_GET)) {
        $sql = 'SELECT `member_id` FROM `tweets` WHERE `tweet_id`=?';
        $data = array($_GET['tweet_id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        $member_id = $stmt->fetch(PDO::FETCH_ASSOC);
        
         // var_dump($member_id);
        $member_sql = 'SELECT * FROM `members` WHERE `member_id`=?';
        $member_data = array($member_id['member_id']);
        $member_stmt = $dbh->prepare($member_sql);
        $member_stmt->execute($member_data);
        var_dump($_SESSION);
        $profile = $member_stmt->fetch(PDO::FETCH_ASSOC);
          var_dump($profile);
    }


 ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
  <meta charset="utf-8">
   <title>profile</title>
 </head>
 <body>
    <div>
      ニックネーム
      <p><?php echo $profile['nickname']; ?></p>
      メールアドレス
      <p><?php echo $profile['email']; ?></p>
      <!-- <p><?php //echo $profile['password']; ?></p>
      <p><?php// echo $profile['picture_path']; ?></p> -->
      <p><img src="picture_path/<?php echo $profile['picture_path']; ?>" width="100" height="100"></p>
    </div>
 </body>
 </html>