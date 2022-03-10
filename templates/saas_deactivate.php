<?php

include "config.php";

try {
    $pdo = new PDO('pgsql:host=localhost;dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
    # deactivate all users
    $statement = $pdo->prepare("update public.users set is_active=false");
    $statement->execute();
  }
  catch (Exception $e) {
      // echo 'Exception caught: ',  $e->getMessage(), "\n";
      echo "error happened";
      exit(1);
  }
?>