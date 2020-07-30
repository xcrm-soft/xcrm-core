<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Rbac\Common;
use XCrm\Rbac\Rule;

/**
 * Правило глоюального доступа
 *
 * При назначении данного правила учетной записи пользвоатель получает неограниченные права
 * в контексте всех приложений проекта при работе из консоли
 *
 * @package XCrm\Rbac\Base
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class GrantPrivilegesConsoleRule extends Rule
{
    public $name = 'Grant All Privileges Console';

    public function execute($user, $item, $params)
    {
        return 'cli' === php_sapi_name();
    }
}