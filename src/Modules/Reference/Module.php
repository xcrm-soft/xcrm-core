<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Reference;
use XCrm\Modules\Reference\Model\ReferenceRegistry;
use XCrm\Modules\Reference\Model\ReferenceStructure;

class Module extends \XCrm\Application\Base\Module
{
    public static function getTitle()
    {
        return 'Справочники';
    }

    /**
     * {@inheritDoc}
     */
    public function coreModelMap()
    {
        return [
            'structure' => ReferenceStructure::class,
            'registry' => ReferenceRegistry::class,
        ];
    }
}