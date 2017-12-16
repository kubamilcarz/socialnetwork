<?php

class Post {

     # privacy = 1 => private
     # privacy = 2 => public
     public function getPostDate($dob) {
          $exploded_dob = explode('-', $dob);
          $day = $exploded_dob[2];
          $month = $exploded_dob[1];
          $year = $exploded_dob[0];

          $d_0num = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];
          $d_num = ["1.", "2.", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];
          $pday = str_replace($d_0num, $d_num, $day);

          $m_num = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
          $m_pol = array("Stycznia", "Lutego", "Marca", "Kwietnia", "Maja", "Czerwca", "Lipca", "Sierpnia", "Września", "Października", "Listopada", "Grudnia");
          $pmonth = str_replace($m_num, $m_pol, $month);

          echo $pday . " ". $pmonth . " " . $year;
     }

     public function getPostDM($dob) {
          $exploded_dob = explode('-', $dob);
          $day = $exploded_dob[2];
          $month = $exploded_dob[1];

          $d_0num = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];
          $d_num = ["1.", "2.", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];
          $pday = str_replace($d_0num, $d_num, $day);

          $m_num = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
          $m_pol = array("Stycznia", "Lutego", "Marca", "Kwietnia", "Maja", "Czerwca", "Lipca", "Sierpnia", "Września", "Października", "Listopada", "Grudnia");
          $pmonth = str_replace($m_num, $m_pol, $month);

          echo $pday . " ". $pmonth;
     }

     public function createPost($body, $userid, $privacy) {
          if ($userid == Auth::loggedin()) {
               if (strlen($body) >= 5 && strlen($body) <= 256) {
                    if ($privacy == "1" || $privacy == "2") {
                         $date = date('Y-m-d');
                         if (!DB::query('SELECT posts_id FROM posts WHERE posts_body=:body AND posts_date=:pdate AND posts_userid=:userid AND posts_privacy=:privacy', [':body'=>$body, ':pdate'=>$date, ':userid'=>$userid, ':privacy'=>$privacy])) {

                              DB::query('INSERT INTO posts VALUES (\'\', :body, NOW(), :userid, :privacy, 0, 0)', [':body'=>$body, ':userid'=>$userid, ':privacy'=>$privacy]);
                              if ($privacy == "1") {
                                   Auth::$error = "Pomyślnie opublikowano prywatny post!";
                              }else if ($privacy == "2") {
                                   Auth::$error = "Pomyślnie opublikowano publiczny post!";
                              }

                         }else {Auth::$error = "Nie duplikuj postów!";}


                    }
               }else {Auth::$error = "Post może mieć (min: 5 znaków, a max: 256 znaków)!";}
          }else {Auth::$error = "Bład przy tworzeniu posta!";}
     }

     public function editPost($body, $userid, $privacy, $postid) {
          $post = DB::query('SELECT * FROM posts WHERE posts_userid=:userid AND posts_id=:postid', [':userid'=>$userid, ':postid'=>$postid]);
          if (DB::query('SELECT * FROM posts WHERE posts_userid=:userid AND posts_id=:postid', [':userid'=>$userid, ':postid'=>$postid])) {
               if ($userid == Auth::loggedin()) {
                    if (strlen($body) >= 5 && strlen($body) <= 256) {
                         if ($privacy == "1" || $privacy == "2") {
                              $date = date('Y-m-d');

                              DB::query('INSERT INTO posts VALUES (\'\', :body, NOW(), :userid, :privacy, 0, 0)', [':body'=>$body, ':userid'=>$userid, ':privacy'=>$privacy]);
                              if ($privacy == "1") {
                                   Auth::$error = "Pomyślnie opublikowano prywatny post!";
                              }else if ($privacy == "2") {
                                   Auth::$error = "Pomyślnie opublikowano publiczny post!";
                              }
                         }
                    }else {Auth::$error = "Post może mieć (min: 5 znaków, a max: 256 znaków)!";}
               }else {Auth::$error = "Bład przy edytowaniu posta!";}
          }else {Auth::$error = "Wystąpił problem!";}
     }

     public function updatePost($body, $userid, $privacy, $postid) {
          if ($userid == Auth::loggedin()) {
               if (strlen($body) >= 5 && strlen($body) <= 256) {
                    if ($privacy == "1" || $privacy == "2") {
                         DB::query('UPDATE posts SET posts_body=:body, posts_privacy=:privacy WHERE posts_userid=:userid AND posts_id=:postid', [':body'=>$body, ':privacy'=>$privacy, ':userid'=>$userid, ':postid'=>$postid]);
                         if ($privacy == "1") {
                              Auth::$error = "Pomyślnie zaktualizowano prywatny post!";
                         }else if ($privacy == "2") {
                              Auth::$error = "Pomyślnie zaktualizowano publiczny post!";
                         }
                    }
               }else {Auth::$error = "Post może mieć (min: 5 znaków, a max: 256 znaków)!";}
          }else {Auth::$error = "Bład przy tworzeniu posta!";}
     }

     public function deletePost($postid) {
          if (Auth::loggedin()) {
               $userid = DB::query('SELECT posts_userid FROM posts WHERE posts_id=:postid', [':postid'=>$postid])[0]['posts_userid'];
               DB::query('DELETE FROM comments WHERE comments_postid=:postid', [':postid'=>$postid]);
               DB::query('DELETE FROM post_likes WHERE post_likes_postid=:postid', [':postid'=>$postid]);
               DB::query('DELETE FROM posts WHERE posts_id=:postid', [':postid'=>$postid]);
               Auth::$error = "Pomyślnie usunięto post!";
               header("Location: ../profile/" . $userid);
               exit();

          }else {Auth::$error = "Żeby móc usuwać posty musisz być zalogowany!";}
     }

     public function likePost($userid, $postid) {
          if ($userid == Auth::loggedin()) {
               $date = date('Y-m-d');
               if (!DB::query('SELECT post_likes_postid FROM post_likes WHERE post_likes_postid=:postid', [':postid'=>$postid])) {
                    DB::query('INSERT INTO post_likes VALUES (\'\', 1, :userid, :postid, :pldate)', [':userid'=>$userid, ':postid'=>$postid, ':pldate'=>$date]);

                    $number_of_likes = DB::query('SELECT posts_likes FROM posts WHERE posts_id=:postid', [':postid'=>$postid])[0]['posts_likes'];
                    $plikes = $number_of_likes + 1;
                    DB::query('UPDATE posts SET posts_likes=:plikes WHERE posts_id=:postid', [':plikes'=>$plikes, ':postid'=>$postid]);

                    $userGender = DB::query('SELECT user_gender FROM users WHERE user_user_id=:userid', [':userid'=>$userid])[0]['user_gender'];
                    if ($userGender == "m") {
                         Auth::$error = "Polubiłeś post!";
                    }else {
                         Auth::$error = "Polubiłaś post!";
                    }

               }else {Auth::$error = "Ten post został już przez ciebie polubiany!";}
          }else {Auth::$error = "Wystąpił problem podczas próby polubienia posta! Prosimy spróbować ponownie.";}
     }


     public function unlikePost($userid, $postid) {
          if ($userid == Auth::loggedin()) {
               if (DB::query('SELECT post_likes_postid FROM post_likes WHERE post_likes_postid=:postid', [':postid'=>$postid])) {

                    DB::query('DELETE FROM post_likes WHERE post_likes_userid=:userid AND post_likes_postid=:postid', [':userid'=>$userid, ':postid'=>$postid]);

                    $number_of_likes = DB::query('SELECT posts_likes FROM posts WHERE posts_id=:postid', [':postid'=>$postid])[0]['posts_likes'];
                    $plikes = $number_of_likes - 1;
                    DB::query('UPDATE posts SET posts_likes=:plikes WHERE posts_id=:postid', [':plikes'=>$plikes, ':postid'=>$postid]);

                    Auth::$error = "Nie lubisz już tego postu!";

               }else {Auth::$error = "Ten post został już przez ciebie polubiany!";}
          }else {Auth::$error = "Wystąpił problem podczas próby polubienia posta! Prosimy spróbować ponownie.";}
     }

     public function displayPostsOnProfile($userid) {
          if (Auth::loggedin()) {
               // if ($userid == Auth::loggedin()) {
                    $posts = DB::query('SELECT * FROM posts, users WHERE posts_userid=:puserid AND user_user_id=:userid ORDER BY posts_id DESC', [':puserid'=>$userid, ':userid'=>$userid]);
                    foreach ($posts as $post) {
                         if ($post['posts_privacy'] == "2") { ?>
                              <div class="post">
                                   <header class="post__header">
                                        <a href=""><img class="post_header__img" src="<?= $post['user_profile_picture']; ?>"/></a>
                                        <div class="post_header__user_info">
                                             <h1 class="post_header__name"><?= $post['user_full_name']; ?><span class="username">@<?= $post['user_username']; ?></span></h1>
                                             <?php if (substr($post['posts_date'], 0, 4) != date('Y')) { ?>
                                                  <p class="post_header_date"><i class="fa fa-clock-o"></i><?= self::getPostDate($post['posts_date']); ?></p>
                                             <?php }else { ?>
                                                  <p class="post_header_date"><i class="fa fa-clock-o"></i><?= self::getPostDM($post['posts_date']); ?></p>
                                             <?php } ?>
                                        </div>
                                   </header>
                                   <div class="post__content">
                                        <p><?= $post['posts_body']; ?></p>
                                   </div>
                                   <div class="post__integration">
                                        <?php if (!DB::query('SELECT post_likes_postid FROM post_likes WHERE post_likes_postid=:postid', [':postid'=>$post['posts_id']])) { ?>
                                             <button class="post_btn" id="likePost<?php echo $post['posts_id'] ?>">
                                                  <i class="fa fa-thumbs-up"></i>
                                                  <span>
                                                       Lubię to!<span>
                                                       <?php if ($post['posts_likes'] != 0) {echo '(' . $post['posts_likes'] . ')';} ?></span>
                                                  </span>
                                             </button>
                                        <?php }else { ?>
                                             <button class="post_btn active" id="unlikePost<?php echo $post['posts_id']; ?>">
                                                  <i class="fa fa-thumbs-up"></i>
                                                  <span>
                                                       Lubię to!<span>
                                                       <?php if ($post['posts_likes'] != 0) {echo '(' . $post['posts_likes'] . ')';} ?></span>
                                                  </span>
                                             </button>
                                        <?php } ?>

                                        <input type="hidden" class="profileUserId" value="<?php echo $post['posts_userid']; ?>">
                                        <input type="hidden" id="Likepostid<?php echo $post['posts_id']; ?>" value="<?php echo $post['posts_id']; ?>">
                                   </div>
                                   <div class="post__comments">
                                        <div class="comments">
                                             <?php echo Comment::displayComments($post['posts_id']); ?>
                                        </div>

                                        <div class="post_comments__form">
                                             <?php $loggedinUserImg = DB::query('SELECT user_profile_picture FROM users WHERE user_user_id=:userid', [':userid'=>Auth::loggedin()])[0]['user_profile_picture']; ?>
                                             <img src="<?= $loggedinUserImg; ?>"/>
                                             <input type="hidden" name="commentpostid" id="commentpostid<?php echo $post['posts_id']; ?>" value="<?php echo $post['posts_id']; ?>">
                                             <input type="text" name="commentbody" id="commentbody<?php echo $post['posts_id']; ?>" placeholder="Napisz komentarz..."/>
                                             <button type="submit" name="send" id="commentPost<?php echo $post['posts_id']; ?>"><i class="fa fa-angle-right"></i></button>
                                        </div>
                                   </div>
                              </div>
                              <script>
                                   $("#likePost<?php echo $post['posts_id'] ?>").click(function() {
                                        var profileUserId = $(".profileUserId").val();
                                        var LpostId = $("#Likepostid<?php echo $post['posts_id'] ?>").val();
                                        $.post("./../app/api/profile.php", {
                                             profileUserId: profileUserId,
                                             likePostid: LpostId
                                        }, function(data, status) {
                                             $("#ajaxRefresh").html(data);
                                        });
                                   });
                                   $("#unlikePost<?php echo $post['posts_id'] ?>").click(function() {
                                        var profileUserId = $(".profileUserId").val();
                                        var LpostId = $("#Likepostid<?php echo $post['posts_id'] ?>").val();
                                        $.post("./../app/api/profile.php", {
                                             profileUserId: profileUserId,
                                             unlikePostid: LpostId
                                        }, function(data, status) {
                                             $("#ajaxRefresh").html(data);
                                        });
                                   });

                                   $("#commentbody<?php echo $post['posts_id']; ?>").keypress(function(e) {
                                        if(e.which == 13) {
                                             var profileUserId = $(".profileUserId").val();
                                             var commentBody = $("#commentbody<?php echo $post['posts_id']; ?>").val();
                                             var commentpostid = $("#commentpostid<?php echo $post['posts_id']; ?>").val();
                                             $.post("./../app/api/profile.php", {
                                                  profileUserId: profileUserId,
                                                  commentBody: commentBody,
                                                  commentpostid: commentpostid
                                             }, function(data, status) {
                                                  $("#ajaxRefresh").html(data);
                                             });
                                        }
                                   });
                              </script>
                         <?php }else { ?>
                              <div class="post">
                                   <header class="post__header">
                                        <a href=""><img class="post_header__img" src="<?= $post['user_profile_picture']; ?>"/></a>
                                        <div class="post_header__user_info">
                                             <h1 class="post_header__name"><?= $post['user_full_name']; ?><span class="username">@<?= $post['user_username']; ?></span></h1>
                                             <?php if (substr($post['posts_date'], 0, 4) != date('Y')) { ?>
                                                  <p class="post_header_date"><i class="fa fa-clock-o"></i><?= self::getPostDate($post['posts_date']); ?></p>
                                             <?php }else { ?>
                                                  <p class="post_header_date"><i class="fa fa-clock-o"></i><?= self::getPostDM($post['posts_date']); ?></p>
                                             <?php } ?>
                                        </div>
                                   </header>
                                   <div class="post__content">
                                        <p><?= $post['posts_body']; ?></p>
                                   </div>
                              </div>
                         <?php }

                    }
               // }else {
               //      $posts = DB::query('SELECT * FROM posts, users WHERE posts_userid=:puserid AND user_user_id=:userid AND posts_privacy=2 ORDER BY posts_id DESC', [':puserid'=>$userid, ':userid'=>$userid]);
               //      foreach ($posts as $post) {
               //           echo $post['user_full_name'] . " ~ ";
               //           echo $post['posts_body'] . "<br><hr>";
               //      }
               // }
          }

     }

}
