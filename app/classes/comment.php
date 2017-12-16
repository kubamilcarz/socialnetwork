<?php

class Comment {

     public function createComment($body, $userid, $postid) {
          if ($userid == Auth::loggedin()) {
               if (strlen($body) >= 1 && strlen($body) <= 128) {
                    $date = date('Y-m-d');
                    if (!DB::query('SELECT comments_id FROM comments WHERE comments_body=:body AND comments_date=:pdate AND comments_userid=:userid AND comments_postid=:postid', [':body'=>$body, ':pdate'=>$date, ':userid'=>$userid, ':postid'=>$postid])) {

                         DB::query('INSERT INTO comments VALUES (\'\', :body, NOW(), 0, 0, :userid, :postid)', [':body'=>$body, ':userid'=>$userid, ':postid'=>$postid]);
                         Activity::addPoints(2, 3, $userid);
                         $number_of_comments = DB::query('SELECT posts_comments FROM posts WHERE posts_id=:postid', [':postid'=>$postid])[0]['posts_comments'];
                         $pcomments = $number_of_comments + 1;
                         DB::query('UPDATE posts SET posts_comments=:pcomments WHERE posts_id=:postid', [':pcomments'=>$pcomments, ':postid'=>$postid]);
                         Auth::$error = "Pomyślnie opublikowano komentarz!";

                    }else {Auth::$error = "Nie duplikuj komentarzy!";}
               }else {Auth::$error = "Komentarz może mieć (min: 5 znaków, a max: 256 znaków)!";}
          }else {Auth::$error = "Bład przy tworzeniu komentarza!";}
     }

     public function displayCommentsOnProfile($postid) {
          $comments = DB::query('SELECT * FROM comments, users, posts WHERE comments_postid=:postid AND comments_userid=user_user_id AND posts_id=comments_postid ORDER BY comments_id DESC', [':postid'=>$postid]);

          foreach ($comments as $comment) { ?>
               <div class="comment">
                    <a href=""><img class="post_header__img" src="<?= $comment['user_profile_picture']; ?>"/></a>
                    <div class="content" style="width: auto;">
                         <div class="body">
                              <p><?= $comment['comments_body'] ?></p>
                         </div>
                         <div class="info">
                              <?php if (!DB::query('SELECT comment_likes_commentid FROM comment_likes WHERE comment_likes_commentid=:commentid', [':commentid'=>$comment['comments_id']])) { ?>
                                   <input type="hidden" id="likeCommentPostid<?php echo $comment['posts_userid']; ?>" value="<?php echo $postid; ?>">
                                   <input type="hidden" id="likecommentid<?php echo $comment['comments_id']; ?>" value="<?php echo $comment['comments_id']; ?>">
                                   <input type="hidden" class="profileUserId" value="<?php echo $comment['posts_userid']; ?>">
                                   <button class="comment_btn" id="likeComment<?php echo $comment['comments_id']; ?>">
                                        <i class="fa fa-thumbs-up"></i>
                                        <span>
                                             Lubię to!<span>
                                             <?php if ($comment['comments_likes'] != 0) {echo '(' . $comment['comments_likes'] . ')';} ?></span>
                                        </span>
                                   </button>
                                   <script>
                                        $("#likeComment<?php echo $comment['comments_id']; ?>").click(function() {
                                             var profileUserId = $(".profileUserId").val();
                                             var LikeCommentId = $("#likecommentid<?php echo $comment['comments_id']; ?>").val();
                                             var likeCommentPostid = $("#likeCommentPostid<?php echo $comment['posts_userid']; ?>").val();
                                             $.post("/social-network/app/api/profile.php", {
                                                  profileUserId: profileUserId,
                                                  likeCommentid: LikeCommentId,
                                                  likeCommentPostid: likeCommentPostid
                                             }, function(data, status) {
                                                  $("#ajaxRefresh").html(data);
                                             });
                                        });
                                   </script>
                              <?php }else { ?>
                                   <input type="hidden" id="unlikeCommentPostid<?php echo $comment['posts_userid']; ?>" value="<?php echo $postid; ?>">
                                   <input type="hidden" id="unlikecommentid<?php echo $comment['comments_id']; ?>" value="<?php echo $comment['comments_id']; ?>">
                                   <input type="hidden" class="unprofileUserId" value="<?php echo $comment['posts_userid']; ?>">

                                   <button class="comment_btn" style="color: #007bb5;" id="unlikeComment<?php echo $comment['comments_id']; ?>">
                                        <i class="fa fa-thumbs-up"></i>
                                        <span>
                                             Lubię to!<span>
                                             <?php if ($comment['comments_likes'] != 0) {echo '(' . $comment['comments_likes'] . ')';} ?></span>
                                        </span>
                                   </button>
                                   <script>
                                        $("#unlikeComment<?php echo $comment['comments_id']; ?>").click(function() {
                                             var unprofileUserId = $(".unprofileUserId").val();
                                             var unLikeCommentId = $("#unlikecommentid<?php echo $comment['comments_id']; ?>").val();
                                             var unlikeCommentPostid = $("#unlikeCommentPostid<?php echo $comment['posts_userid']; ?>").val();
                                             $.post("/social-network/app/api/profile.php", {
                                                  unprofileUserId: unprofileUserId,
                                                  unlikeCommentid: unLikeCommentId,
                                                  unlikeCommentPostid: unlikeCommentPostid
                                             }, function(data, status) {
                                                  $("#ajaxRefresh").html(data);
                                             });
                                        });
                                   </script>
                              <?php } ?>

                         </div>

                    </div>
               </div>

          <?php }
     }

