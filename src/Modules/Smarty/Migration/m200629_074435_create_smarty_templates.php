<?php
namespace XCrm\Modules\Smarty\Migration;
use XCrm\Database\Migration\MigrationOfConfigurable;

/**
 * Class m200629_074435_create_smarty_templates
 */
class m200629_074435_create_smarty_templates extends MigrationOfConfigurable
{
    public $enableI18n = true;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%smarty_template}}', [
            'id',
            'key_name' => $this->string()->notNull(),
            'xref_refSmartyCategory',
            'xref_refSmartyGroup',
            'name',
            'source_code',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by'
        ]);

        $this->createIndex('IDX_smarty_templateUnique', '{{%smarty_template}}', [
            'xref_refSmartyCategory',
            'xref_refSmartyGroup',
            'key_name'
        ], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%smarty_template}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200629_074435_create_smarty_templates cannot be reverted.\n";

        return false;
    }
    */
}
