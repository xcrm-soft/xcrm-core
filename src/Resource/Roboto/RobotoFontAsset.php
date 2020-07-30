<?php
/**
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2019, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Resource\Roboto;
use yii\web\AssetBundle;

/**
 * Подключает шрифт Roboto
 *
 * @package XCrm\Resources\RobotoFont
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class RobotoFontAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/font';
    public $css = ['stylesheet.css'];
}