<?php

namespace app\engine;
/**
 * Class Kernel
 * @package app\engine
 */
class Kernel
{
    protected $rootPath = null;
    protected $appPath = null;
    protected $resPath = null;
    protected $router = null;

    function __construct($path)
    {
        $this->rootPath = realpath( $path.'/..');
        $this->appPath = $this->rootPath . '/app';
        $this->resPath = $this->rootPath. '/resourses';
        $this->router = new routing\Router($this);
    }

    /**
     * @return null
     */
    public function getAppPath()
    {
        return $this->appPath;
    }

    /**
     * @return null
     */
    public function getResPath()
    {
        return $this->resPath;
    }

    /**
     * @return null
     */
    public function getRootPath()
    {
        return $this->rootPath;
    }

    public function initServices()
    {
        $serviceLocator = \app\core\components\ServiceLocator::getInstance();
        $serviceLocator->addService('db', \app\core\components\services\DbConnector::class, ['root', '', 'localhost', 'wssmvc']);
        $serviceLocator->addService('view', \app\core\components\services\View::class,[$this->resPath]);
        $serviceLocator->addInstance('kernel', $this);
    }

    public function launch()
    {
        $this->initServices();
        $this->router->run();
    }
}