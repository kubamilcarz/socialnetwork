<?php
require_once('./app/autoload.php');

if (Auth::loggedin()) {header("Location: index.php");exit();}

if (isset($_POST['registerbtn'])) {
     Auth::register($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['uname'], $_POST['pass'], $_POST['pass'], $_POST['birthD'], $_POST['birthM'], $_POST['birthY'], $_POST['sex']);
}

?>
<!DOCTYPE html>
<html lang="<?= init::$app_lang; ?>">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>rejestracja - <?= init::$app_name; ?></title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="/social-network/assets/css/main.css">
</head>
<body>
     <?php
     require_once("app/modules/nav-guest.php");
     echo Auth::$error;
     require_once("app/modules/auth/register.php");
     ?>
     <script src="assets/js/juery.js"></script>
     <script src="assets/js/functions.js"></script>
</body>
</html>
