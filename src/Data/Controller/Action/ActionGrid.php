<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Controller\Action;

/**
 * Расширяет класс действия для вывода списков данных конфигурацией колонок грида
 *
 * @package XCrm\Data\Controller\Action
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class ActionGrid extends ActionList
{
    public $columns = null;
    public $viewName = 'grid';

    public function getDefaultToolbar()
    {
        return [
            'submit' => [
                'type' => 'link',
                'url'  => ['create'],
                'text' => $this->modelClass::actionLabels()['create']['link'] ?? static::t('Добавить запись'),
                'visible' => $this->modelClass::allowsCreate(),
                'options' => [
                    'class' => 'btn btn-primary',
                    'icon'  => 'fas fa-plus'
                ],
            ],
        ];
    }

    public function getColumnConfig()
    {
        if (null === $this->columns) {
            $this->columns = $this->guessColumns();
        }
        foreach ($this->columns as $k=>$v) {
            $this->columns[$k] = $this->formatColumn($v);
        }
        return $this->columns;
    }

    public function guessColumns()
    {
        $columns = ['@serial'];
        if ($this->modelClass::isSortable() || $this->modelClass::isNestedSets()) $columns[] = '@sort';
        if ($this->modelClass::hasTableColumn('name')) {
            if ($this->modelClass::isNestedSets()) {
                $columns[] = ['class' => 'offset', 'attribute' => 'name'];
            } else {
                $columns[] = 'name';
            }
        }
        $cols = ['jacket_svg', 'key_name', 'url', 'uuid', 'is_active', 'is_primary', 'is_secondary'];
        foreach ($cols as $col) if ($this->modelClass::hasTableColumn($col)) $columns[] = $this->formatColumn($col);
        $columns[] = '@action';

        return $columns;
    }

    protected function formatColumn($v)
    {
        if (is_string($v)) {


            if ('@' == substr($v, 0, 1)) {
                $column = ['class' => substr($v, 1)];
                if ('sort' == $column['class']) {
                    $column['controller'] = $this->controller->id;
                }
                return $column;
            }


            if (in_array($v, ['jacket_img', 'jacket_svg'])) {
                return [
                    'attribute' => $v,
                    'content' => function($model) use ($v){
                        return $model->getImage($v, ['class' => 'grid-image']);
                    },
                    'options' => ['class' => 'col-image']
                ];
            }


        }



        return $v;
    }

    /**
     * {@inheritDoc}
     */
    public function getVariables()
    {
        $variables = parent::getVariables();
        $variables['columns'] = $this->getColumnConfig();
        return $variables;
    }
}