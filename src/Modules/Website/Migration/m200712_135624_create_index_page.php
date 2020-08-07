<?php
namespace XCrm\Modules\Website\Migration;
use yii\db\Migration;

/**
 * Class m200712_135624_create_index_page
 */
class m200712_135624_create_index_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        (new \XCrm\Modules\Website\Model\Page([
            'name' => 'Главная страница',
            'heading' => 'Главная страница',
            'meta_title' => 'Главная страница',
            'url' => '/',
            'layout' => '//index',
            'is_active' => 1,
        ]))->makeRoot();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200712_135624_create_index_page cannot be reverted.\n";
        return true;
    }
}
