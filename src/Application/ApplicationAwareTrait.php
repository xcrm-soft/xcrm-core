<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application;
use XCrm\Application\Console\Application as ConsoleApplication;
use XCrm\Application\Web\Application;
use XCrm\Frontend\SiteApplication;
use yii\console\Application as YiiConsoleApplication;
use yii\web\Application as YiiApplication;
use Yii;

/**
 * Trait ApplicationAwareTrait
 *
 * @property-read Application|ConsoleApplication $app
 *
 * @package XCrm\Application
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
trait ApplicationAwareTrait
{
    /**
     * Предоставляет доступ к фронт-контроллеру приложения
     * @return Application|ConsoleApplication|YiiApplication|YiiConsoleApplication|SiteApplication
     */
    public function getApp()
    {
        return self::getAppStatic();
    }

    /**
     * Предоставляет доступ к фронт-контроллеру приложения
     * @return Application|ConsoleApplication|YiiApplication|YiiConsoleApplication|SiteApplication
     */
    public static function getAppStatic()
    {
        return Yii::$app;
    }
}