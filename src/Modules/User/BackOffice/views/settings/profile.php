<?php
use Da\User\Helper\TimezoneHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var XCrm\Application\Web\View          $this
 * @var XCrm\Form\ActiveForm $form
 * @var XCrm\Modules\User\Model\Profile $model
 * @var TimezoneHelper         $timezoneHelper
 */

$this->title = Yii::t('usuario', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
$timezoneHelper = $model->make(TimezoneHelper::class);
$this->heading = 'Параметры учетной записи';




$this->beginContent(__DIR__ . '/_layout.php', [
    'user' => Yii::$app->user->identity,
    'profile' => $model,
    'showAvatar' => false,
    'withSubmitButton' => false,
]);

$form = $this->beginForm([
    'id' => $model->formName(),
    'options' => ['enctype' => 'multipart/form-data'],
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'validateOnBlur' => false,
]);

?>
    <div class="card-toolbar sticky-top border-top-0">
        <?= $this->html::submitButton(Yii::t('usuario', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <div class="row" style="margin-top: 1em;">
        <div class="col-md-2">
            <div class="form-section">
                <div class="form-section-heading"
                     aria-expanded="true"
                >
                    <h4 class="form-section-title">
                        <div class="title-text">Пользователь</div>
                    </h4>
                </div>
                <div id="avatar" class="panel-collapse expand collapse in">
                    <div class="form-section-body">
                        <?=$form->field($model, 'jacket_img')->widget('cutter', [
                            'jcropOptions' => [
                                'aspectRatio' => 1,
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="form-section">
                <div class="form-section-heading"
                     aria-expanded="true"
                >
                    <h4 class="form-section-title">
                        <div class="title-text"><?=Yii::t('usuario', 'Profile settings')?></div>
                    </h4>
                </div>
                <div id="profile" class="panel-collapse expand collapse in">
                    <div class="form-section-body">
                        <div class="row">
                            <div class="col-md-4"> <?= $form->field($model, 'name_last') ?> </div>
                            <div class="col-md-4"> <?= $form->field($model, 'name_first') ?> </div>
                            <div class="col-md-4"> <?= $form->field($model, 'name_middle') ?> </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"> <?= $form->field($model, 'birth_date') ?> </div>
                            <div class="col-md-4"> <?= $form->field($model, 'phone') ?> </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"> <?= $form->field($model, 'location') ?> </div>
                            <div class="col-md-4"> <?= $form->field($model, 'website') ?> </div>
                            <div class="col-md-4"> <?= $form
                                    ->field($model, 'timezone')
                                    ->dropDownList(ArrayHelper::map($timezoneHelper->getAll(), 'timezone', 'name'));
                                ?> </div>
                        </div>
                        <?= $form->field($model, 'bio')->textarea() ?>
                    </div>
                </div>
        </div>
    </div>




<?php

$this->endForm();

$this->endContent();