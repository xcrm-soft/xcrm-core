<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Attribute;
use XCrm\Data\ActiveRecordConfigurable;
use XCrm\Database\Migration\MigrationOfConfigurable;
use yii\base\BaseObject;
use yii\db\ColumnSchemaBuilder;
use yii\widgets\ActiveField;

/**
 * Типизированный атрибут
 * Используется при построении миграций, определения конфигурации меток, правил валидации и поведения моделей.
 *
 * @package XCrm\Data\Attribute
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
abstract class Attribute extends BaseObject
{
    /**
     * @var string зарезервированное имя атрибута
     */
    public $name = null;
    /**
     * @var null|string текстовая метка атрибута по умолчанию
     *     Для определения текстовых меток по умолчанию не применяется их интернационализация.
     *     Каждая модель, использующая атрибуты с зарезервированными именами, может переводить текстовые метки
     *     атрибутов на язык интерфейса в собственном пространстве имен. Пространство имен для интернационализации
     *     меток по умолчанию реализуется базовым классом конфигурируемой модели
     */
    public $label = null;
    /**
     * @var null|string|int|array размер поля БД, связанного с заданным атрибутом
     *     используется при построении миграций для создания таблиц и добавления или изменения формата полей
     */
    public $length = null;
    /**
     * @var bool флаг уникальности атрибута в пределах таблицы
     */
    public $unique = false;
    /**
     * @var bool атрибут должен содержать не нулевое значение
     */
    public $notNull = false;
    /**
     * @var null|mixed значение по умолчанию
     */
    public $defaultValue = null;
    /**
     * @var array конфигуратор правил валидации атрибута
     */
    public $rules = [];
    /**
     * @var array конфигуратор поведений моделей, содержащих данный атрибут
     */
    public $behaviors = [];
    /**
     * @var bool флаг интернационализации поля
     *    если установлен в true и миграция генерирует создание таблицы интернационализаций, она будет содержать
     *    заданное поле, а к имени поля в основной таблице будет добавлен префикс интернационализации
     */
    public $i18n = false;

    public function coreRules()
    {
        return [];
    }

    public function rules()
    {
        $rr = [];
        if (!empty($this->rules)) foreach ($this->rules as $k=>$v) {
            array_unshift($v, $this->name);
            $rr[$k] = $v;
        }
        $all = array_merge($this->coreRules(), $rr);

        if ($this->notNull && !isset($all[$this->name . '-required'])) $all[$this->name . '-required'] = [$this->name, 'required'];
        if ($this->unique && !isset($all[$this->name . '-unique'])) $all[$this->name . '-unique'] = [$this->name, 'unique'];

        return $all;
    }

    public function formField(ActiveRecordConfigurable $model, ActiveField $field)
    {

    }

    public function coreBehaviors()
    {
        return [];
    }

    public function behaviors()
    {
        return array_merge($this->coreBehaviors(), $this->behaviors);
    }

    /**
     * Создает определения построителя полей таблицы БД для миграции заданного типа
     * @param MigrationOfConfigurable $migration объект миграции
     * @return ColumnSchemaBuilder объект построителя полей таблицы БД
     */
    abstract public function getMigrationDefinition(MigrationOfConfigurable $migration);

    /**
     * Добавляет определения для данного уровня иерархии определений атрибутов
     * @param ColumnSchemaBuilder $definition объект построителя полей таблицы БД
     * @return ColumnSchemaBuilder объект построителя полей таблицы БД
     */
    protected function addDefinitions(ColumnSchemaBuilder $definition)
    {
        if ($this->unique) $definition->unique();
        if ($this->notNull) $definition->notNull();
        if (null !== $this->defaultValue) $definition->defaultValue($this->defaultValue);
        return $definition;
    }
}