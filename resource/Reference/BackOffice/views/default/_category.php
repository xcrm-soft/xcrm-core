<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

?>

<a href="<?= \yii\helpers\Url::to(['index', 'category' => $model->url])?>" class="btn-block text-center">
    <div style="padding: 8px;">
    <?= $model->getImage('jacket_svg', ['style' => 'height: 48px;', 'alt' => $model->url])?>
    </div>
    <?=$model->name?>
</a>
