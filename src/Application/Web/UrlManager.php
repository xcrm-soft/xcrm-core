<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application\Web;
use XCrm\Application\ApplicationAwareTrait;

class UrlManager extends \yii\web\UrlManager
{
    use ApplicationAwareTrait;

    public $enablePrettyUrl = true;
    public $showScriptName = false;
}