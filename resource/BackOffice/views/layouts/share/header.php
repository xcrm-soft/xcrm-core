<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

?><nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><?=$this->html::img($this->params['asset']['application']->baseUrl . '/img/xcrm-logo.svg', ['class' => 'brand-logo'])?></a>
        </div>

        <?php if (!Yii::$app->user->isGuest): ?>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@&nbsp;<?=$this->app->user->identity->username?><span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-header">Nav header</li>
                        <li><?= $this->html::a('Профиль', ['/user/settings'], ['class' => 'dropdown-item', 'data-method' => 'post']) ?></li>
                        <li><?= $this->html::a('Аккаунт', ['/user/settings/account'], ['class' => 'dropdown-item', 'data-method' => 'post']) ?></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->html::a('Выйти', ['/user/security/logout'], ['class' => 'dropdown-item', 'data-method' => 'post']) ?></li>
                    </ul>
                </li>
                <li><a href="#">Support</a></li>
            </ul>
        </div><!--/.nav-collapse -->
        <?php endif ?>
    </div>
</nav>