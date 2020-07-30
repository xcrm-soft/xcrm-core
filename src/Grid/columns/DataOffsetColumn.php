<?php
/**
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2019, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Grid\columns;


class DataOffsetColumn extends DataColumn
{
    public $offsetAttribute = 'tk_depth';
    public $offsetModifier = 25;

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return \Yii::$app->view->html::tag('div', parent::renderDataCellContent($model, $key, $index), [
            'style' => 'padding-left: ' . (intval($model->{$this->offsetAttribute}) * intval($this->offsetModifier)) . 'px;'
        ]);
    }
}