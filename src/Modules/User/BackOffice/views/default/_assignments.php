<?php
/* @var XCrm\Application\Web\View $this */
/* @var XCrm\Modules\User\Model\User $user */


?>
<?php $form = $this->beginForm([
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
])?>

<?php $this->beginContent(__DIR__ . '/update.php', ['user' => $user]) ?>

<div class="form-section">
    <div class="form-section-heading"
         aria-expanded="true"
    >
        <h4 class="form-section-title">
            <div class="title-text">Редактирование назначений</div>
        </h4>
    </div>
    <div id="info" class="panel-collapse expand collapse in">
        <div class="form-section-body">

            <?= $this->html::activeHiddenInput($model, 'user_id') ?>

            <?= $form->field($model, 'items')->widget('selectize',
                [
                    'items' => $availableItems,
                    'options' => [
                        'id' => 'children',
                        'multiple' => true,
                    ],
                ]
            ) ?>

        </div>
    </div>
</div>

<?php $this->endContent() ?>
<?php $this->endForm() ?>
