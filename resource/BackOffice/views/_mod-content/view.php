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
 * @var $model XCrm\Data\ActiveRecord
 */

include '_action-before-render.php';
$local = $model->localize();
echo \yii\widgets\DetailView::widget([
    'model' => $local, 'attributes' => $local->attributes()
]);

include '_action-after-render.php';