<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Website\Frontend;
use XCrm\Frontend\SiteModuleTrait;
use XCrm\Helper\ArrayHelper;
use XCrm\Modules\Website\Frontend\Controller\SiteController;

class Module extends \XCrm\Modules\Website\Module
{
    use SiteModuleTrait;

    /**
     * {@inheritDoc}
     */
    public function coreControllerMap()
    {
        return [
            'site' => SiteController::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function __construct($id, $parent = null, $config = [])
    {
        parent::__construct($id, $parent, ArrayHelper::merge([
            'viewPath' => '@app/views/_mod-pages',
        ], $config));
    }
}