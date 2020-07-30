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
use yii\helpers\ArrayHelper;

abstract class Module extends \yii\base\Module
{
    use ModuleTrait;

    public function __construct($id, $parent = null, $config = [])
    {
        $config['controllerMap'] = ArrayHelper::merge($this->coreControllerMap(), $config['controllerMap'] ?? []);
        $config['modelMap'] = ArrayHelper::merge($this->coreModelMap(), $config['modelMap'] ?? []);
        parent::__construct($id, $parent, $config);
    }
}