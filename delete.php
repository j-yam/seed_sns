<?php 
    session_start();
    require('db_connect.php');

    if (!empty($_GET)) {
        $sql = 'UPDATE `tweets` SET `delete_flag`=? WHERE `tweet_id`=? ';
        $data = array(1, $_GET['tweet_id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        header('location: index.php');
    }

 ?>