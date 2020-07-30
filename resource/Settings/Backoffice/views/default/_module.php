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
 */
?><div class="row links-with-icon">
    <div class="col-xs-2">
        <?= $this->html::img($this->icon('modules', $model['icon'], 'color'), ['class' => 'w-100'])?>
    </div>
    <div class="col-xs-10">
        <h3 class="one-row-title border"><?=$model['title']?></h3>
        <div class="links-box">
            <?php foreach ($model['links'] as $link): ?>
                <?=$this->html::a($link['label'], $link['url']) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>