<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

if ($toolBar):
    if (!isset($toolBar['buttons'])) $toolBar['buttons'] = [];
    ?>
    <div class="card-toolbar">
        <div class="card-toolbar-buttons">
            <?php foreach ($toolBar['buttons'] as $button) {
                if (!isset($button['visible'])) $button['visible'] = true;
                if ($button['visible']) {
                    echo $this->html::renderButton($button) . ' ';
                }
            }
            ?>
        </div>
        <div class="card-toolbar-languages">
            <?php if (isset($toolBar['languageSelector'])):
                $languageSelector = $toolBar['languageSelector'];
                ?>
                <div  style="flex-grow: 0;">
                    <div class="dropdown pull-right">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?=$languageSelector['current']?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <?php foreach ($languageSelector['languages'] as $v => $name):
                                if($v == $languageSelector['current']) continue;
                                ?>
                                <li><?= $this->html::a($name, ['/content-language', 'lang' => $v]) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>