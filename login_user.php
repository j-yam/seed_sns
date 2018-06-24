<?php 
    
    session_start();
    require('db_connect.php');
    if (!isset($_SESSION['login_id'])) {
          header('Location: login.php');
    } else {

      if (!empty($_GET)) {
            $sql = 'SELECT * FROM `members` LEFT JOIN `tweets` ON `members`.`member_id`=`tweets`.`member_id` WHERE `members`.`member_id`=? ';
            $data = array($_GET['member_id']);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            // $member = $stmt->fetch(PDO::FETCH_ASSOC);
            $tweets = array();
            while (true) {
                  $member = $stmt->fetch(PDO::FETCH_ASSOC);
                  if ($member == false) {
                      break;
                  }
                    $tweets[] = $member;
            }



            // echo '<pre>';
            // var_dump($tweets);
            // echo '</pre>';
      }
    }
 ?>
 <!DOCTYPE html>
 <html lang="ja">
 <head>
  <meta charset="utf-8">
   <title></title>
 </head>
 <body>
    <div>
        <p style="color: red;">nickname</p>
        <p><?php echo $tweets[0]['nickname']; ?></p>
        <p style="color: red;">email</p>
        <p><?php echo $tweets[0]['email']; ?></p>
        <p style="color: red;">全てのコメント</p>
        <?php foreach ($tweets as $tweet): ?>
        <p><?php echo $tweet['tweet']; ?></p>
        <?php endforeach ?>
        <p>image</p>
        <img src="picture_path/<?php echo $tweets[0]['picture_path']; ?>">
    </div>
 </body>
 </html>