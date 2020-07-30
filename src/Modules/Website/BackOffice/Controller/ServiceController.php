<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Website\BackOffice\Controller;
use XCrm\Data\Controller\CrudController;

class ServiceController extends CrudController
{
    public $modelClass = 'website.service';

    public function addModelCrumbs($model)
    {
        $this->crumb($model->name, ['view', 'id' => $model->id]);
    }

    public function beforeAction($action)
    {
        $this->crumb('Структура сайта', ['default/index']);
        $this->crumb('Служебные страницы', ['index']);
        return parent::beforeAction($action);
    }
}