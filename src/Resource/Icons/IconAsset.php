<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Resource\Icons;
use yii\web\AssetBundle;

class IconAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/svg';

    public function hasIcon($category, $id, $style = null)
    {
        return file_exists($this->basePath . '/' . $category . '/' . $id . '/' . $style . '.svg');
    }

    public function getIcon($category, $id, $style = null)
    {
        return $this->hasIcon($category, $id, $style)
            ? $this->baseUrl . '/' . $category . '/' . $id . '/' . $style . '.svg'
            : null;
    }
}