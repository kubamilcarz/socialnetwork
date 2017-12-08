<?php
require_once('./app/autoload.php');

$profileID = $_GET['u'];


if (DB::query('SELECT user_user_id FROM users WHERE user_user_id=:userid', [':userid'=>$profileID])) {
     # user exist
     $profileUser = DB::query('SELECT * FROM users WHERE user_user_id=:userid', [':userid'=>$profileID])[0];
     ?>

     <!DOCTYPE html>
     <html lang="en">
     <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <meta http-equiv="X-UA-Compatible" content="ie=edge">
          <title><?= $profileUser['user_full_name']; ?></title>
     </head>
     <body>
          <img src="<?= $profileUser['user_profile_picture']; ?>" height="205">
          <h1><?= $profileUser['user_full_name']; ?></h1>
          <hr>
          <ul>
               <li><a href="./friends/<?= $profileUser['user_user_id']; ?>">znajomi</a></li>
               <li><a href="">informacje</a></li>
               <li><a href="./albums/<?= $profileUser['user_user_id']; ?>">zdjęcia</a></li>
               <li></li>
               <li><a href="">dodaj do znajomych</a></li>
          </ul>
          <hr>

     </body>
     </html>

     <?php
}else {
     #user doesn't exist
     header("index.php");
     exit();
}

?>
