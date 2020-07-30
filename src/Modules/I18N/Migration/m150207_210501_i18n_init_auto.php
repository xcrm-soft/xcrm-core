<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace XCrm\Modules\I18N\Migration;
use yii\db\Migration;

/**
 * Initializes i18n messages tables.
 *
 *
 *
 * @author Alexey Volkov <webwizardry@hotmail.com>
 * @since 2.0.7
 */
class m150207_210501_i18n_init_auto extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%i18n_auto_source}}', [
            'id' => $this->primaryKey(),
            'message' => $this->text(),
        ], $tableOptions);

        $this->createTable('{{%i18n_auto}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_auto_id_language', '{{%i18n_auto}}', ['id', 'language']);
        $onUpdateConstraint = 'RESTRICT';
        if ($this->db->driverName === 'sqlsrv') {
            // 'NO ACTION' is equivalent to 'RESTRICT' in MSSQL
            $onUpdateConstraint = 'NO ACTION';
        }
        $this->addForeignKey('fk_auto_source_auto', '{{%i18n_auto}}', 'id', '{{%i18n_auto_source}}', 'id', 'CASCADE', $onUpdateConstraint);
        $this->createIndex('idx_auto_language', '{{%i18n_auto}}', ['id', 'language'], true);
    }

    public function down()
    {
        $this->dropForeignKey('fk_auto_source_auto', '{{%i18n_auto}}');
        $this->dropTable('{{%i18n_auto}}');
        $this->dropTable('{{%i18n_auto_source}}');
    }
}
