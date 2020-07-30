<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */


/**
 * @var $this XCrm\ControlPanel\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $filterModel XCrm\Data\Model\ActiveSearch
 * @var $columns array|null
 */

include '_action-before-render.php';

echo $this->widget('grid', [
    'dataProvider' => $dataProvider,
    'filterModel' => $filterModel,
    'columns' => $columns,
]);

if ($this->context->modelClass::isNestedSets()) {
    // @todo добавтиь хинт про удаление узла со сдвигом подчиненных узлов вверх
}

include '_action-after-render.php';