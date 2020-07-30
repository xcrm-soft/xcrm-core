<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

if ($folders):
?>
<div class="main-content-card mb-5">
    <div class="card-body">
        <?=$this->widget('list4', [
            'dataProvider' => new \yii\data\ArrayDataProvider(['models' => $folders]),
            'summary' => false,
            'itemView' => '_category'
        ])?>
    </div>
</div>
<?php
endif;

if ($refs):
?>
    <div class="main-content-card">
        <div class="card-body">
            <?=$this->widget('list4', [
                'dataProvider' => new \yii\data\ArrayDataProvider(['models' => $refs]),
                'summary' => false,
                'itemView' => '_book'
            ])?>
        </div>
    </div>

<?php
endif;
