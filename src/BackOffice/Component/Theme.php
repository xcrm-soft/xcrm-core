<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\BackOffice\Component;
use XCrm\BackOffice\ApplicationAsset;


class Theme extends \XCrm\Application\Web\Theme
{
    public function assets()
    {
        return [
            'application' => ApplicationAsset::class,
        ];
    }

    public function __construct($config = [])
    {
        $config['basePath'] = $config['basePath'] ?? __DIR__;
        $config['pathMap'] = [
            '@app/views' => dirname(__DIR__) . '/resource/views'
        ];
        parent::__construct($config);
    }
}