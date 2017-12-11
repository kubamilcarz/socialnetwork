<?php

function __autoload($class_name) {
     require_once('../classes/' . $class_name . '.php');
}

if (isset($_POST['Cpostid'])) {
     Comment::createComment($_POST['commentBody'], Auth::loggedin(), $_POST['Cpostid']);
     $postid = $_POST['Cpostid'];
     $post = DB::query('SELECT * FROM posts, users WHERE posts_id=:postid AND user_user_id=posts_userid AND posts_privacy=2', [':postid'=>$postid])[0];

     require_once("../modules/ajax/single-post.php");

}

if (isset($_POST['likePostid'])) {
     Post::likePost(Auth::loggedin(), $_POST['likePostid']);
     $postid = $_POST['likePostid'];
     $post = DB::query('SELECT * FROM posts, users WHERE posts_id=:postid AND user_user_id=posts_userid AND posts_privacy=2', [':postid'=>$postid])[0];

     require_once("../modules/ajax/single-post.php");

}

if (isset($_POST['unlikePostid'])) {
     Post::unlikePost(Auth::loggedin(), $_POST['unlikePostid']);
     $postid = $_POST['unlikePostid'];
     $post = DB::query('SELECT * FROM posts, users WHERE posts_id=:postid AND user_user_id=posts_userid AND posts_privacy=2', [':postid'=>$postid])[0];

     require_once("../modules/ajax/single-post.php");

}
