<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Email\BackOffice\Controller;
use XCrm\Data\Controller\CrudController;
use XCrm\Helper\ArrayHelper;
use XCrm\Modules\Email\BackOffice\Controller\Templates\ActionTranslate;
use XCrm\Modules\Email\BackOffice\Controller\Templates\ActionUpdate;

class TemplatesController extends CrudController
{
    public $modelClass = 'email.template';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'create' => [
                'innerView' => '@XCrm/Modules/Email/BackOffice/View/Templates/create'
            ],
            'update' => [
                'innerView' => '@XCrm/Modules/Email/BackOffice/View/Templates/update'
            ],
            'translate' => [
                'class' => ActionTranslate::class,
            ]
        ]);
    }

    public function actionTranslate($id)
    {
        die('translate');
    }
}