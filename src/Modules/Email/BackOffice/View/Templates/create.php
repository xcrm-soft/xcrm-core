<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

?><div class="form-section">
    <div class="form-section-heading" aria-expanded="true">
        <h4 class="form-section-title">
            <div class="title-text"><?=$model::t('Параметры шаблона сообщения электронной почты')?></div>
        </h4>
    </div>
    <div class="panel-collapse expand collapse in">
        <div class="form-section-body">
            <?=$form->autoField($model, 'name_system') ?>
            <?=$form->autoField($model, 'heading') ?>
            <?=$form->field($model, 'sender_id')->widget('lookup', [
                'data' => \XCrm\Helper\ArrayHelper::map(\XCrm\Modules\Email\Model\EmailAddress::find()->all(), 'id', 'name_system')
            ]) ?>
            <?=$form->field($model, 'html_id')->widget('lookup', [
                'data' => \XCrm\Helper\ArrayHelper::map(\XCrm\Modules\Smarty\Model\SmartyTemplate::find()->all(), 'id', 'name')
            ]) ?>
            <?=$form->field($model, 'text_id')->widget('lookup', [
                'data' => \XCrm\Helper\ArrayHelper::map(\XCrm\Modules\Smarty\Model\SmartyTemplate::find()->all(), 'id', 'name')
            ]) ?>
        </div>
    </div>
</div>