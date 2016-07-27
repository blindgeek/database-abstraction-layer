<?php

/**
*
* @file autoload.php
*/
spl_autoload_register('my_autoloader');

function my_autoloader($class_name)
{
if (!file_exists('../database/library/' . 'class.' . $class_name . '.php')) {
throw new Exception('Unable to load the necessary class file.');
}

require '../database/library/' . 'class.' . $class_name . '.php';
}