<?php
spl_autoload_register(function ($class) {
 $parts = explode("\\", $class);
 $path = '/var/www/8romans.com/cdilabs-new/' . implode(DIRECTORY_SEPARATOR, $parts);
 require_once $path.'.php';
});
