<?php

function __autoload($class_name) {
     require_once('classes/' . $class_name . '.php');
}

if (isset($_POST['logoutbtn'])) {
     Auth::logout();
}

?>
