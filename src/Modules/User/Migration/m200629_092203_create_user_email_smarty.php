<?php
namespace XCrm\Modules\User\Migration;
use XCrm\Database\Migration;
use yii\base\InvalidConfigException;

/**
 * Class m200629_092203_create_user_email_messages
 */
class m200629_092203_create_user_email_smarty extends Migration
{
    /**
     * @return bool|void
     * @throws InvalidConfigException
     */
    public function safeUp()
    {
        $dir = dirname(__DIR__) . '/Email';
        $smarty = $this->app->smarty->registry;

        $smarty->registerCategory('email', 'Шаблоны электронной почты', true, false);
        $smarty->registerGroup('user', 'Пользователи приложения', true, false);

        $smarty->registerTemplate('email', 'user', 'recovery-html', 'Сброс пароля (html)', $dir . '/recovery-html.tpl');
        $smarty->registerTemplate('email', 'user', 'recovery-text', 'Сброс пароля (текст)', $dir . '/recovery-text.tpl');
        $smarty->registerTemplate('email', 'user', 'update-html', 'Изменение аккаунта  (html)', $dir . '/update-html.tpl');
        $smarty->registerTemplate('email', 'user', 'update-text', 'Изменение аккаунта  (текст)', $dir . '/update-text.tpl');
        $smarty->registerTemplate('email', 'user', 'confirmation-html', 'Подтверждение аккаунта  (html)', $dir . '/confirmation-html.tpl');
        $smarty->registerTemplate('email', 'user', 'confirmation-text', 'Подтверждение аккаунта  (текст)', $dir . '/confirmation-text.tpl');
        $smarty->registerTemplate('email', 'user', 'welcome-html', 'Приветственное письмо (html)', $dir . '/welcome-html.tpl');
        $smarty->registerTemplate('email', 'user', 'welcome-text', 'Приветственное письмо (текст)', $dir . '/welcome-text.tpl');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200629_092203_create_user_email_messages cannot be reverted.\n";
        return true;
    }
}
