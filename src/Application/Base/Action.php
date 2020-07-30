<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application\Base;
use XCrm\Application\ApplicationAwareTrait;

abstract class Action extends \yii\base\Action
{
    use ApplicationAwareTrait;
    use ComponentTrait;

    public $viewName = null;

    public function render($params = [])
    {
        return $this->controller->render($this->viewName ?? $this->id, $params);
    }
}