<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\BackOffice\controllers;


class RuleController extends \Da\User\Controller\RuleController
{
    public function __construct($id, $module, $config = [])
    {
        $config['viewPath'] = $config['viewPath'] ?? dirname(__DIR__) . '/views/rule';
        parent::__construct($id, $module, $config);
    }
}