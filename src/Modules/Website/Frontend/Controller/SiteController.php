<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Website\Frontend\Controller;
use XCrm\Modules\Website\Model\Page;

class SiteController extends \XCrm\Frontend\SiteController
{
    public $rootModelClass = Page::class;

    public function __construct($id, $module, $config = [])
    {
        $config['viewPath'] = $config['viewPath'] ?? $module->viewPath;
        parent::__construct($id, $module, $config);
    }
}