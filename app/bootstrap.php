<?php ob_start();

//zalacza wszystkie potrzbne pliki

require_once '../vendor/autoload.php';

require_once '../app/config/config.php';


require_once 'interfaces/model.php';

require_once 'libraries/Controller.php';
require_once 'libraries/Core.php';
//require_once 'libraries/Database.php';
require_once 'libraries/Illuminate.php';
require_once 'helpers/classes.php';

$core = new \App\Cms\libraries\Core();
