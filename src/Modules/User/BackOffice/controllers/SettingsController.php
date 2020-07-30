<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\BackOffice\controllers;
use Da\User\Module;
use Da\User\Query\ProfileQuery;
use Da\User\Query\SocialNetworkAccountQuery;
use Da\User\Query\UserQuery;


class SettingsController extends \Da\User\Controller\SettingsController
{
    public function __construct($id, Module $module, ProfileQuery $profileQuery, UserQuery $userQuery, SocialNetworkAccountQuery $socialNetworkAccountQuery, array $config = [])
    {
        $config['viewPath'] = $config['viewPath'] ?? dirname(__DIR__) . '/views/settings';
        parent::__construct($id, $module, $profileQuery, $userQuery, $socialNetworkAccountQuery, $config);
    }
}