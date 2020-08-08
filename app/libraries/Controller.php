<?php
namespace App\Cms\libraries;
//laduje widok i model

class Controller
{
    public function view($views, $params = [])
    {
        if (file_exists('../app/views/' . $views . '.php')) {
            require_once '../app/views/' . $views . '.php';
        } else {
            die('View doesn\'t exist');
        }
    }

    public function model($model)
    {
        if (file_exists('../app/models/' . ucwords($model) . '.php')) {
            require_once '../app/models/' . ucwords($model) . '.php';
            $model = "\\App\\Cms\\models\\$model";
            
            return new $model();
        } else {
            die('Model doesn\'t exist');
        }
    }
}
