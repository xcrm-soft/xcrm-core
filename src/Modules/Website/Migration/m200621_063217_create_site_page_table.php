<?php
namespace XCrm\Modules\Website\Migration;
/**
 * Handles the creation of table `{{%site_page}}`.
 */
class m200621_063217_create_site_page_table extends \XCrm\Database\Migration\MigrationOfConfigurable
{
    public $enableI18n = true;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%website_page}}', [
            'id',
            'tk_root',
            'tk_left',
            'tk_depth',
            'tk_right',
            'is_active',
            'is_top_menu_item',
            'is_sub_menu_item',
            'layout',
            'url',
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
        $this->dropTable('{{%website_page}}');
    }
}
