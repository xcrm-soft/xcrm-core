<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

use XCrm\Data\Attribute\Base\IntUnsignedAttribute;
use XCrm\Data\Behavior\NestedSetsBehavior;

return [
    'class' => \XCrm\Data\Attribute\Special\NestedSetsKeyAttribute::class,
    'notNull' => true,

    'behaviors' => [
        'tableType' => [
            'class' => NestedSetsBehavior::class,
            'leftAttribute' => 'tk_left',
        ]
    ]
];