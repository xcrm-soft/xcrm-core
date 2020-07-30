<?php
/**
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2019, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Grid\columns;
use yii\grid\Column;

class SortColumn extends Column
{
    public $actionMoveLeft = 'move-left';
    public $actionMoveRight = 'move-right';
    public $controller;

    public $headerOptions = [
        'style' => 'width: 1%;'
    ];

    public $contentOptions = [
        'class' => 'buttons-cell',
        'style' => 'white-space: nowrap'
    ];

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $action = \Yii::$app->controller->action->id;

        $options = ['class' => 'btn btn-primary', 'data-role' => 'items-sort', 'data-pjax' => 1, 'data-pjax-from' => $action];

        $u = \Yii::$app->view->html::a('<i class="fas fa-arrow-up"></i>', [$this->controller . '/' . $this->actionMoveLeft, 'id' => $model->primaryKey], $options);
        $options['class'] .= ' ml-1';
        $d = \Yii::$app->view->html::a('<i class="fas fa-arrow-down"></i>', [$this->controller . '/' . $this->actionMoveRight, 'id' => $model->primaryKey], $options);

        return $u . $d;
    }
}