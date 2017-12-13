<?php

class Post {

     # privacy = 1 => private
     # privacy = 2 => public

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
               if ($userid == Auth::loggedin()) {
                    $posts = DB::query('SELECT * FROM posts, users WHERE posts_userid=:puserid AND user_user_id=:userid ORDER BY posts_id DESC', [':puserid'=>$userid, ':userid'=>$userid]);
                    foreach ($posts as $post) {
                         if ($post['posts_privacy'] == "2") {
                              echo '<a href="../posts/' . $post['posts_id'] .'">' . $post['user_full_name'] . " ~ " . $post['posts_body'] . " (" . $post['posts_date'] . ") " . "<br><hr>" . '</a>';
                         }else {
                              echo $post['user_full_name'] . " ~ " . $post['posts_body'] . " (" . $post['posts_date'] . ") " . "<br><hr>";
                         }

                    }
               }else {
                    $posts = DB::query('SELECT * FROM posts, users WHERE posts_userid=:puserid AND user_user_id=:userid AND posts_privacy=2 ORDER BY posts_id DESC', [':puserid'=>$userid, ':userid'=>$userid]);
                    foreach ($posts as $post) {
                         echo $post['user_full_name'] . " ~ ";
                         echo $post['posts_body'] . "<br><hr>";
                    }
               }
          }

     }

}
