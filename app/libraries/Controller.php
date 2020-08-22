<?php
namespace App\Cms\libraries;

class Controller
{
    public function view($views, $params = []): void
    {
        if (file_exists('../app/views/' . $views . '.php')) {
            require_once '../app/views/' . $views . '.php';
            return;
        } 

        throw new \Exception('View doesn\'t exist');
    }

    public function model(string $model): \App\Cms\interfaces\Model
    {
        if (file_exists('../app/models/' . ucwords($model) . '.php')) {
            require_once '../app/models/' . ucwords($model) . '.php';
            $model = "\\App\\Cms\\models\\$model";
            
            return new $model();
        }
        
        throw new \Exception('Model doesn\'t exists');
    }
}
