<?php

function __autoload($class_name) {
     require_once('classes/' . $class_name . '.php');
}

?>
