<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Email\BackOffice;
use XCrm\Modules\Email\BackOffice\Controller\DefaultController;
use XCrm\Modules\Email\BackOffice\Controller\TemplatesController;
use XCrm\Modules\Email\Model\EmailAddress;
use XCrm\Modules\Email\Model\EmailTemplate;

class Module extends \XCrm\Modules\Email\Module
{
    public function coreModelMap()
    {
        return [
            'address' => EmailAddress::class,
            'template' => EmailTemplate::class,
        ];
    }

    public function coreControllerMap()
    {
        return [
            'default' => DefaultController::class,
            'templates' => TemplatesController::class,
        ];
    }

    public static function getTitle()
    {
        return 'Электронная почта';
    }

    public static function getNavigation()
    {
        return [
            'section' => 'settings',
            'title' => static::getTitle(),
            'icon' => 'email',
            'links' => [
                ['label' => static::t('Шаблоны сообщений'), 'url' => ['templates/index']],
                ['label' => static::t('Почтовые ящики'), 'url' => ['default/index']],
            ]
        ];
    }

    public function init()
    {
        $this->app->view->headingIcon = 'email';
        parent::init();
    }
}