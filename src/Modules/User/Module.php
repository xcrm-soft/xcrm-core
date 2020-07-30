<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User;


use Da\User\Model\Token;
use XCrm\Modules\User\Model\Profile;
use XCrm\Modules\User\Model\User;
use yii\helpers\ArrayHelper;

class Module extends \Da\User\Module
{
    public function __construct($id, $parent = null, $config = [])
    {
        parent::__construct($id, $parent, ArrayHelper::merge([
            'classMap' => [
                'User'    => User::class,
                'Profile' => Profile::class,
                'Token'   => Token::class,
            ],
        ], $config));
    }
}