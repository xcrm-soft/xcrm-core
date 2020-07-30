<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

return [
    'class' => \XCrm\Data\Attribute\Special\ForeignKeyAttribute::class,
    'notNull' => true,

    'behaviors' => [
        'tableType' => [
            'class' => \XCrm\Data\Behavior\SortableBehavior::class,
            'orderAttribute' => 'order_id'
        ]
    ]
];