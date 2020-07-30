<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

/**
 * @var $model XCrm\Data\Model
 * @var $id string
 * @var $title string
 */

?><div class="form-section">
    <div class="form-section-heading"
         data-toggle="collapse"
         data-target="#collapse_<?=$id?>"
         aria-expanded="true"
    >
        <h4 class="form-section-title">
            <div class="title-text"><?=$model::t($title)?></div>
            <div class="title-icon">
                <?=$this->html::img($this->icon('buttons', 'expand', 'color'), ['class' => 'icon-head when-collapsed'])?>
                <?=$this->html::img($this->icon('buttons', 'collapse', 'color'), ['class' => 'icon-head when-expanded'])?>
            </div>
        </h4>
    </div>
    <div id="collapse_<?=$id?>" class="panel-collapse expand collapse in">
        <div class="form-section-body">
        <?php if (!$custom && !file_exists(__DIR__ . '/' . $id . '.php')) {
            foreach ($attributes as $attribute) {
                echo $form->autoField($model, $attribute);
            }
        } else {
            $viewName = $custom ?? $id;
            echo $this->render($viewName, [
                'form' => $form,
                'model' => $model,
            ]);
        }?>
        </div>
    </div>
</div>