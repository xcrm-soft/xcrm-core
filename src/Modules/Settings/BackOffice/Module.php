<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Settings\BackOffice;
use XCrm\Modules\Settings\BackOffice\Controller\SettingsDashboardController;


class Module extends \XCrm\Modules\Settings\Module
{
    public function coreControllerMap()
    {
        return [
            'default' => SettingsDashboardController::class,
        ];
    }

    public static function getNavigation()
    {
        return [
            'section' => 'extra',
            'icon' => 'settings',
            'title' => static::getTitle(),
            'links' => [
                ['label' => 'Настройки приложений', 'url' => ['default/index'], 'visible' => true],
                ['label' => 'Интернационализация',  'url' => ['i18n/index'], 'visible' => true],
                ['label' => 'Справочники',  'url' => ['/reference'], 'visible' => true],
            ]
        ];
    }

    public function __construct($id, $parent = null, $config = [])
    {
        $config['viewPath'] = $config['viewPath'] ?? dirname(dirname(dirname(dirname(__DIR__)))) . '/resource/Settings/Backoffice/views';
        parent::__construct($id, $parent, $config);
    }
}