<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Website\BackOffice;
use XCrm\Modules\Website\BackOffice\Controller\DefaultController;
use XCrm\Modules\Website\BackOffice\Controller\LegalController;
use XCrm\Modules\Website\BackOffice\Controller\ServiceController;
use XCrm\Modules\Website\Model\Page;

class Module extends \XCrm\Modules\Website\Module
{
    public static function getTitle()
    {
        return 'Структура сайта';
    }

    public function coreControllerMap()
    {
        return [
            'default' => DefaultController::class,
            'legal'   => LegalController::class,
            'service' => ServiceController::class,
        ];
    }

    public static function getNavigation()
    {
        return [
            'section' => 'content',
            'icon' => 'website',
            'title' => static::getTitle(),
            'links' => [
                ['label' => 'Структура сайта', 'url' => ['default/index'], 'visible' => true],
                ['label' => 'Добавить страницу',  'url' => ['default/create'], 'visible' => Page::allowsCreate()],
                ['label' => 'Юридическая информация',  'url' => ['legal/index'], 'visible' => true],
                ['label' => 'Служебные страницы',  'url' => ['service/index'], 'visible' => true],
            ]
        ];
    }

    public function __construct($id, $parent = null, $config = [])
    {
        $config['viewPath'] = $config['viewPath'] ?? dirname(__DIR__) . '/resource/views';
        parent::__construct($id, $parent, $config);
    }
}