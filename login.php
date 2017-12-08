<?php
require_once('./app/autoload.php');

if (isset($_POST['login'])) {
     Auth::login($_POST['user'], $_POST['pass']);
}

?>
<!DOCTYPE html>
<html lang="<?= init::$app_lang; ?>">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>login | <?= init::$app_name; ?></title>

     <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

     <form action="login.php" method="post">
          <input type="text" name="user" placeholder="Username or E-mail Address">
          <input type="password" name="pass" placeholder="Password">
          <input type="submit" name="login" value="login">
     </form>

     <script src="assets/js/juery.js"></script>
     <script src="assets/js/functions.js"></script>
</body>
</html>
