<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\BackOffice;


use XCrm\Modules\User\BackOffice\controllers\DefaultController;
use XCrm\Modules\User\BackOffice\controllers\PermissionController;
use XCrm\Modules\User\BackOffice\controllers\RoleController;
use XCrm\Modules\User\BackOffice\controllers\RuleController;
use XCrm\Modules\User\BackOffice\controllers\SecurityController;
use XCrm\Modules\User\BackOffice\controllers\SettingsController;
use yii\helpers\ArrayHelper;
use Yii;

class Module extends \XCrm\Modules\User\Module
{
    public static function getTitle()
    {
        return 'Управление пользователями';
    }

    public static function getNavigation()
    {
        return [
            'section' => 'settings',
            'title' => static::getTitle(),
            'icon' => 'user',
            'links' => [
                ['label' => Yii::t('usuario', 'Users'), 'url' => ['default/index']],
                ['label' => Yii::t('usuario', 'Permissions'), 'url' => ['role/index']],
                ['label' => Yii::t('usuario', 'New user'), 'url' => ['default/create']],
            ]
        ];
    }

    public function init()
    {
        Yii::$app->view->headingIcon = 'user';
        parent::init();
    }

    public function __construct($id, $parent = null, $config = [])
    {
        parent::__construct($id, $parent, ArrayHelper::merge($config, [
            'controllerMap' => [
                'admin'   => DefaultController::class,
                'default' => DefaultController::class,

                'permission' => PermissionController::class,
                'role' => RoleController::class,
                'rule' => RuleController::class,

                'settings' => SettingsController::class,
                'security' => SecurityController::class,
                'recovery' => \Da\User\Controller\RecoveryController::class,
            ],
            'administratorPermissionName' => 'global/account-administrator-access',
        ]));
    }
}