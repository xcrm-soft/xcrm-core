<?php
/**
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2019, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Grid\columns;
use yii\grid\Column;

class SwitchColumn extends DataColumn
{
    public $controller;

    public $headerOptions = [
        'class' => 'switch-column',
        'style' => 'width: 1%'
    ];

    public $contentOptions = [
        'class' => 'switch-cell',
        'style' => 'white-space: nowrap; padding: 0.5em 2.5em;'
    ];

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $model->{$this->attribute};
        if ($value) {
            return \Yii::$app->view->html::a('<i class="far fa-2x text-success fa-check-circle"></i>', [
                $this->controller ? $this->controller . '/switch' : 'switch',
                'attribute' => $this->attribute,
                'id' => $model->primaryKey,
                'state' => 0
            ], [
                'data-pjax' => 1,
                'title' => 'Выключить'
            ]);
        } else {
            return \Yii::$app->view->html::a('<i class="far fa-2x text-muted fa-dot-circle" style="opacity: .7"></i>', [
                $this->controller ? $this->controller . '/switch' : 'switch',
                'attribute' => $this->attribute,
                'id' => $model->primaryKey,
                'state' => 1
            ], [
                'data-pjax' => 1,
                'title' => 'Включить'
            ]);
        }
    }
}