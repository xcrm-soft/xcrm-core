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
 * @var $dataProvider yii\data\ArrayDataProvider
 */

$nav = $this->getNavigation()->sections['settings'] ?? null;
?><div class="main-content-card">
    <div class="card-body">
        <?= $this->widget('list4', [
            'dataProvider' => $dataProvider,
            'itemView' => '_module',
            'summary' => false
        ])?>
    </div>
</div>