<?php
namespace XCrm\Modules\Website\Migration;
use yii\db\Migration;

/**
 * Class m200714_065348_create_index_page
 */
class m200714_065348_create_index_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        (new \XCrm\Modules\Website\Model\Page([
            'name' => 'Главная',
            'heading' => 'Главная страница',
            'meta_title' => 'Главная страница',
            'url' => '/',
        ]))->makeRoot();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200714_065348_create_index_page cannot be reverted.\n";
        return true;
    }
}
