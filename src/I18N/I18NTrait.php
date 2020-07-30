<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\I18N;


trait I18NTrait
{
    public static function i18nCategory()
    {
        return 'xcrm/default';
    }

    public static function t($message, $params = [])
    {
        return \Yii::t(static::i18nCategory(), $message, $params);
    }

    public static function r($message, $params = [])
    {
        return \Yii::t('app/' . \Yii::$app->id, $message, $params);
    }
}