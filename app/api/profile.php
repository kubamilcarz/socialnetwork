<?php
function __autoload($class_name) {
     require_once('../classes/' . $class_name . '.php');
}

if (isset($_POST['likePostid'])) {
     Post::likePost(Auth::loggedin(), $_POST['likePostid']);
     $postid = $_POST['likePostid'];
     $profileID = $_POST['profileUserId'];
     require_once("../modules/ajax/postsOnProfile.php");
}
