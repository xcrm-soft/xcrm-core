<?php
namespace XCrm\Modules\Website\Migration;
use XCrm\Modules\Website\Rbac\ApplicationStructureRule;
use XCrm\Modules\Website\Rbac\ApplicationContentRule;

/**
 * Class m200621_063732_create_site_page_rules
 */
class m200621_063732_create_site_page_rules extends \XCrm\Database\Migration\MigrationOfRbac
{
    protected $permissions = [

        [
            'name' => 'website/page-structure',
            'description' => 'Изменение структуры веб-приложения',
            'rule' => ApplicationStructureRule::class
        ],

        [
            'name' => 'website/page-content',
            'description' => 'Редактирование содержания приложения',
            'rule' => ApplicationContentRule::class
        ],

    ];
}
