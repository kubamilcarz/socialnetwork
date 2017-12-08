<?php
require_once('./app/autoload.php');

$tokenIsValid = False;
if (Auth::loggedin()) {
     if (isset($_POST['send'])) {
          Auth::changePassword($_POST['opass'], $_POST['npass'], $_POST['rnpass']);
     }
}else {
     if (isset($_GET['token'])) {
          $token = $_GET['token'];
          if (DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))) {
               $userid = DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
               $tokenIsValid = True;
               if (isset($_POST['send'])) {
                    Auth::changePasswordToken($_POST['npass'], $_POST['rnpass']);
               }
          }
     }
}


?>
<!DOCTYPE html>
<html lang="<?= init::$app_lang; ?>">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>change password | <?= init::$app_name; ?></title>

     <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
     <?= Auth::$error; ?>
     <form action="<?php if (!$tokenIsValid) { echo 'change-password.php'; } else { echo 'change-password.php?token='.$token.''; } ?>" method="post">
          <?php if (!$tokenIsValid) { echo '<input type="password" name="opass" placeholder="Old Password">'; } ?>
          <input type="password" name="npass" placeholder="New Password">
          <input type="password" name="rnpass" placeholder="New Repeat Password">
          <input type="submit" name="send" value="change password">
     </form>

     <script src="assets/js/juery.js"></script>
     <script src="assets/js/functions.js"></script>
</body>
</html>
