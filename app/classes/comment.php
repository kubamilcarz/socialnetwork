<?php

class Comment {

     public function createComment($body, $creator, $postid) {
          if ($creator == Auth::loggedin()) {
               if (strlen($body) >= 5 && strlen($body) <= 256) {
                    $date = date('Y-m-d');
                    if (!DB::query('SELECT comments_id FROM comments WHERE comments_body=:body AND comments_date=:pdate AND comments_userid=:userid', [':body'=>$body, ':pdate'=>$date, ':userid'=>$creator])) {

                         DB::query('INSERT INTO comments VALUES (\'\', :body, NOW(), 0, 0, :userid, :postid)', [':body'=>$body, ':userid'=>$creator, ':postid'=>$postid]);

                         $number_of_comments = DB::query('SELECT posts_comments FROM posts WHERE posts_id=:postid', [':postid'=>$postid])[0]['posts_comments'];
                         $pcomments = $number_of_comments + 1;
                         DB::query('UPDATE posts SET posts_comments=:pcomments WHERE posts_id=:postid', [':pcomments'=>$pcomments, ':postid'=>$postid]);
                         Auth::$error = "Pomyślnie opublikowano komentarz!";

                    }else {Auth::$error = "Nie duplikuj komentarzy!";}
               }else {Auth::$error = "Komentarz może mieć (min: 5 znaków, a max: 256 znaków)!";}
          }else {Auth::$error = "Bład przy tworzeniu komentarza!";}
     }

     public function displayComments($postid) {
          $comments = DB::query('SELECT * FROM comments, users, posts WHERE comments_postid=:postid AND comments_userid=user_user_id AND posts_id=comments_postid ORDER BY comments_id DESC', [':postid'=>$postid]);

          foreach ($comments as $comment) {
               echo '<div>
                    <h3>' . $comment['user_full_name'] . '</h3>
                    <p>' . $comment['comments_date'] . '</p>
                    <hr>
                    ' . $comment['comments_body'] . '
                    <hr>
                    <p>likes: <b>' . $comment['comments_likes'] . '</b></p>
                    <hr>
               </div>';
          }
     }

}
