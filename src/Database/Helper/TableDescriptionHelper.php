<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Database\Helper;
use XCrm\Application\ApplicationAwareTrait;
use XCrm\Data\Behavior\NestedSetsBehavior;
use XCrm\Data\Behavior\SortableBehavior;
use XCrm\Data\Behavior\TableDefaultBehavior;
use yii\base\BaseObject;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class TableDescriptionHelper extends BaseObject
{
    use ApplicationAwareTrait;

    public $skipAttributes = [];

    /**
     * @var array
     * @see getAttributes()
     */
    private $_attributes;
    /**
     * @var array
     * @see getRules()
     */
    private $_rules;
    /**
     * @var array
     * @see getBehaviors()
     */
    private $_behaviors;
    /**
     * @var array
     * @see getLabels()
     */
    private $_labels;


    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->_attributes ?? [];
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->_rules ?? [];
    }

    /**
     * @return array
     */
    public function getBehaviors()
    {
        return $this->_behaviors ?? [];
    }

    public function hasTableColumn($name)
    {
        return in_array($name, $this->_attributes);
    }

    /**
     * @return array
     */
    public function getLabels()
    {
        return $this->_labels ?? [];
    }

    public function isNestedSets()
    {
        if (isset($this->_behaviors['tableType']['class'])) {
            return NestedSetsBehavior::class === $this->_behaviors['tableType']['class'];
        }
        return false;
    }

    public function isSortable()
    {
        if (isset($this->_behaviors['tableType']['class'])) {
            if (SortableBehavior::class === $this->_behaviors['tableType']['class']) return true;
        }
        return $this->isNestedSets();
    }

    public function __construct($columns, $config = [])
    {
        $skipAttributes = $config['skipAttributes'] ?? [];
        unset($config['skipAttributes']);

        foreach ($columns as $column) {
            if (in_array($column, $skipAttributes)) continue;

            $attribute = $this->app->attributeManager->get($column);

            $this->_attributes[] = $column;

            if (isset($attribute->label)) {
                $this->_labels[$column] = $attribute->label;
            }

            $rules = $attribute->rules();
            foreach ($rules as $name=>$rule) {
                if (isset($this->_rules[$name])) $this->_rules[$name] = ArrayHelper::merge($this->_rules[$name], $rule);
                else $this->_rules[$name] = $rule;
            }

            $behaviors = $attribute->behaviors();

            foreach ($behaviors as $name=>$rule) {
                if (isset($this->_behaviors[$name])) {
                    $cl = $this->_behaviors[$name]['class'];
                    $cr = $rule['class'];
                    if ($cl !== $cr) throw new Exception('Different behaviors in one key');

                    $this->_behaviors[$name] = array_merge($this->_behaviors[$name], $rule);
                }
                else $this->_behaviors[$name] = $rule;
            }
        }

        if (!isset($this->_behaviors['tableType'])) {
            $this->_behaviors['tableType'] = [
                'class' => TableDefaultBehavior::class
            ];
        }

        if (NestedSetsBehavior::class === $this->_behaviors['tableType']['class']) {
            $this->_rules['nestedSets_parent_id'] = ['parent_id', 'integer'];
        }

        parent::__construct($config);
    }
}