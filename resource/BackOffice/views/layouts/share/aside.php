<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

/**
 * @var $this XCrm\ControlPanel\View
 */

$sections = $this->getNavigation()->getSections();
?>

<div class="side-menu-container">
    <?php foreach ($sections as $id => $section):
        if (in_array($id, ['settings'])) continue;
    ?>
    <div class="section-title">
        <?=$section['title']?>
    </div>

    <ul class="list-unstyled components mb-5">
        <?foreach ($section['modules'] as $module): ?>

        <li>
            <a href="#modSubmenu-<?=$module['id']?>" data-toggle="collapse" aria-expanded="false" class="menu-module dropdown-toggle">
                <span class="module-icon"><?=$this->html::img($this->icon('modules', $module['icon'], 'white'))?></span>
                <span class="module-title"><?=$module['title']?></span>
            </a>
            <ul class="collapse module-menu list-unstyled" id="modSubmenu-<?=$module['id']?>">
                <?php
                    $chevron = $this->html::tag('span', '', ['class' => 'fa fa-chevron-right']);
                    foreach ($module['links'] as $link):
                ?>
                <li class="module-link">
                    <?=$this->html::a($chevron . '&nbsp;' . $link['label'], $link['url']) ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php endforeach; ?>
    </ul>

    <?php endforeach; ?>
</div>