<?php
/**
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2019, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Media;
use yii\web\AssetBundle;

class CutterAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets/cutter';
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public $css = [
        'css/cropper.min.css',
        'css/cutter.min.css'
    ];
    public $js = [
        'js/cropper.min.js',
        'js/cutter.min.js'
    ];
}