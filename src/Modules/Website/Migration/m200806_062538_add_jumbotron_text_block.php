<?php
namespace XCrm\Modules\Website\Migration;
use XCrm\Modules\Website\Model\PageService;
use yii\db\Migration;

/**
 * Class m200806_062538_add_jumbotron_text_block
 */
class m200806_062538_add_jumbotron_text_block extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $pages = [

            [
                'key_name'   => 'pages/index/intro',
                'name'       => 'Наверх',
                'heading'    => 'Заголовок экрана заставки приложения',
                'is_active'  => 1,
                'content_full' => '<p>Подсказка или текст экрана заставки приложения'
            ],

            [
                'key_name'   => 'pages/index/jumbotron',
                'name'       => 'О проекте',
                'heading'    => 'Добро пожаловать',
                'is_active'  => 1,
                'content_full' => '<p>Редактируемый текстовый блок'
            ],

            [
                'key_name'   => 'pages/index/portfolio',
                'name'       => 'Портфолио',
                'heading'    => 'Портфолио',
                'is_active'  => 1,
                'content_full' => '<p>Редактируемый текстовый блок перед превью портфолио'
            ],

            [
                'key_name'   => 'pages/index/contact',
                'name'       => 'Обратная связь',
                'heading'    => 'Обратная связь',
                'is_active'  => 1,
                'content_full' => '<p>Редактируемый текстовый блок формы обратной связи'
            ],
        ];

        foreach ($pages as $data) {
            (new PageService($data))->smartSave();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200806_062538_add_jumbotron_text_block cannot be reverted.\n";
        return true;
    }
}
