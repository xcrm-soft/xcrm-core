<?php
namespace XCrm\Modules\Website\Migration;
use XCrm\Modules\Website\Model\PageLegal;
use yii\db\Migration;

/**
 * Class m200712_140228_create_privacy_page
 */
class m200712_140228_create_privacy_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        (new PageLegal([
            'name' => 'Соглашение о конфиденциальности',
            'heading' => 'Соглашение о конфиденциальности',
            'url' => 'privacy-policy',
            'is_active' => 1,
            'is_sub_menu_item' => 1,
        ]))->smartSave();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200712_140228_create_privacy_page cannot be reverted.\n";
        return true;
    }
}
