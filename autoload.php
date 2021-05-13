<?php

function class_autoloader($class) {
    include  $class . '.class.php';
}

spl_autoload_register('class_autoloader');