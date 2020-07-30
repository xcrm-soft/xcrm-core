<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

return [
    'class' => \XCrm\Data\Attribute\Base\StringAttribute::class,
    'notNull' => true,
    'unique' => true,
    'behaviors' => [
        ['class' => \XCrm\Data\Behavior\UUIDBehavior::class, 'attribute' => 'uuid']
    ]
];