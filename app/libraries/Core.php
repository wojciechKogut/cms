
<?php

//glowna klasa aplikacji
// odpowiedzialna za przechwytywanie url i ladowanie kontrolerow
//format w jakim url bedzie tworzony : /controller/method/params

class Core
{

    private $currentController = "Pages";
    private $currentMethod = "index";
    private $params = [];
    private $url;

    public function __construct()
    {
        $url = $this->getUrl();
        if (file_exists("../app/controllers/" . ucwords($url[0]) . ".php"))
        {
            require_once "../app/controllers/" . ucwords($url[0]) . ".php";
            $this->currentController = $url[0];
            $this->currentController = new $this->currentController();
            unset($url[0]);
        }
        else
        {
            if (!empty($url[0]))
            {
                require_once 'errorpage.php';
                die();
            }
            else
            {
//                tworzymy obiekt klasy Pages, jesli w url przyjdzie nieodpowiadajaca nazwa klasy
                require_once "../app/controllers/" . $this->currentController . ".php";
                $this->currentController = new $this->currentController();
                unset($url[0]);
            }
        }



        if (isset($url[1]))
        {
            if (method_exists($this->currentController, $url[1]))
            {
                $this->currentMethod = $url[1];
                unset($url[1]);
                $this->params = $url ? array_values($url) : [];
                call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
                return 0;
            }
            else
            {
                if (!empty($url[1]))
                {
                    require_once 'errorpage.php';
                    unset($url[1]);
                    die();
                }
            }
        }
 
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url']))
        {
            $url = $_GET['url'];
            $url_length = strlen($_GET['url']);
            if ($url[$url_length - 1] != "/")
            {
                $url = $url . "/";
            }
            $url = trim($url);
            $url = explode('/', $url);
            return $url;
        }
    }

}
