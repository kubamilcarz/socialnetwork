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

if (isset($_POST['cancelAcceptedFriendsRequest'])) {
     $friendid = $_POST['userid'];
     $userid = Auth::loggedin();
     Friend::cancelAcceptedFriendsRequest($userid, $friendid);
}

if (isset($_POST['addToFriendsAgain'])) {
     $friendid = $_POST['userid'];
     $userid = Auth::loggedin();
     Friend::addToFriendsAgain($userid, $friendid);
}

if (isset($_POST['deleteFromFriends'])) {
     $friendid = $_POST['userid'];
     $userid = Auth::loggedin();
     Friend::deleteFromFriends($userid, $friendid);
}

if (isset($_POST['acceptFriendRequest'])) {
     $friendid = $_POST['userid'];
     $userid = Auth::loggedin();
     Friend::acceptFriendRequest($userid, $friendid);
}

# another profile

if (isset($_POST['addToFriendsAgainAnother'])) {
     $friendid = Auth::loggedin();
     $userid = $_POST['userid'];
     Friend::addToFriendsAgain($userid, $friendid);
}

if (isset($_POST['deleteFromFriendsAnother'])) {
     $friendid = Auth::loggedin();
     $userid = $_POST['userid'];
     Friend::deleteFromFriends($userid, $friendid);
}

if (isset($_POST['acceptFriendRequest'])) {
     $friendid = Auth::loggedin();
     $userid = $_POST['userid'];
     Friend::acceptFriendRequest($userid, $friendid);
}

# posts

