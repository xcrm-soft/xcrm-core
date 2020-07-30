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
 * @var $media array
 * @var $main array
 */

include '_action-before-render.php';

$mediaVisible = $model->canModifyOneOf($media['attributes']);
?><div class="row">
    <?php if ($mediaVisible): ?>
    <div class="col-md-2">
        <?=$this->render('form/_section', array_merge($media, [
            'id' => 'media',
            'form' => $form,
            'model' => $model,
            'custom' => $custom['media'] ?? null,
        ]))?>
    </div>
    <?php endif ?>
    <div class="col-md-<?=$mediaVisible ? 10 : 12?>">

        <?php
        if ($innerView) {

            echo $this->render($innerView, [
                'form' => $form,
                'model' => $model
            ]);

        } else foreach ($main as $id=>$section) if ($model->canModifyOneOf($section['attributes']))
            echo $this->render('form/_section', array_merge($section, [
                'id' => $id,
                'form' => $form,
                'model' => $model,
                'custom' => $custom[$id] ?? null
            ]));
        ?>
    </div>
</div><?php

include '_action-after-render.php';