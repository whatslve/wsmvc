<?php

namespace app\engine\routing;

use app\engine\Kernel;

class Router
{
    private $routes = null; // Инициализация свойства для хранения путей (Роутов)
    /**
     * @var Kernel
     */
    protected $kernel = null;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
        $routesPath = $this->kernel->getRootPath() . '/config/routes.php'; // Путь к массиву с роутами
        $this->routes = include($routesPath); // Запоминаем роуты в свойстве

    }

    public function error404()
    {
        header("location:/404.php");
        exit;
    }

    //возвращает строку из запроса браузера
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI']);
        }
    }

    //Возвращает внутренний путь
    private function getInternalRoute($uriPattern, $path, $uri)
    {
        $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
        return explode('/', $internalRoute);
    }

    //Подключает контроллер
    private function includeController($controllerName)
    {
        $controllerFile = $this->kernel->getAppPath() . '/controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            include_once($controllerFile);
            return true;
        } else {
            $this->error404();
        }
    }

    public function run()
    {
        // Получить строку запроса
        $uri = $this->getURI();
        //Проверить наличие такого запроса в routes.php
        $findedRoute = false;
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~^$uriPattern$~iu", $uri)) {

                $findedRoute = true;
                //определить какой контроллер
                //и action с параметрами обрабатывает запрос
                $segments = $this->getInternalRoute($uriPattern, $path, $uri);//Получить внутренний route

                $controllerName = array_shift($segments) . 'Controller';

                $actionName = 'action' . array_shift($segments);

                $parameters = $segments;

                //подключить файл класса контроллера

                $this->includeController($controllerName);
                $controllerName = '\app\controllers\\' . $controllerName;
                $controllerObject = new $controllerName; // объект контроллера
                //Проверить, существует ли action, если нет то перекинуть на 404
                if (!method_exists($controllerObject, $actionName)) {
                    $this->error404();
                }
                //Создать объект, вызвать метод т.е action, и закончить цикл
                if (call_user_func_array([$controllerObject, $actionName], $parameters)) {
                    break;
                }
            }
        }
        if (!$findedRoute) {
            $this->error404();
        }
    }

}