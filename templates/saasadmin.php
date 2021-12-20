<?php

include "config.php";

function Get($index, $defaultValue) {
  return isset($_GET[$index]) ? $_GET[$index] : $defaultValue;
}

# check SaasActivationPassword
if (Get('SaasActivationPassword', 'invalid') != '{{SaasActivationPassword}}') {
  die("invalid SaasActivationPassword");
}

try {
  $pdo = new PDO('pgsql:host=localhost;dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
  $statement = $pdo->prepare("update users set email=:email, is_active=true, password='Invalid' where username=:username");
  $statement->execute(array(':email' => 'test@solidcharity.com', ':username' => 'admin'));
}
catch (Exception $e) {
    // echo 'Exception caught: ',  $e->getMessage(), "\n";
    die("error happened");
}

# TODO initiate password reset???

?>
