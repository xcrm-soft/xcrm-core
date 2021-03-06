<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\BackOffice\controllers;

use Da\User\Helper\AuthHelper;
use Da\User\Module;

class PermissionController extends \Da\User\Controller\PermissionController
{
    public function __construct($id, Module $module, AuthHelper $authHelper, array $config = [])
    {
        $config['viewPath'] = $config['viewPath'] ?? dirname(__DIR__) . '/views/permission';
        parent::__construct($id, $module, $authHelper, $config);
    }
}