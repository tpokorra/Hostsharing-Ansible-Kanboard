<?php

function Get($index, $defaultValue) {
  return isset($_GET[$index]) ? $_GET[$index] : $defaultValue;
}

# check SaasActivationPassword
if (Get('SaasActivationPassword', 'invalid') != '{{SaasActivationPassword}}') {
  echo '{"success": false, "msg": "invalid SaasActivationPassword"}';
  exit(1);
}

$USER_EMAIL_ADDRESS = Get('UserEmailAddress', '');
if (empty($USER_EMAIL_ADDRESS)) {
  echo '{"success": false, "msg": "missing email address"}';
  exit(1);
}

try {
  $pdo = new PDO('pgsql:host=localhost;dbname={{pac}}_{{user}}', '{{pac}}_{{user}}', '{{password}}');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  # activate the admin and set the email address
  $statement = $pdo->prepare("update public.users set email=:email, is_active=true, password='Invalid' where username=:username and is_active=false");
  $statement->execute(array(':email' => $USER_EMAIL_ADDRESS, ':username' => 'admin'));
}
catch (Exception $e) {
    // echo 'Exception caught: ',  $e->getMessage(), "\n";
    echo '{"success": false, "msg": "error happened"}';
    exit(1);
}

echo '{"success": true}';
?>
