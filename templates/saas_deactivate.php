<?php

include "config.php";

try {
    $pdo = new PDO('pgsql:host=localhost;dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
    $statement = $pdo->prepare("update public.users set is_active=false, password='Invalid' where username=:username");
    $statement->execute(array(':username' => 'admin'));
  }
  catch (Exception $e) {
      // echo 'Exception caught: ',  $e->getMessage(), "\n";
      echo "error happened";
      exit(1);
  }
?>