     public function likeComment($userid, $commentid, $postid) {
          if ($userid == Auth::loggedin()) {
               $date = date('Y-m-d');
               if (!DB::query('SELECT comment_likes_commentid FROM comment_likes WHERE comment_likes_commentid=:commentid', [':commentid'=>$commentid])) {
                    DB::query('INSERT INTO comment_likes VALUES (\'\', 1, :userid, :commentid, :postid, :cldate)', [':userid'=>$userid, ':commentid'=>$commentid, ':postid'=>$postid, ':cldate'=>$date]);
                    Activity::addPoints(1, 4, $userid);
                    $number_of_likes = DB::query('SELECT comments_likes FROM comments WHERE comments_id=:commentid', [':commentid'=>$commentid])[0]['comments_likes'];
                    $clikes = $number_of_likes + 1;
                    DB::query('UPDATE comments SET comments_likes=:clikes WHERE comments_id=:commentid', [':clikes'=>$clikes, ':commentid'=>$commentid]);

                    $userGender = DB::query('SELECT user_gender FROM users WHERE user_user_id=:userid', [':userid'=>$userid])[0]['user_gender'];
                    if ($userGender == "m") {
                         Auth::$error = "Polubiłeś komentarz!";
                    }else {
                         Auth::$error = "Polubiłaś komentarz!";
                    }

               }else {Auth::$error = "Ten post został już przez ciebie polubiany!";}
          }else {Auth::$error = "Wystąpił problem podczas próby polubienia posta! Prosimy spróbować ponownie.";}
     }

     public function unlikeComment($userid, $commentid, $postid) {
          if ($userid == Auth::loggedin()) {
               if (DB::query('SELECT comment_likes_commentid FROM comment_likes WHERE comment_likes_commentid=:commentid', [':commentid'=>$commentid])) {

                    DB::query('DELETE FROM comment_likes WHERE comment_likes_userid=:userid AND comment_likes_commentid=:commentid', [':userid'=>$userid, ':commentid'=>$commentid]);
                    Activity::removePoints(1, $userid);
                    $number_of_likes = DB::query('SELECT comments_likes FROM comments WHERE comments_id=:commentid', [':commentid'=>$commentid])[0]['comments_likes'];
                    $clikes = $number_of_likes - 1;
                    DB::query('UPDATE comments SET comments_likes=:clikes WHERE comments_id=:commentid', [':clikes'=>$clikes, ':commentid'=>$commentid]);

                    Auth::$error = "Nie lubisz już tego postu!";

               }else {Auth::$error = "Ten post został już przez ciebie polubiany!";}
          }else {Auth::$error = "Wystąpił problem podczas próby polubienia posta! Prosimy spróbować ponownie.";}
     }

}
