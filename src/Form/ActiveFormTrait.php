<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Form;


use XCrm\Application\ApplicationAwareTrait;
use XCrm\Data\ActiveRecordConfigurable;
use XCrm\Data\Model;
use XCrm\Helper\ArrayHelper;
use yii\widgets\ActiveField;

trait ActiveFormTrait
{
    use ApplicationAwareTrait;

    /**
     * Определяет тип поля по его конфигурации и возвращает соответствующий элемент формы
     * @param ActiveRecordConfigurable|Model $model
     * @param $attribute
     * @return mixed
     */
    public function autoField($model, $attribute)
    {
        if ($model->canModify($attribute)) {
            $field = $this->field($model, $attribute);

            if ('parent_id' === $attribute) {
                $this->autoFieldParentId($model, $field);
            } elseif ($attribute = $this->app->attributeManager->get($attribute)) {
                $attribute->formField($model, $field);
            }

            return $field;
        }
        return null;
    }

    /**
     * @param ActiveRecordConfigurable $model
     * @param ActiveField $field
     */
    public function autoFieldParentId($model, $field)
    {
        if ($model::isNestedSets()) {
            $field->widget('lookup', [
                'data' => ArrayHelper::map($model->getValidParentsQuery()->all(), 'id', 'name'),
               // 'multiple' => false,
            ]);
        }
    }
}