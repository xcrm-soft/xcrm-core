<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\BackOffice;
use XCrm\Application\Web\ThemeAsset;
use XCrm\Resource\FontAwesome\FontAwesomeAsset;
use yii\web\AssetBundle;

class ApplicationAsset extends AssetBundle
{
    public $css = [
        'css/application.css',
    ];
    public $depends = [
        ThemeAsset::class,
        FontAwesomeAsset::class,
    ];
    public function __construct($config = [])
    {
        $config['sourcePath'] = dirname(dirname(__DIR__)) . '/resource/BackOffice/assets';
        parent::__construct($config);
    }
}