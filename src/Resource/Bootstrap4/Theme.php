<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Resource\Bootstrap4;

use XCrm\Form\ActiveForm;
use XCrm\Helper\ArrayHelper;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use Yii;


class Theme extends \XCrm\Application\Web\Theme
{
    public function __get($name)
    {
        return Html::class;
    }

    public function getCoreWidgets()
    {
        return ArrayHelper::merge(parent::getCoreWidgets(), [
            'form' => ActiveForm::class,
            'breadcrumbs' => Breadcrumbs::class
        ]);
    }

    public function init()
    {
        Yii::$app->params['bsVersion'] = 4;
        parent::init();
    }
}