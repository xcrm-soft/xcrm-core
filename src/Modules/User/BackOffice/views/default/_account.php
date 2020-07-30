<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var yii\web\View $this */
/* @var Da\User\Model\User $user */

?>

<?php $form = ActiveForm::begin(
    [
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
    ]
); ?>

<?php $this->beginContent(__DIR__ . '/update.php', ['user' => $user]) ?>

<div class="form-section">
    <div class="form-section-heading"
         data-toggle="collapse"
         data-target="#collapse_profile"
         aria-expanded="true"
    >
        <h4 class="form-section-title">
            <div class="title-text">Редактирование учетных данных</div>
            <div class="title-icon">
                <?=$this->html::img($this->icon('buttons', 'expand', 'color'), ['class' => 'icon-head when-collapsed'])?>
                <?=$this->html::img($this->icon('buttons', 'collapse', 'color'), ['class' => 'icon-head when-expanded'])?>
            </div>
        </h4>
    </div>
    <div id="collapse_profile" class="panel-collapse expand collapse in">
        <div class="form-section-body">

<?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'password')->passwordInput() ?>

        </div>
    </div>
</div>


<?php $this->endContent() ?>
<?php ActiveForm::end(); ?>
