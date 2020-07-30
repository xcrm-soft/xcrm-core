<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Media;
use kartik\base\InputWidget;
use kartik\file\FileInput;

class ImageWidget extends InputWidget
{
    public function run()
    {
        if ($img = $this->model->getImage($this->attribute)) {
            echo '<div style="padding: 15px;">' . $img . '</div>';
        }

        echo FileInput::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'pluginOptions' => [
                'showPreview' => false,
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'theme' => 'fa',
            ]
        ]);
    }
}