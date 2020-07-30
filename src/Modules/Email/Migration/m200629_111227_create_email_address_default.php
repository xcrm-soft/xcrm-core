<?php
namespace XCrm\Modules\Email\Migration;
use SideKit\Config\ConfigKit;
use XCrm\Modules\Email\Model\EmailAddress;
use yii\base\InvalidConfigException;
use yii\db\Migration;

/**
 * Class m200629_111227_create_email_address_default
 */
class m200629_111227_create_email_address_default extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $address = new EmailAddress([
            'name_system' => 'Почтовый ящик по умолчанию',
            'email' => ConfigKit::env()->get('APP_ADMIN_EMAIL', 'noreply@example.com'),
            'email_name' => ConfigKit::env()->get('APP_ADMIN_NAME', 'No Reply'),
            'email_reply' => ConfigKit::env()->get('APP_ADMIN_EMAIL', 'noreply@example.com'),
            'email_reply_name' => ConfigKit::env()->get('APP_ADMIN_NAME', 'No Reply'),
        ]);

        if (!$address->save()) {
            throw new InvalidConfigException('Unable to create default address');
        }
    }
}
