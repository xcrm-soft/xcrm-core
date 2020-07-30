<?php
namespace XCrm\Modules\User\Migration;
use XCrm\Database\Migration;

/**
 * Class m200629_125429_create_user_email_messages
 */
class m200629_125429_create_user_email_messages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->app->email->register('user.welcome', 'Приветственное письмо', 'email/user/welcome-html', 'email/user/welcome-text');
        $this->app->email->register('user.confirmation', 'Пожтверждение e-mail', 'email/user/confirmation-html', 'email/user/confirmation-text');
        $this->app->email->register('user.recovery', 'Восстановление пароля', 'email/user/recovery-html', 'email/user/recovery-text');
        $this->app->email->register('user.update', 'Изменение аккаунта', 'email/user/update-html', 'email/user/update-text');
    }
}
