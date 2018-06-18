<?php 
  $dsn = 'mysql:dbname=0521_seed_sns;host=localhost';
  $user = 'root';
  $password = '';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->query('SET NAMES UTF8');

 ?>