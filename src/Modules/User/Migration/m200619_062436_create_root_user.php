<?php
namespace XCrm\Modules\User\Migration;
use XCrm\Modules\User\Model\User;
use XCrm\Database\Migration;
use yii\base\Exception;

/**
 * Class m200619_062436_create_root_user
 */
class m200619_062436_create_root_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $userEmail = $this->app->env('APP_ADMIN_EMAIL', 'rootuser@example.com');

        $user = new User([
            'username' => substr($userEmail, 0, strpos($userEmail, '@')),
            'email' => $userEmail,
            'password' => 'rootpass',
            'registration_ip' => '127.0.0.1',
            'confirmed_at' => time(),
        ]);

        if ($user->save()) {

            $manager = $this->app->authManager;
            if ($permission = $manager->getPermission('all/grant-privileges-web')) {
                $manager->assign($permission, $user->id);
            }
            if ($permission = $manager->getPermission('all/grant-privileges-cli')) {
                $manager->assign($permission, $user->id);
            }

        } else {
            throw new Exception('Unable to create root user');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200619_062436_create_root_user cannot be reverted.\n";
        return true;
    }
}
