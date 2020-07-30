<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Behavior;


class NestedSetsBehavior extends \creocoder\nestedsets\NestedSetsBehavior
{
    /**
     * @var null|int идентификатор нового родительского узла для перемещения ветви дерева
     * @see getParent_id()
     * @see setParent_id()
     */
    public $_moveToParentNode = null;
    /**
     * @var string|false
     */
    public $treeAttribute = 'tk_root';
    /**
     * @var string
     */
    public $leftAttribute = 'tk_left';
    /**
     * @var string
     */
    public $rightAttribute = 'tk_right';
    /**
     * @var string
     */
    public $depthAttribute = 'tk_depth';

    public $icon;
    public $icon_type;
    public $selected;
    public $collapsed;

    public function isVisible()
    {
        return true;
    }

    public function isActive()
    {
        return true;
    }

    public function isDisabled()
    {
        return false;
    }

    public function isReadonly()
    {
        return false;
    }

    public function isRemovable()
    {
        return true;
    }

    public function isRemovableAll()
    {
        return true;
    }

    public function isChildAllowed()
    {
        return false;
    }

    public function isSelected()
    {
        return $this->selected;
    }

    public function isCollapsed()
    {
        return $this->collapsed;
    }

    public function isMovable()
    {
        return true;
    }

    public function isRoot()
    {
        if ($this->owner->isNewRecord) {
            return empty($this->getValidParents());
        }
        return parent::isRoot();
    }

    public function getFullUrl()
    {
        if (1 == $this->owner->{$this->depthAttribute}) {
            return '/' . ( $this->owner->url ?? $this->owner->id);
        } else {
            // @todo добавить поддержку вложенных урлов
        }
    }

    public function getValidParentsQuery()
    {
        if ($this->owner->isNewRecord) {
            return $this->owner->getFindAllQuery();
        } else {
            return $this->owner->find()
                -> where(['<', $this->leftAttribute, $this->owner->{$this->leftAttribute}])
                -> orWhere(['>', $this->rightAttribute, $this->owner->{$this->rightAttribute}])
                -> orderBy([$this->leftAttribute => SORT_ASC]);
        }
    }

    public function getParent_id()
    {
        if ($this->owner->isRoot()) {
            $this->_moveToParentNode = null;
        }
        elseif (null === $this->_moveToParentNode && !$this->owner->isNewRecord) {
            $this->_moveToParentNode =  $this->owner->parents(1)->one()->primaryKey;
        } elseif (null === $this->_moveToParentNode && $this->owner->isNewRecord) {
            $this->_moveToParentNode = $this->owner::find()->orderBy($this->leftAttribute)->limit(1)->one()->primaryKey;
        }
        return $this->_moveToParentNode;
    }

    public function setParent_id($id)
    {
        $this->_moveToParentNode = $id;
    }

    public function getParentNode()
    {
        return $this->owner->parents(1)->one();
    }

    public function getValidParents()
    {
        return $this->getValidParentsQuery()->all();
    }

    public function smartSave($runValidation = true, $attributeNames = null)
    {
        if (!$this->owner->validate()) return false;

        if ($this->owner->isNewRecord || ($this->_moveToParentNode && $this->_moveToParentNode != $this->getParentNode()->id)) {
            $parentNode = $this->owner::findOne($this->_moveToParentNode);
            if (!$parentNode && $this->owner->isNewRecord) {
                $parentNode = $this->owner::find()->orderBy($this->leftAttribute)->one();
            }
            if (!$parentNode) {
                //$this->owner->addError('parentNodeId', 'Error');
                return $this->owner->makeRoot();
            }
            return $this->owner->appendTo($parentNode, $runValidation, $attributeNames);
        } else {
            return $this->owner->save($runValidation, $attributeNames);
        }
    }

    public function getPrevious()
    {
        if ($parentNode = $this->owner->parents(1)->one()) {
            return $this->owner::find()
                ->where([$this->depthAttribute => $this->owner->{$this->depthAttribute}])
                ->andWhere(['>', $this->leftAttribute, $parentNode->{$this->leftAttribute}])
                ->andWhere(['<', $this->rightAttribute, $parentNode->{$this->rightAttribute}])
                ->andWhere(['<', $this->leftAttribute, $this->owner->{$this->leftAttribute}])
                ->orderBy([$this->leftAttribute => SORT_DESC])
                ->limit(1)
                ->one();
        }
        return null;
    }

    public function getNext()
    {
        if ($parentNode = $this->owner->parents(1)->one()) {
            return $this->owner::find()
                ->where([$this->depthAttribute => $this->owner->{$this->depthAttribute}])
                ->andWhere(['>', $this->leftAttribute, $parentNode->{$this->leftAttribute}])
                ->andWhere(['<', $this->rightAttribute, $parentNode->{$this->rightAttribute}])
                ->andWhere(['>', $this->leftAttribute, $this->owner->{$this->leftAttribute}])
                ->orderBy([$this->leftAttribute => SORT_ASC])
                ->limit(1)
                ->one();
        }
        return null;
    }

    public function getFullPath()
    {
        return $this->owner->parents()->orderBy([$this->leftAttribute => SORT_ASC])->all();
    }

    public function moveLeft()
    {
        if ($this->owner->allowsUpdate()) if ($previous = $this->getPrevious()) {
            return $this->insertBefore($previous);
        }
        return false;
    }

    public function moveRight()
    {
        if ($this->owner->allowsUpdate()) if ($next = $this->getNext()) {
            return $this->insertAfter($next);
        }
        return false;
    }
}