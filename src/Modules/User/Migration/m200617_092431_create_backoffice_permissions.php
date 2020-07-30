<?php
namespace XCrm\Modules\User\Migration;
use XCrm\Rbac\Common\GrantPrivilegesConsoleRule;
use XCrm\Rbac\Common\GrantPrivilegesWebRule;

/**
 * Class m200617_092431_create_backoffice_permissions
 */
class m200617_092431_create_backoffice_permissions extends \XCrm\Database\Migration\MigrationOfRbac
{
    protected $permissions = [

        [
            'name' => 'all/grant-privileges-web',
            'description' => 'Любые действия в веб',
            'rule' => GrantPrivilegesWebRule::class
        ],

        [
            'name' => 'all/grant-privileges-cli',
            'description' => 'Любые действия в консоли',
            'rule' => GrantPrivilegesConsoleRule::class
        ],

    ];
}
