<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application\Web;
use XCrm\Application\ApplicationTrait;
use yii\helpers\ArrayHelper;

class Application extends \yii\web\Application
{
    use ApplicationTrait;

    public function coreComponents()
    {
        return ArrayHelper::merge(parent::coreComponents(), $this->commonCoreComponents(), [
            'view' => ['class' => View::class,],
            'session' => ['class' => Session::class]
        ]);
    }
}