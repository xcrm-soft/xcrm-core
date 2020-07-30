<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

use yii\bootstrap\Nav;

/**
 * @var $content string
 */
?><div class="card main-content-card">


    <div class="card-tabs">

        <?php $items = [
            ['label' => Yii::t('usuario', 'Profile'), 'url' => ['/user/settings/profile']],
            ['label' => Yii::t('usuario', 'Account'), 'url' => ['/user/settings/account']],
            ['label' => Yii::t('usuario', 'Privacy'),
                'url' => ['/user/settings/privacy'],
                'visible' => $module->enableGdprCompliance && false
            ],
            [
                'label' => Yii::t('usuario', 'Networks'),
                'url' => ['/user/settings/networks'],
                'visible' => $networksVisible && false,
            ],
        ];

        foreach ($items as $id => $tab) {
            if ($this->context->action->id == $tab['url'][0]) {
                $items[$id]['options'] = ['class' => 'active'];
            }
        }
        ?>

        <?= Nav::widget(
            [
                'options' => [
                    'class' => 'nav nav-tabs main-nav-tabs',
                ],
                'items' => $items
            ]
        ) ?>
    </div>

    <?php if ($withSubmitButton ?? true): ?>
        <div class="card-toolbar sticky-top border-top-0">
            <?= $this->html::submitButton(Yii::t('usuario', 'Update'), ['class' => 'btn btn-success']) ?>
        </div>
    <?php endif ?>

    <?php $showAvatar = $showAvatar ?? true ?>

    <div class="card-body">
        <?php if ($showAvatar): ?>
        <div class="row">
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

                            <div style="margin-bottom: 1em">
                                <?php
                                $profile = $user->profile;
                                $avatar = $profile->getJacketUrl();
                                echo $this->html::img($avatar, ['class' => 'w-100']);
                                ?>
                            </div>
                            <div class="mt-2">

                                <strong style="display: block; margin: .5em 0 1em 0;"><?=$profile->name_last?> <?=$profile->name_first?> <?=$profile->name_middle?>
                                    <br/><span class="text-info">@<?=$user->username?></span>
                                </strong>

                                <?php if ($profile->birth_date): ?>
                                    <i class="fa fa-fw fa-calendar-alt"></i> <?=Yii::$app->formatter->asDate($profile->birth_date, 'd.M.Y') ?><br/>
                                <?php endif; ?>

                                <?php if ($profile->location): ?>
                                    <i class="fa fa-fw fa-map-marker-alt"></i> <?=$profile->location?> <br/>
                                <?php endif; ?>

                                <i class="fa fa-fw fa-envelope"></i> <?=$user->email?> <br/>

                                <?php if ($profile->phone): ?>
                                    <i class="fa fa-fw fa-phone"></i> <?=$profile->phone?> <br/>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <?php endif; ?>

                <?= $content ?>

                <?php if ($showAvatar): ?>
            </div>
        </div>
    <?php endif; ?>

    </div>
</div>