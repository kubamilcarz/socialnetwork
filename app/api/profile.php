<?php
function __autoload($class_name) {
     require_once('../classes/' . $class_name . '.php');
}

// posts
if (isset($_POST['postbody'])) {
     Post::createPost($_POST['postbody'], Auth::loggedin(), $_POST['postprivacy']);
     $profileID = $_POST['postuserid'];
     require_once("../modules/ajax/postsOnProfile.php");
}

if (isset($_POST['likePostid'])) {
     Post::likePost(Auth::loggedin(), $_POST['likePostid']);
     $postid = $_POST['likePostid'];
     $profileID = $_POST['profileUserId'];
     require_once("../modules/ajax/postsOnProfile.php");
}

if (isset($_POST['unlikePostid'])) {
     Post::unlikePost(Auth::loggedin(), $_POST['unlikePostid']);
     $postid = $_POST['unlikePostid'];
     $profileID = $_POST['profileUserId'];
     require_once("../modules/ajax/postsOnProfile.php");
}

// comments
if (isset($_POST['commentpostid'])) {
     Comment::createComment($_POST['commentBody'], Auth::loggedin(), $_POST['commentpostid']);
     $profileID = $_POST['profileUserId'];
     require_once("../modules/ajax/postsOnProfile.php");
}

if (isset($_POST['likeCommentid'])) {
     Comment::likeComment(Auth::loggedin(), $_POST['likeCommentid'], $_POST['likeCommentPostid']);
     $commentid = $_POST['likeCommentid'];
     // $postid = $_POST['likeCommentPostid'];
     $profileID = $_POST['profileUserId'];
     require_once("../modules/ajax/postsOnProfile.php");
}

if (isset($_POST['unlikeCommentid'])) {
     Comment::unlikeComment(Auth::loggedin(), $_POST['unlikeCommentid'], $_POST['unlikeCommentPostid']);
     $commentid = $_POST['unlikeCommentid'];
     // $postid = $_POST['likeCommentPostid'];
     $profileID = $_POST['unprofileUserId'];
     require_once("../modules/ajax/postsOnProfile.php");
}
