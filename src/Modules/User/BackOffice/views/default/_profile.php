<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Da\User\Helper\TimezoneHelper;
use XCrm\Helper\ArrayHelper;

/**
 * @var $this    XCrm\Application\Web\View
 * @var $user    XCrm\Modules\User\Model\User
 * @var $profile XCrm\Modules\User\Model\Profile
 */

$timezoneHelper = $profile->make(TimezoneHelper::class);
?>

<?php $form = $this->beginForm(
    [
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
    ]
); ?>
<?php $this->beginContent(__DIR__ . '/update.php', [
      'user' => $user,
      'showAvatar' => false,
]) ?>

<div class="row">
    <div class="col-md-2">

        <div class="form-section">
            <div class="form-section-heading"
                 data-toggle="collapse"
                 data-target="#collapse_media"
                 aria-expanded="true"
            >
                <h4 class="form-section-title">
                    <div class="title-text">Аватар</div>
                    <div class="title-icon">
                        <?=$this->html::img($this->icon('buttons', 'expand', 'color'), ['class' => 'icon-head when-collapsed'])?>
                        <?=$this->html::img($this->icon('buttons', 'collapse', 'color'), ['class' => 'icon-head when-expanded'])?>
                    </div>
                </h4>
            </div>
            <div id="collapse_media" class="panel-collapse expand collapse in">
                <div class="form-section-body">

                <?=$form->field($profile, 'jacket_img')->widget('cutter', [
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
                 data-toggle="collapse"
                 data-target="#collapse_profile"
                 aria-expanded="true"
            >
                <h4 class="form-section-title">
                    <div class="title-text">Редактирование профиля пользователя</div>
                    <div class="title-icon">
                        <?=$this->html::img($this->icon('buttons', 'expand', 'color'), ['class' => 'icon-head when-collapsed'])?>
                        <?=$this->html::img($this->icon('buttons', 'collapse', 'color'), ['class' => 'icon-head when-expanded'])?>
                    </div>
                </h4>
            </div>
            <div id="collapse_profile" class="panel-collapse expand collapse in">
                <div class="form-section-body">

                    <div class="row">
                        <div class="col-md-4"><?= $form->field($profile, 'name_last') ?></div>
                        <div class="col-md-4"><?= $form->field($profile, 'name_first') ?></div>
                        <div class="col-md-4"><?= $form->field($profile, 'name_middle') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><?= $form->field($profile, 'birth_date')->widget('datepickerMask', [
                               'clientOptions' => [
                                    'format' => $this->app->params['datePickerDateFormat']
                               ],
                               'maskOptions' =>  $this->app->params['datePickerMaskOptions'] ?? []
                            ]) ?></div>
                        <div class="col-md-4"><?= $form->field($profile, 'phone') ?></div>
                        <div class="col-md-4"><?= $form->field($profile, 'website') ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6"><?= $form->field($profile, 'location') ?></div>
                        <div class="col-md-6">
                            <?= $form
                                ->field($profile, 'timezone')
                                ->widget('lookup', [
                                    'data' => ArrayHelper::map($timezoneHelper->getAll(), 'timezone', 'name'),
                                    'options' => ['placeholder' => '...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                            ?>
                        </div>
                    </div>

                    <?= $form->field($profile, 'bio')->textarea(['rows' => 8]) ?>

                </div>
            </div>
        </div>

    </div>
</div>





<?php $this->endContent() ?>
<?php $this->endForm(); ?>
