<?php
namespace XCrm\Modules\User\Migration;
use yii\db\Migration;

/**
 * Class m200624_101125_alter_profile_table
 */
class m200624_101125_alter_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%profile}}', 'birth_date', $this->date()->after('user_id'));
        $this->addColumn('{{%profile}}', 'name_last', $this->string()->after('name'));
        $this->addColumn('{{%profile}}', 'name_first', $this->string()->after('name_last'));
        $this->addColumn('{{%profile}}', 'name_middle', $this->string()->after('name_first'));

        $this->dropColumn('{{%profile}}', 'name');
        $this->dropColumn('{{%profile}}', 'public_email');
        $this->dropColumn('{{%profile}}', 'gravatar_id');

        $this->addColumn('{{%profile}}', 'phone', $this->string()->after('user_id'));
        $this->addColumn('{{%profile}}', 'jacket_img', $this->string());

        $this->createIndex('IDX_userProfile_phone', '{{%profile}}', 'phone', true);
        $this->createIndex('IDX_userProfile_birthDate', '{{%profile}}', 'birth_date');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
