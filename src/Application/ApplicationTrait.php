<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application;


use SideKit\Config\ConfigKit;
use XCrm\Application\Component\AttributeManager;
use XCrm\Application\Component\ReferenceManager;
use XCrm\Application\Web\UrlManager;
use XCrm\Database\Connection;
use XCrm\I18N\Components\I18N;
use XCrm\Modules\Email\Component\EmailManager;
use XCrm\Modules\Smarty\Component\SmartyRenderer;
use XCrm\Modules\User\Component\User;
use XCrm\Modules\Website\Component\PageManager;
use yii\rbac\DbManager;

/**
 * Trait ApplicationTrait
 *
 * @property-read Connection $db
 * @property-read DbManager $authManager
 * @property-read User $user
 * @property-read AttributeManager $attributeManager
 * @property-read ReferenceManager $referenceManager
 * @property-read SmartyRenderer $smarty
 * @property-read EmailManager $email
 * @property-read PageManager $pageManager
 *
 * @package XCrm\Application
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
trait ApplicationTrait
{
    public function commonCoreComponents()
    {
        return [
            'db' => ['class' => Connection::class,],
            'authManager' => ['class' => DbManager::class,],
            'user' => ['class' => User::class,],
            'attributeManager' => ['class' => AttributeManager::class,],
            'referenceManager' => ['class' => ReferenceManager::class,],
            'i18n' => ['class' => I18N::class],
            'urlManager' => ['class' => UrlManager::class],
            'smarty' => ['class' => SmartyRenderer::class],
            'email' => ['class' => EmailManager::class],
            'pageManager' => ['class' => PageManager::class]
        ];
    }

    public function env($key, $defaultValue = null)
    {
        return ConfigKit::env()->get($key, $defaultValue);
    }
}