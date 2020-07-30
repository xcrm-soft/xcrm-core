<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Widget;
use yii\widgets\ListView;

class ListView4 extends ListView
{
    public $options = ['class' => 'list-view'];

    public function renderBeforeItem($model, $key, $index)
    {
        switch ($index % 4) {
            case 0:
                return '<div class="row"><div class="col-md-6"><div class="row"><div class="col-sm-6">';
            case 1:
            case 3:
                return '<div class="col-sm-6">';
            case 2:
                return '<div class="col-md-6"><div class="row"><div class="col-sm-6">';

        }
        return parent::renderBeforeItem($model, $key, $index);
    }

    public function renderAfterItem($model, $key, $index)
    {
        switch ($index % 4) {
            case 0:
            case 2:
                return '</div>';
            case 1:
                return '</div></div></div>';
            case 3:
                return '</div></div></div></div>';
        }
        return parent::renderAfterItem($model, $key, $index);
    }

    public function renderItems()
    {
        $index = null;
        $models = $this->dataProvider->getModels();
        $keys = $this->dataProvider->getKeys();

        foreach (array_values($models) as $index => $model) {

            $key = $keys[$index];
            if (($before = $this->renderBeforeItem($model, $key, $index)) !== null) {
                $rows[] = $before;
            }

            $rows[] = $this->renderItem($model, $key, $index);

            if (($after = $this->renderAfterItem($model, $key, $index)) !== null) {
                $rows[] = $after;
            }

        }

        $html = implode($this->separator, $rows);

        if ($index || 0 === $index) switch ($index % 4) {
            case 0:
            case 2:
                $html .= $this->separator . '</div></div></div>';
                break;
            case 1:
                $html .= $this->separator . '</div>';
                break;
        }

        return $html;
    }
}