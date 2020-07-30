<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application;
use XCrm\I18N\I18NTrait;


trait ControllerTrait
{
    use ApplicationAwareTrait;
    use I18NTrait;

    public static function t($message, $params = [])
    {
        return $message;
    }

    public static function r($message, $params = [])
    {
        return $message;
    }

    public function crumb($message, $url = null, $translate = true)
    {
        $params = [];
        if (is_array($message)) {

        }
        $message = $translate
            ? static::t($message, $params)
            : static::r($message, $params);

        $this->view->params['breadcrumbs'][] = $url
            ? ['url' => $url, 'label' => $message]
            : ['label' => $message];
    }
}