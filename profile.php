<?php
require_once('./app/autoload.php');

$profileID = $_GET['u'];

if (isset($_POST['addToFriends'])) {
     $friendid = $_POST['userid'];
     $userid = Auth::loggedin();
     Friend::sendFriendRequest($userid, $friendid);
}

if (isset($_POST['cancelSendedFriendRequest'])) {
     $friendid = $_POST['userid'];
     $userid = Auth::loggedin();
     Friend::cancelSendedFriendRequest($userid, $friendid);
}

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
          <img src="<?= $profileUser['user_profile_picture']; ?>" height="205" width="205">
          <h1><?= $profileUser['user_full_name']; ?></h1>
          <hr>
          <ul>
               <li><a href="./friends/<?= $profileUser['user_user_id']; ?>">znajomi</a></li>
               <li><a href="">informacje</a></li>
               <li><a href="./albums/<?= $profileUser['user_user_id']; ?>">zdjęcia</a></li>
               <li></li>
               <?php if (Auth::loggedin()) { ?>
                    <li>
                         <?php
                         if ($profileID != Auth::loggedin()) {
                              if (DB::query('SELECT friends_status FROM friends WHERE friends_friendid=:friendid AND friends_userid=:userid', [':friendid'=>$profileID, ':userid'=>Auth::loggedin()])) {
                                   $friendStatus = DB::query('SELECT friends_status FROM friends WHERE friends_friendid=:friendid AND friends_userid=:userid', [':friendid'=>$profileID, ':userid'=>Auth::loggedin()])[0]['friends_status'];
                                   if ($friendStatus == "1") {
                                        echo "pending";
                                        echo '<form action="" method="post">
                                             <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                             <input type="submit" name="cancelSendedFriendRequest" value="anuluj">
                                        </form>';
                                   }else if ($friendStatus == "2") {
                                        echo "accepted";
                                        echo '<form action="" method="post">
                                             <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                             <input type="submit" name="cancelAcceptedFriendsRequest" value="anuluj">
                                        </form>';
                                   }else if ($friendStatus == "3") {
                                        echo "canceled";
                                        echo '<form action="" method="post">
                                             <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                             <input type="submit" name="addToFriends" value="wyślij jeszcz raz">
                                        </form>';
                                   }else if ($friendStatus == "4") {
                                        echo "friends";
                                        echo '<form action="" method="post">
                                             <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                             <input type="submit" name="cancelFriendsRelation" value="usuń ze znajomych">
                                        </form>';
                                   }
                              }else {
                                   echo '<form action="" method="post">
                                        <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                        <input type="submit" name="addToFriends" value="dodaj do znajomych">
                                   </form>';
                              }
                         }
                         ?>
                    </li>
               <?php } ?>

          </ul>
          <hr>

     </body>
     </html>

     <?php
}else {
     # user doesn't exist
     header("index.php");
     exit();
}

?>
