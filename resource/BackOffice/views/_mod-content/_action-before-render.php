<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

/** @var $this XCrm\ControlPanel\View */
/** @var $form XCrm\Form\ActiveForm */
/** @var $toolBar array */

$form = $this->beginForm([
    'options' => ['enctype' => 'multipart/form-data']
]);

?><div class="main-content-card">

    <?php if ($this->tabs): ?>
    <div class="card-tabs">
        <ul class="nav nav-tabs">
            <?php foreach ($this->tabs as $tab):
                $classes = ['nav-link'];
                if ($this->context->action->id == $tab['url'][0]) $classes[] = ' active';
                ?>
                <li class="nav-item<?= in_array(' active', $classes) ? ' active' : '' ?>">
                    <?=$this->html::a($tab['label'], $tab['url'], ['class' => implode(' ', $classes)])?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php include __DIR__ . '/_action-toolbar.php' ?>

    <div class="card-body">


