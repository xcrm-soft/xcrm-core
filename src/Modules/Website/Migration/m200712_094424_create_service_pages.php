<?php
namespace XCrm\Modules\Website\Migration;

use XCrm\Database\Migration\MigrationOfConfigurable;

/**
 * Class m200712_094424_create_service_pages
 */
class m200712_094424_create_service_pages extends MigrationOfConfigurable
{
    public $enableI18n = true;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%website_service}}', [
            'id',
            'key_name',
            'is_active',
            'name',
            'jacket_img',
            'jacket_img_alt',
            'heading',
            'content_short',
            'content_full',
            'meta_title',
            'meta_keywords',
            'meta_description',
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
        $this->dropTable('{{%website_service}}');
    }
}
