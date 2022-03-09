<?php

include "/home/pacs/{{pac}}/users/{{user}}/kanboard/config.php";

function Get($index, $defaultValue) {
  return isset($_GET[$index]) ? $_GET[$index] : $defaultValue;
}

# check SaasActivationPassword
if (Get('SaasActivationPassword', 'invalid') != '{{SaasActivationPassword}}') {
  echo "invalid SaasActivationPassword";
  exit(1);
}

try {
  $pdo = new PDO('pgsql:host=localhost;dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
  $statement = $pdo->prepare("update public.users set email=:email, is_active=true, password='Invalid' where username=:username");
  $statement->execute(array(':email' => Get('UserEmailAddress', 'invalid@solidcharity.com'), ':username' => 'admin'));

  # initiate password reset, without sending the email
  $token = Get('ExpireToken', 'invalid');
  if ($token != 'invalid') {
    $statement = $pdo->prepare("insert into public.password_reset(token, user_id, date_expiration, date_creation, ip, user_agent, is_active)".
      " values(:token, 1, :date_expiration, :date_creation, '127.0.0.1', 'php', true)");
    $statement->execute(array(':token' => $token, ':date_expiration' => time()+24*60*60, 'date_creation' => time()));
  }
}
catch (Exception $e) {
    // echo 'Exception caught: ',  $e->getMessage(), "\n";
    echo "error happened";
    exit(1);
}

# drop this file
unlink(__FILE__);
?>
