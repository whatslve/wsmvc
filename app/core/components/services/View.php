<?php
namespace app\core\components\services;
/**
 * Class View
 * @package app\core\components\services
 */
class View
{
    /**
     * @var null
     */
    protected $resPath = null;
	function __construct($resPath)
    {
        $this->resPath = $resPath;
    }

    /**
	 * 
	 * @param string $viewName
	 * @param array $params
	 * @param string $layout
	 */
	public function make($viewName, array $params = [], $layout = null)
	{

		//Импортируем переменные из массива в текущую таблицу символов.
		if($params)
		{
			extract($params);
		}

		//Если не указан шаблон, то устанавливаем стандартный
		if ($layout === NULL){
			$layout = 'site_layout';
		}
		//Загружаем шаблон если нужно
		if($layout != false){
			//Формируем путь к шаблону
			require_once ($this->resPath.'/views/layouts/'.$layout.'.php');
			
		}else{
			//формируем путь к отображению
			require_once ($this->resPath.'/views/'.$viewName.'.php');
		
		}
		
	}
	

}