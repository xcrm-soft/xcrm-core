<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\Component;
use XCrm\Application\ApplicationAwareTrait;
use XCrm\Modules\User\Module;

class User extends \yii\web\User
{
    use ApplicationAwareTrait;

    public $sessionContentLanguageKey = 'user.content-language';

    public $loginUrl = ['user/security/login'];
    public $identityClass = \XCrm\Modules\User\Model\User::class;

    public function can($permissionName, $params = [], $allowCaching = true)
    {
        if (!parent::can($permissionName, $params, $allowCaching)) {
            $globalPermissionName = 'all/grant-privileges-' . ('cli' === php_sapi_name() ? 'cli' : 'web');
            return parent::can($globalPermissionName, $params, $allowCaching);
        }
        return true;
    }

    public function getContentLanguage()
    {
        return $this->app->session->get($this->sessionContentLanguageKey, $this->app->language ?: 'ru');
    }

    public function setContentLanguage($language)
    {
        $this->app->session->set($this->sessionContentLanguageKey, $language);
    }

    public function getModule()
    {
        return $this->app->getModule('user');
    }

    public function __construct($config = [])
    {
        if ($module = $this->getModule()) {
            /** @var Module $module */
            if (!isset($config['identityClass'])) $config['identityClass'] = $module->classMap['User'];
        }
        parent::__construct($config);
    }
}