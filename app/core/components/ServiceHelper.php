<?php
namespace app\core\components;
/**
 * Class ServiceHelper
 * В этом классе мы создаем сервисы
 */
class ServiceHelper
{
    /**
     * @return services\View
     */
    public function view()
    {
        return ServiceLocator::getInstance()->make('view');
    }
    /**
     * @return services\DbConnector
     */
    public function db()
    {
        return ServiceLocator::getInstance()->make('db');
    }

    public function kernel()
    {
        return ServiceLocator::getInstance()->make('kernel');
    }
}
