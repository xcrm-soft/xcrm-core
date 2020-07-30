<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Database\Migration;
use XCrm\Data\Attribute\Special\ForeignKeyAttribute;
use XCrm\Database\Migration;
use yii\base\NotSupportedException;
use yii\db\ColumnSchemaBuilder;
use yii\base\InvalidArgumentException;


/**
 * Миграция таблиц БД для конфигурируемых автоматически моделей
 *
 *   - Реализует сокращенный вариант записи конфигурации полей таблицы
 *     для колонок таблицы с зарезервированными именами достаточно указание только имени
 *     для атрибутов модели, связанных с такими колонками, будут автоматически применяться правила валидации,
 *     указанные в конфигурации атрибута, а также модели будут автоматически назначены соответствующие
 *     атрибуту с зарезервированным именем поведения
 *
 *   - Реализует возможность добавления пользовательских колонок с конфигурацией, соответствкющей
 *     конфигурации колонок с зарезервированными именами. Для добавления такой колонки достаточно указания только
 *     имени, однако при автоматическом конфигурировании модели правила валидации и поведения, связанные с
 *     таким атрибутом, применены не будут
 *
 *   - Реализует автоматическое добавление и удаление таблиц интернационализации
 *     @TODO добавить для таблиц интернационализации реакцию на addColumn, dropColumn и так далее
 *
 * @package XCrm\Database\Migration
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class MigrationOfConfigurable extends Migration
{
    /**
     * @var bool|array подключает генерацию миграции таблицы интернационализации
     *   - Если установлено в true, то таблица интернационализации будет содержать все атриьуты
     *     основной таблицы, для которых конфигурацией атриьута установлен флаг i18n
     *   - Также может содержать массив, содержащий имена атрибутов основной таблицы,
     *     в этом случае таблица интернационализации вне зависимости от конфигураций атрибутов
     *     будет содержать только указанные поля
     *
     * При использовании мезанизма интернационализации к именам полей основной таблицы будет добавлен
     * специализированный префикс (по умолчанию - _i18n_), явное использование префикса в тиенах атрибутов
     * при этом не допускается и приводит к возникновению исключения
     */
    protected $enableI18n = false;
    /**
     * @var null|MigrationOfI18N[] хендлеры отображения миграции на соотчетствующую
     *    таблицу интренационализации
     */
    private $_i18n = null;


    /**
     * @param string $table
     * @param array $columns
     * @param null $options
     * @throws NotSupportedException
     */
    public function createTable($table, $columns, $options = null)
    {
        $rawTableName = $this->createInternationalization($table);
        $foreignKeys = [];

        $columns = $this->columns($columns, $foreignKeys);
        parent::createTable($table, $columns, $options);

        if (!empty($foreignKeys)) {
            $raw = $this->getDb()->schema->getRawTableName($table);
            foreach ($foreignKeys as $ref => $key) {
                $this->addForeignKey('FK_' . $raw . '_' . $ref, $table, $key['column'], $key['refTable'], 'id');
            }
        }

        if (isset($this->_i18n[$rawTableName])) {
            //@todo отобразить create table на интернационализацию
            $this->_i18n[$rawTableName]->createInternationalisationTable($this->i18nColumns($columns), $options);
        }
    }

    /**
     * @param string $table
     * @throws NotSupportedException
     */
    public function dropTable($table)
    {
        $rawTableName = $this->createInternationalization($table);
        if (isset($this->_i18n[$rawTableName])) {
            //@todo отобразить drop table на интернационализацию
        }

        $raw = $this->getDb()->schema->getRawTableName($table);
        $cols = $this->getDb()->schema->getTableSchema($table)->getColumnNames();

        $validColumnPrefix = $this->app->referenceManager->referenceKeyPrefix;
        foreach ($cols as $columnName) {
            if (0 !== strpos($columnName, $validColumnPrefix)) continue;
            $ref = substr($columnName, strlen($validColumnPrefix));
            try {
                $this->dropForeignKey('FK_' . $raw . '_' . $ref, $table);
            } catch (\yii\db\Exception $e) {
                echo "\n SKIP drop foreign key for ref " . $ref;
            }
        }
        parent::dropTable($table);
    }

    /**
     * Если включено обображение миграций на таблицы интернационализации, создает обхект миграции
     * интернационализации и помещает его в стек
     * @param string $table имя основной таблицы, с которой связана миграция интернационализации
     * @return string
     * @throws NotSupportedException
     */
    protected function createInternationalization($table)
    {
        $raw = $this->getDb()->getSchema()->getRawTableName($table);
        if ($this->enableI18n) {
            if (!isset($this->_i18n[$raw])) {
                $this->_i18n[$raw] = new MigrationOfI18N($this, $table);
            }
        }
        return $raw;
    }

    /**
     * Создает определения колонок таблицы
     * @param array $columns
     * @param array $foreignKeys
     * @return array
     */
    protected function columns(array $columns, array &$foreignKeys)
    {
        $result = [];
        foreach ($columns as $id => $def) {
            if (is_numeric($id)) {

                if (0 === strpos($def, $this->app->referenceManager->referenceKeyPrefix)) {
                    $result[$def] = $this->referenceBookLink($def, $foreignKeys);
                } else {
                    $definition = $this->reservedNameColumn($def);
                    $result[$def] = $definition;
                }
            } else {
                $result[$id] = $def;
            }
        }
        return $result;
    }

    /**
     * @param $columnName
     * @param $foreignKeys
     * @throws InvalidArgumentException
     */
    protected function referenceBookLink($columnName, &$foreignKeys)
    {
        $validColumnPrefix = $this->app->referenceManager->referenceKeyPrefix;

        if (0 === strpos($columnName, $validColumnPrefix)) {
            $referenceKey = substr($columnName, strlen($validColumnPrefix));
            $referenceInfo = $this->app->referenceManager->getInfo($referenceKey);

            if (isset($foreignKeys[$referenceKey])) {
                throw new InvalidArgumentException('Reference key ' . $referenceKey . ' exists');
            }

            $foreignKeys[$referenceKey] = [
                'column'   => $columnName,
                'refTable' => $referenceInfo->table_name
            ];
            return $this->integer()->unsigned();
        }

        throw new InvalidArgumentException('Reference link name should have prefix ' . $validColumnPrefix);
    }

    protected function i18nColumns($columns)
    {
        $i18nColumns = [];
        $beforeColumns = ['id', 'master_id', 'language'];

        foreach ($beforeColumns as $col) {
            $def = $this->reservedNameColumn($col);
            $i18nColumns[$col] = $def;
        }

        foreach ($columns as $col=>$def) {
            try {
                $attribute = $this->app->attributeManager->get($col);
                if ($attribute->i18n) $i18nColumns[$col] = $def;
            } catch (\Exception $e) {
                continue;
            }
        }

        return $i18nColumns;
    }

    public function as($column)
    {
        return $this->reservedNameColumn($column);
    }

    public function foreignKey()
    {
        return (new ForeignKeyAttribute())->getMigrationDefinition($this);
    }

    /**
     * Создает определение для атрибута с зарезервированным имененем
     * @param $name
     * @return ColumnSchemaBuilder
     */
    protected function reservedNameColumn(&$name)
    {
        // @todo если имя колонки уже содержит префикс интернационализации, бросать ошибку

        $flags = null;

        if (false !== strpos($name, ':')) {
            $flags = explode(':', $name);
            $name = array_shift($flags);
        }

        // @todo добавить префикс интернационализации

        $attribute = $this->app->attributeManager->get($name);
        $definition = $attribute->getMigrationDefinition($this);
        return $this->resolveflags($definition, $flags);
    }

    /**
     * @param ColumnSchemaBuilder $definition
     * @param $flags
     * @return ColumnSchemaBuilder
     */
    protected function resolveFlags(ColumnSchemaBuilder $definition, $flags = [])
    {
        if (is_array($flags) && !empty($flags)) {
            if (in_array('unique', $flags)) $definition->unique();
            if (in_array('required', $flags)) $definition->notNull();
        }
        return $definition;
    }
}