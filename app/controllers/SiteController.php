<?php
namespace app\controllers;
/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends \app\core\Controller
{

    public function actionIndex()
    {
        $this->view()->make('site/index');
        return true;

    }

}