<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\I18N\Components\Translations;
use XCrm\Application\ApplicationAwareTrait;
use yii\base\BaseObject;

abstract class AbstractTranslator extends BaseObject
{
    use ApplicationAwareTrait;

    abstract public function translate($message, $language);
}