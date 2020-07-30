<?php
namespace XCrm\Modules\Website\Migration;

use XCrm\Database\Migration\MigrationOfConfigurable;

/**
 * Class m200712_094424_create_service_pages
 */
class m200712_094425_create_legal_pages extends MigrationOfConfigurable
{
    public $enableI18n = true;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%website_legal}}', [
            'id',
            'url',
            'is_active',
            'is_top_menu_item',
            'is_sub_menu_item',
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
        $this->dropTable('{{%website_legal}}');
    }
}
