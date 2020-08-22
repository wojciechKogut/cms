<?php
declare(strict_types=1);

namespace App\Cms\libraries;

class Core
{
    private $currentController = "Pages";
    private $currentMethod = "index";
    private $params = [];
    private $container;

    public function __construct(\App\Cms\libraries\Container $container)
    {
        $this->container = $container;

        $url = $this->getUrl();   
        if ($url === null) {
            $this->loadDefaultControler();
            return;
        }

        $controller = ucwords($url[0]);
        if (!file_exists("../app/controllers/" . $controller . ".php")) {
            $this->loadErrorPage();
            return;
        }

        $class = "\\App\\Cms\\controllers\\$controller";
        $this->currentController = $this->container->get($class);
        unset($url[0]);
        if (empty($url[1]) || $url[1] === '' || $url[1] === null) {
            $this->loadDefaultAction($url);
            return;
        }

        if (!method_exists($this->currentController, $url[1])) {
            $this->loadErrorPage();
            unset($url[1]);
            return;
        }

        $this->currentMethod = $url[1];
        unset($url[1]);
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(): ?array
    {
        $url = $_GET['url'];
        if (!isset($url)) {
            return null;
        }

        $urlLength = strlen($url);
        if ($url[$urlLength - 1] != "/") {
            $url = $url . "/";
        }

        $url = explode('/', trim($url));

        return $url;   
    }

    private function loadDefaultControler(): void
    {
        $class = "\\App\\Cms\\controllers\\" . $this->currentController;
        call_user_func_array([$this->container->get($class), $this->currentMethod], $this->params);
    }

    private function loadErrorPage(): void
    {
        require_once 'errorpage.php';
    }

    private function loadDefaultAction(array $url): void
    {
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }
}
