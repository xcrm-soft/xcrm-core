<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\BackOffice;

use XCrm\BackOffice\Component\Theme;
use XCrm\BackOffice\Component\View;
use XCrm\I18N\I18NController;
use yii\helpers\ArrayHelper;

class Application extends \XCrm\Application\Web\Application
{
    public function coreComponents()
    {
        return ArrayHelper::merge(parent::coreComponents(), [
            'view' => ['class' => View::class, 'theme' => Theme::class]
        ]);
    }

    public function __construct($config = [])
    {
        \Yii::setAlias('@app/views', dirname(dirname(__DIR__)) . '/resource/BackOffice/views');

        $config['basePath'] = __DIR__;
        $config['controllerNamespace'] = 'XCrm\\BackOffice\\Controller';
        $config['viewPath'] = dirname(dirname(__DIR__)) . '/resource/BackOffice/views';
        $config['controllerMap'] = [
            'content-language' => I18NController::class,
        ];
        parent::__construct($config);
    }
}