<?php
namespace XCrm\Modules\Email\Migration;
use XCrm\Database\Migration\MigrationOfConfigurable;

/**
 * Handles the creation of table `{{%email_template}}`.
 */
class m200629_115143_create_email_template_table extends MigrationOfConfigurable
{
    public $enableI18n = true;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%email_template}}', [
            'id',
            'name_system',
            'heading',
            'key_name',
            'html_id'   => $this->foreignKey(),
            'text_id'   => $this->foreignKey(),
            'sender_id' => $this->foreignKey(),
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ]);

        $this->addForeignKey('FK_email_sender_id', '{{%email_template}}', 'sender_id', '{{%email_address}}', 'id');
        $this->addForeignKey('FK_email_text_id', '{{%email_template}}', 'text_id', '{{%smarty_template}}', 'id');
        $this->addForeignKey('FK_email_html_id', '{{%email_template}}', 'html_id', '{{%smarty_template}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_email_sender_id', '{{%email_template}}');
        $this->dropForeignKey('FK_email_text_id', '{{%email_template}}');
        $this->dropForeignKey('FK_email_html_id', '{{%email_template}}');

        $this->dropTable('{{%email_template}}');
    }
}
