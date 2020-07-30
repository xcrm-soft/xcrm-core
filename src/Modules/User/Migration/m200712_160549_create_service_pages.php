<?php
namespace XCrm\Modules\User\Migration;
use XCrm\Modules\Website\Model\PageServiceI18N;
use yii\db\Migration;
use XCrm\Modules\Website\Model\PageService;

/**
 * Class m200712_160549_create_service_pages
 */
class m200712_160549_create_service_pages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $pages = [
            [
                'key_name'   => 'user/security/login',
                'name'       => 'Аутентификация',
                'heading'    => 'Войдите для продолжения работы',
                'meta_title' => 'Вход в личный кабинет',
                'is_active'  => 1,
                'content_full' => '<p>Для продолжения работы с системой требуется пройти процедуру аутентификации'
            ],

            [
                'key_name'   => 'user/recovery/request',
                'name'       => 'Запрос сброса пароля',
                'heading'    => 'Восстановление пароля',
                'meta_title' => 'Восстановление пароля',
                'is_active'  => 1,
                'content_full' => '<p>Введите адрес электронной почты, указанный при регистрации учетной записи. Мы вышлем вам письмо, содержащее одноразовую ссылку на форму для сброса пароля'
            ],

            [
                'key_name'   => 'user/recovery/request-success',
                'name'       => 'Запрос сброса пароля выполнен',
                'heading'    => 'Восстановление пароля',
                'meta_title' => 'Восстановление пароля',
                'is_active'  => 1,
                'content_full' => '<p>Если введенный адрес соответствует тучетной записи пользователя, на него выслано письмо, содержащее ссылку для восстановления пароля'
            ],

            [
                'key_name'   => 'user/recovery/reset',
                'name'       => 'Сброс пароля',
                'heading'    => 'Введите новый пароль',
                'meta_title' => 'Сброс пароля',
                'is_active'  => 1,
                'content_full' => '<p>Придумайте и укажите новый пароль. С момента сброса пароля старый пароль будет недействителен.'
            ],

            [
                'key_name'   => 'user/registration',
                'name'       => 'Регистрация учетной записи',
                'heading'    => 'Регистрация учетной записи',
                'meta_title' => 'Регистрация учетной записи',
                'is_active'  => 1,
                'content_short' => '<p>Для регистрации учетной записи запролните форму.<br/>Указывайте действующий адрес электронной почты, на него будет отправлена ссылка для активации аккаунта'
            ],

            [
                'key_name'   => 'user/registration-confirm',
                'name'       => 'Требуется подтверждение регистрации',
                'heading'    => 'Вы успешно зарегистрировались',
                'meta_title' => 'Вы успешно зарегистрировались',
                'is_active'  => 1,
                'content_short' => '<p>Благодарим Вас за регистрацию.<br/>На указанный адрес электронной почты отправленео сообщение, содержащее инструкции и ссылку для активации учетной записи'
            ],

            [
                'key_name'   => 'user/registration-confirm-success',
                'name'       => 'Успешное подтверждение учетной записи',
                'heading'    => 'Учетная запись подтверждена',
                'meta_title' => 'Учетная запись подтверждена',
                'is_active'  => 1,
                'content_short' => '<p>Ваш адрес электронной почты успешно подтвержден'
            ],

            [
                'key_name'   => 'user/registration-confirm-error',
                'name'       => 'Ошибка подтверждения учетной записи',
                'heading'    => 'Ошибка подтверждения учетной записи',
                'meta_title' => 'Ошибка подтверждения учетной записи',
                'is_active'  => 1,
                'content_short' => '<p>Ссылка для активации аккаунта неправильна или устарела'
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
        PageService::getDb()->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();

        $this->truncateTable(PageServiceI18N::tableName());
        $this->truncateTable(PageService::tableName());

        PageService::getDb()->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
    }
}
