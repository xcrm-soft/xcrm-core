<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */
use XCrm\Data\Attribute\Special\PrimaryKeyAttribute;

/**
 * Атрибут id зарезервирован как первичный ключ таблиц
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
return [
    'class' => PrimaryKeyAttribute::class,
    'label' => 'ID',
];