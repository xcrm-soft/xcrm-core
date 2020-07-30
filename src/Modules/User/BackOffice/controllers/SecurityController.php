<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\BackOffice\controllers;


use Da\User\Query\SocialNetworkAccountQuery;
use yii\base\Module;

class SecurityController extends \Da\User\Controller\SecurityController
{
    public $layout = '//login';

    public function __construct($id, Module $module, SocialNetworkAccountQuery $socialNetworkAccountQuery, array $config = [])
    {
        $config['viewPath'] = $config['viewPath'] ?? dirname(__DIR__) . '/views/security';
        parent::__construct($id, $module, $socialNetworkAccountQuery, $config);
    }
}