<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Form;
use XCrm\Application\ApplicationAwareTrait;


trait ActiveFieldTrait
{
    use ApplicationAwareTrait;

    public function widget($class, $config = [])
    {
        $class = $this->app->view->getWidgets()[$class] ?? $class;
        return parent::widget($class, $config);
    }
}