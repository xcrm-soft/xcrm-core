<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Da\User\Model\User;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;

/**
 * @var View   $this
 * @var User   $user
 * @var string $content
 */

if (!isset($withSubmitButton)) $withSubmitButton = true;

$this->title = Yii::t('usuario', 'Update user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('usuario', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$showAvatar = $showAvatar ?? true;
?>

<div class="main-content-card card">

    <div class="card-tabs">

        <?php $items = [
                    [
                        'label' => Yii::t('usuario', 'Information'),
                        'url' => ['info', 'id' => $user->id],
                    ],
                    [
                        'label' => Yii::t('usuario', 'Account details'),
                        'url' => ['update', 'id' => $user->id],
                    ],
                    [
                        'label' => Yii::t('usuario', 'Profile details'),
                        'url' => ['update-profile', 'id' => $user->id],
                    ],
                    [
                        'label' => Yii::t('usuario', 'Assignments'),
                        'url' => ['assignments', 'id' => $user->id],
                    ],
                    [
                        'label' => Yii::t('usuario', 'Confirm'),
                        'url' => ['confirm', 'id' => $user->id],
                        'visible' => !$user->isConfirmed,
                        'linkOptions' => [
                            'class' => 'text-success',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t(
                                'usuario',
                                'Are you sure you want to confirm this user?'
                            ),
                        ],
                    ],
                    [
                        'label' => Yii::t('usuario', 'Block'),
                        'url' => ['block', 'id' => $user->id],
                        'visible' => !$user->isBlocked,
                        'linkOptions' => [
                            'class' => 'text-danger',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t(
                                'usuario',
                                'Are you sure you want to block this user?'
                            ),
                        ],
                    ],
                    [
                        'label' => Yii::t('usuario', 'Unblock'),
                        'url' => ['block', 'id' => $user->id],
                        'visible' => $user->isBlocked,
                        'linkOptions' => [
                            'class' => 'text-success',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t(
                                'usuario',
                                'Are you sure you want to unblock this user?'
                            ),
                        ],
                    ],
                    [
                        'label' => Yii::t('usuario', 'Delete'),
                        'url' => ['delete', 'id' => $user->id],
                        'linkOptions' => [
                            'class' => 'text-danger',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t(
                                'usuario',
                                'Are you sure you want to delete this user?'
                            ),
                        ],
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

    <?php if ($withSubmitButton): ?>
    <div class="card-toolbar sticky-top border-top-0">
        <?= Html::submitButton(Yii::t('usuario', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php endif ?>

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


