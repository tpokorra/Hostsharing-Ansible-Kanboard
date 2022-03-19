<?php

include "/home/pacs/{{pac}}/users/{{user}}/kanboard/config.php";

function Get($index, $defaultValue) {
    return isset($_GET[$index]) ? $_GET[$index] : $defaultValue;
}

# check SaasActivationPassword
if (Get('SaasActivationPassword', 'invalid') != '{{SaasActivationPassword}}') {
  echo '{"success": false, "msg": "invalid SaasActivationPassword"}';
  exit(1);
}

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