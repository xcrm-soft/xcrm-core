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
 * в контексте всех приложений проекта. Правило действует только если в параметрах окружения проекта
 * включена настройка enableGlobalAccess
 *
 * @package XCrm\Rbac\Base
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class GrantPrivilegesWebRule extends Rule
{
    public $name = 'Grant All Privileges Web';

    public function execute($user, $item, $params)
    {
        return 'cli' !== php_sapi_name();
    }
}