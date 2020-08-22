<?php ob_start();

require_once '../vendor/autoload.php';
require_once '../app/config/config.php';
require_once 'interfaces/model.php';
require_once 'libraries/Controller.php';
require_once 'libraries/Core.php';
require_once 'libraries/Illuminate.php';
require_once 'helpers/functions.php';

spl_autoload_register(function ($classname) {
    $file = str_replace('\'', '/', $classname);
    if (file_exists($file)) {
        require_once "$file.php";
    }
});

$container = new \App\Cms\libraries\Container();
$container->get('\\App\\Cms\\libraries\\Core');