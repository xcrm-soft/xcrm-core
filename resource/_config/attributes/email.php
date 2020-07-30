<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

use XCrm\Data\Attribute\Base\StringAttribute;

return [
    'class' => StringAttribute::class,
    'label' => 'E-mail адрес',
    'rules' => [
        'emailPattern' => ['email']
    ],
];