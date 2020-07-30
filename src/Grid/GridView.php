<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Grid;

use XCrm\Grid\columns\ActionColumn;
use XCrm\Grid\columns\DataColumn;
use XCrm\Grid\columns\DataOffsetColumn;
use XCrm\Grid\columns\SerialColumn;
use XCrm\Grid\columns\SortColumn;
use XCrm\Grid\columns\SwitchColumn;
use Yii;


class GridView extends \yii\grid\GridView
{
    public $dataColumnClass = DataColumn::class;
    /**
     * @var string the layout that determines how different sections of the grid view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{errors}`: the filter model error summary. See [[renderErrors()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     */
    public $layout = "{summary}\n<div class='table-responsive grid-view-widget'>{items}</div>\n{pager}";

    public function getColumnClasses()
    {
        return [
            'serial' => SerialColumn::class,
            'action' => ActionColumn::class,
            'sort'   => SortColumn::class,
            'offset' => DataOffsetColumn::class,
            'switch' => SwitchColumn::class
        ];
    }

    /**
     * Creates column objects and initializes them.
     */
    protected function initColumns()
    {
        if (empty($this->columns)) {
            $this->guessColumns();
        }
        foreach ($this->columns as $i => $column) {
            if (is_string($column)) {
                $column = $this->createDataColumn($column);
            } else {
                if (isset($column['class']) && isset($this->columnClasses[$column['class']])) {
                    $column['class'] = $this->columnClasses[$column['class']];
                }

                $column = Yii::createObject(array_merge([
                    'class' => $this->dataColumnClass ?: DataColumn::class,
                    'grid' => $this,
                ], $column));
            }
            if (!$column->visible) {
                unset($this->columns[$i]);
                continue;
            }
            $this->columns[$i] = $column;
        }
    }
}