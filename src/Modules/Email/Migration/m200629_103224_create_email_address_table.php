<?php
namespace XCrm\Modules\Email\Migration;
use XCrm\Database\Migration\MigrationOfConfigurable;

/**
 * Handles the creation of table `{{%email_address}}`.
 */
class m200629_103224_create_email_address_table extends MigrationOfConfigurable
{
    public $enableI18n = true;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%email_address}}', [
            'id',
            'name_system',
            'email',
            'email_name',
            'email_reply',
            'email_reply_name',
            'content_short',
            'content_full',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%email_address}}');
    }
}
