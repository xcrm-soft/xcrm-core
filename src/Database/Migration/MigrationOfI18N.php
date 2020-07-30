<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Database\Migration;
use XCrm\Database\Migration;

class MigrationOfI18N extends Migration
{
    /**
     * @var MigrationOfConfigurable
     */
    private $_masterMigration;
    /**
     * @var string имя основной таблиы, которой соответствует таблица интернационализации,
     *    управляемая данной миграцией
     */
    private $_masterTable;
    private $_i18nTable;

    public function createInternationalisationTable($columns, $options = null)
    {
        parent::createTable($this->_i18nTable, $columns, $options);
        $this->createIndex($this->getLanguageKeyName(), $this->_i18nTable, ['master_id', 'language'], true);
        $this->addForeignKey($this->getMasterKeyName(), $this->_i18nTable, 'master_id', $this->_masterTable, 'id');
    }

    /**
     * Конструктор миграций интернационализационных таблиц
     * @param MigrationOfConfigurable $masterMigration
     * @param string $table
     * @param array $config
     */
    public function __construct(MigrationOfConfigurable $masterMigration, $table, $config = [])
    {
        $this->_masterMigration = $masterMigration;
        $this->_masterTable = $table;

        if (false === strpos($table, '}}')) {
            $this->_i18nTable = $table . '_i18n';
        } else {
            $this->_i18nTable = str_replace('}}', '_i18n}}', $table);
        }

        parent::__construct($config);
    }

    public function getMasterKeyName()
    {
        return 'FK_' . $this->getDb()->schema->getRawTableName($this->_i18nTable) . '_master';
    }

    public function getLanguageKeyName()
    {
        return 'FK_' . $this->getDb()->schema->getRawTableName($this->_i18nTable) . '_language';
    }
}