if (DB::query('SELECT user_user_id FROM users WHERE user_user_id=:userid', [':userid'=>$profileID])) {
     # user exist
     $profileUser = DB::query('SELECT * FROM users WHERE user_user_id=:userid', [':userid'=>$profileID])[0];

     ?>

<!DOCTYPE html>
<html lang="<?= init::$app_lang; ?>">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title><?= $profileUser['user_full_name']; ?></title>
     <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="/social-network/assets/css/main.css">
</head>
<body>
     <?php require_once("app/modules/nav.php"); ?>
     <div id="main-container">
          <div class="container">
               <div class="profile-big-banner">
                    <img class="background" src="<?= $profileUser['user_profile_background_picture']; ?>"/>
                    <div class="overlay"></div>
                    <div class="info">
                         <img class="profile-img" src="<?= $profileUser['user_profile_picture']; ?>"/>
                         <h1 class="name"><?= $profileUser['user_full_name']; ?></h1>
                    </div>
               </div>
               <?= Auth::$error; ?>
               <div class="grid" id="profile">
                    <div class="about column">
                         <div class="stuff">
                              <h1 class="more-space">Informacje</h1>
                              <ul>
                                   <li><i class="fa fa-envelope-o"></i><?= $profileUser['user_email']; ?></li>
                                   <?php if ($profileUser['user_phone'] != 0) { ?>
                                        <li><i class="fa fa-phone-square"></i><?= $profileUser['user_phone']; ?></li>
                                   <?php } ?>
                                   <?php if ($profileUser['user_gender'] == "m") { ?>
                                        <li><i class="fa fa-mars"></i>mężczyzna</li>
                                   <?php }elseif ($profileUser['user_gender'] == "f") { ?>
                                        <li><i class="fa fa-venus"></i>kobieta</li>
                                   <?php }elseif ($profileUser['user_gender'] == "o") { ?>
                                        <li><i class="fa fa-genderless"></i>kobieta</li>
                                   <?php } ?>
                                   <li><i class="fa fa-birthday-cake"></i><?= User::getDob($profileUser['user_dob']); ?></li>
                                   <li><i class="fa fa-globe"></i>punkty: <b><?= $profileUser['user_points']; ?></b></li>
                                   <li class="scroller">
                                        <a href="./friends/<?= $profileUser['user_user_id']; ?>">znajomi</a> <a href="./albums/<?= $profileUser['user_user_id']; ?>">zdjęcia</a>
                                   </li>
                                   <?php if (Auth::loggedin()) {
                                        if ($profileID != Auth::loggedin()) {
                                             if (DB::query('SELECT friends_status FROM friends WHERE friends_friendid=:friendid AND friends_userid=:userid', [':friendid'=>Auth::loggedin(), ':userid'=>$profileID])) {
                                                  $statusY = DB::query('SELECT friends_status FROM friends WHERE friends_friendid=:friendid AND friends_userid=:userid', [':friendid'=>Auth::loggedin(), ':userid'=>$profileID])[0]['friends_status'];
                                                  if ($statusY == "1") {
                                                       echo '<form action="" method="post">
                                                            <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                                            <input type="submit" name="acceptFriendRequest" value="zaakceptuj zaproszenie" class="btn" style="display: block; margin: 10px auto 0 auto;">
                                                       </form>';
                                                       exit();
                                                  }else if ($statusY == "3") {
                                                       echo '<form action="" method="post">
                                                            <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                                            <input type="submit" name="addToFriendsAgainAnother" value="dodaj do znajomych" class="btn" style="display: block; margin: 10px auto 0 auto;">
                                                       </form>';
                                                       exit();
                                                  }else if ($statusY == "4") {
                                                       echo '<form action="" method="post">
                                                            <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                                            <input type="submit" name="deleteFromFriendsAnother" value="usuń ze znajomych" class="btn" style="display: block; margin: 10px auto 0 auto;">
                                                       </form>';
                                                       exit();
                                                  }
                                             }

                                             if (DB::query('SELECT friends_status FROM friends WHERE friends_friendid=:friendid AND friends_userid=:userid', [':friendid'=>$profileID, ':userid'=>Auth::loggedin()])) {

                                                  $friendStatus = DB::query('SELECT friends_status FROM friends WHERE friends_friendid=:friendid AND friends_userid=:userid', [':friendid'=>$profileID, ':userid'=>Auth::loggedin()])[0]['friends_status'];
                                                  if ($friendStatus == "1") {
                                                       echo '<form action="" method="post">
                                                            <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                                            <input type="submit" name="cancelSendedFriendRequest" value="anuluj zaproszenie" class="btn btn-stop-follow" style="display: block; margin: 10px auto 0 auto;">
                                                       </form>';
                                                  }else if ($friendStatus == "2") {
                                                       echo '<form action="" method="post">
                                                            <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                                            <input type="submit" name="cancelAcceptedFriendsRequest" value="usuń ze znajomych" class="btn" style="display: block; margin: 10px auto 0 auto;">
                                                       </form>';
                                                  }else if ($friendStatus == "3") {
                                                       echo '<form action="" method="post">
                                                            <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                                            <input type="submit" name="addToFriendsAgain" value="wyślij jeszcz raz" class="btn" style="display: block; margin: 10px auto 0 auto;">
                                                       </form>';
                                                  }else if ($friendStatus == "4") {
                                                       echo '<form action="" method="post">
                                                            <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                                            <input type="submit" name="deleteFromFriends" value="usuń ze znajomych" class="btn" style="display: block; margin: 10px auto 0 auto;">
                                                       </form>';
                                                  }
                                             }else {
                                                  echo '<form action="" method="post">
                                                       <input type="hidden" name="userid" value="' . $profileUser['user_user_id'] . '">
                                                       <input type="submit" name="addToFriends" value="dodaj do znajomych" class="btn btn-follow" style="display: block; margin: 10px auto 0 auto;">
                                                  </form>';
                                             }
                                        }
                                   } ?>
                              </ul>
                         </div>
                         <!-- <div class="stuff-mobile-modal" id="mobileProfileInfoModal">
                              <header>
                                   <h1>Informacje</h1>
                                   <button id="closeMobileProfileInfoMobile">zamknij<i class="fa fa-close"></i></button>
                              </header>
                              <ul class="content">
                                   <li><i class="fa fa-envelope-o"></i><?= $profileUser['user_email']; ?></li>
                                   <?php if ($profileUser['user_phone'] != 0) { ?>
                                        <li><i class="fa fa-phone-square"></i><?= $profileUser['user_phone']; ?></li>
                                   <?php } ?>
                                   <?php if ($profileUser['user_gender'] == "m") { ?>
                                        <li><i class="fa fa-mars"></i>mężczyzna</li>
                                   <?php }elseif ($profileUser['user_gender'] == "f") { ?>
                                        <li><i class="fa fa-venus"></i>kobieta</li>
                                   <?php }elseif ($profileUser['user_gender'] == "o") { ?>
                                        <li><i class="fa fa-genderless"></i>kobieta</li>
                                   <?php } ?>
                                   <li><i class="fa fa-birthday-cake"></i><?= User::getDob($profileUser['user_dob']); ?></li>
                                   <li><i class="fa fa-globe"></i>punkty: <b><?= $profileUser['user_points']; ?></b></li>
                              </ul>
                         </div> -->
                    </div>
                    <div class="post column">
                         <?php if (Auth::loggedin()) {
                              if ($profileID == Auth::loggedin()) { ?>
                         <header>
                              <button id="newPostModalDesktop">Napisz coś ciekawego...</button>
                              <div class="modal new-post" id="newpostmodalddesktop">
                                   <header>
                                        <h1>Nowy Post</h1>
                                        <button id="closeNewPostModalDesktop">anuluj<i class="fa fa-close"></i></button>
                                   </header>
                                   <div class="form">
                                        <input type="hidden" id="postprofileUserIdD" value="<?= $profileID; ?>">
                                        <textarea id="newpostPostBodyD" name="postbody" placeholder="Napisz coś..."></textarea>
                                        <!-- <input id="newpostPostImg" type="file" name="postimg"/><img src="" id="newpostDesktopImg"/> -->
                                        <select name="privacy" id="newpostPrivacyD">
                                             <option value="0">prywatność</option>
                                             <option value="1">prywatny</option>
                                             <option value="2">publiczny</option>
                                        </select>
                                        <button id="newpostPostSubmitBtnD" type="submit" name="sendpost">napisz post</button>
                                   </div>
                                   <script>
                                        $("#newpostPostSubmitBtnD").click(function() {
                                             var postuserid = $("#postprofileUserIdD").val();
                                             var postbody = $("#newpostPostBodyD").val();
                                             var postprivacy = $("#newpostPrivacyD").val();
                                             $.post("./../app/api/profile.php", {
                                                  postuserid: postuserid,
                                                  postbody: postbody,
                                                  postprivacy: postprivacy
                                             }, function(data, status) {
                                                  $("#ajaxRefresh").html(data);
                                             });
                                        });
                                   </script>
                              </div>
                         </header>
                         <?php }} ?>
                         <div class="posts" id="ajaxRefresh">
                              <?php require_once("app/modules/ajax/postsOnProfile.php"); ?>
                         </div>
                    </div>
     <script src="/social-network/assets/js/jquery.js"></script>

     <script src="/social-network/assets/javascript/functions.js"></script>
</body>
</html>

     <?php
}else {
     # user doesn't exist
     require_once("app/modules/guard-error.html");
     exit();
}

?>
