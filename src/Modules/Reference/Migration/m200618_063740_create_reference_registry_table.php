<?php
namespace XCrm\Modules\Reference\Migration;
use XCrm\Database\Migration\MigrationOfConfigurable;

/**
 * Handles the creation of table `{{%reference_registry}}`.
 */
class m200618_063740_create_reference_registry_table extends MigrationOfConfigurable
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reference_models_registry}}', [
            'id',
            'parent_id',
            'key_name',
            'uuid',
            'class_name',
            'table_name' => $this->string()->unique(),
            'name',
            'content_short',
            'jacket_svg',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by'
        ]);

        $this->addForeignKey('FK_reference_registry2structure', '{{%reference_models_registry}}', 'parent_id', '{{%reference_structure}}', 'id');
        $this->createIndex('IDX_reference_registry_sort', '{{%reference_models_registry}}', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_reference_registry2structure', '{{%reference_models_registry}}');
        $this->dropTable('{{%reference_models_registry}}');
    }
}
