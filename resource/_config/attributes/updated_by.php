<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

use XCrm\Data\Attribute\Base\IntUnsignedAttribute;
use yii\behaviors\BlameableBehavior;

/**
 * Метка даты-времени создания записи в таблице БД
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
return [
    'class' => IntUnsignedAttribute::class,
    'label' => 'Обновил',
    'behaviors' => [
        'blameable' => [
            'class' => BlameableBehavior::class,
            'updatedByAttribute' => 'updated_by'
        ],
    ],
    'section' => 'system',
];