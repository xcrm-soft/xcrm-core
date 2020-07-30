<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Website;
use XCrm\Modules\Website\Model\Page;
use XCrm\Modules\Website\Model\PageLegal;
use XCrm\Modules\Website\Model\PageService;

class Module extends \XCrm\Application\Base\Module
{
    public function coreModelMap()
    {
        return [
            'page' => Page::class,
            'legal' => PageLegal::class,
            'service' => PageService::class,
        ];
    }

    /**
     * @param string $keyName
     */
    public function service($keyName)
    {
        if ($service = $this->model('service')::findOne(['key_name' => $keyName])) {
            $this->app->view->meta($service);
            $this->app->view->params['service'] = $service->localize();
        }
    }
}