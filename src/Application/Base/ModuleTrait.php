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


trait ModuleTrait
{
    use ApplicationAwareTrait;

    /**
     * @var array массив соответствия идентификаторов моделей ActiveRecord классам мх реализаций
     */
    public $modelMap = [];

    public function coreControllerMap()
    {
        return [];
    }

    public function coreModelMap()
    {
        return [];
    }

    public function model($id)
    {
        return $this->modelMap[$id] ?? null;
    }
}