<?php
namespace XCrm\Modules\Reference\Migration;
use XCrm\Database\Migration\MigrationOfConfigurable;

/**
 * Handles the creation of table `{{%reference_structure}}`.
 */
class m200618_063107_create_reference_structure_table extends MigrationOfConfigurable
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reference_structure}}', [
            'id',
            'tk_root',
            'tk_left',
            'tk_depth',
            'tk_right',
            'is_active',
            'name',
            'url:unique',
            'content_short',
            'jacket_svg',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by'
        ]);

        $this->createIndex('IDX_refStructureTreeRoot', '{{%reference_structure}}', 'tk_root');
        $this->createIndex('IDX_refStructureTreeLeft', '{{%reference_structure}}', 'tk_left');
        $this->createIndex('IDX_refStructureTreeRight', '{{%reference_structure}}', 'tk_right');
        $this->createIndex('IDX_refStructureTreeDepth', '{{%reference_structure}}', 'tk_depth');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%reference_structure}}');
    }
}
