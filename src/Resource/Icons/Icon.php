<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Resource\Icons;
use XCrm\Application\Base\Component;
use yii\web\AssetBundle;

class Icon extends Component
{
    /**
     * @var array дополнительные пакеты иконок в порядке приоритета для поиска
     */
    public $bundles = [];
    public $defaultBundle = IconAsset::class;

    private $_published = [];

    public function getIcon($category, $id, $style)
    {
        foreach ($this->bundles as $bundle) {
            $asset = $this->getPublished($bundle);
            if ($icon = $asset->getIcon($category, $id, $style)) {
                return $icon;
            }
        }

        $asset = $this->getPublished($this->defaultBundle);
        if ($icon = $asset->getIcon($category, $id, $style)) {
            return $icon;
        }
        if (file_exists($asset->basePath . '/' . $category . '/' . $style . '.svg')) {
            return $asset->baseUrl . '/' . $category . '/' . $style . '.svg';
        }
        if (file_exists($asset->basePath . '/' . $style . '.svg')) {
            return $asset->basePath . '/' . $style . '.svg';
        }
        return $asset->basePath . '/color.svg';
    }

    /**
     * @param string|AssetBundle $asset
     * @return AssetBundle|IconAsset
     */
    public function getPublished($asset)
    {
        if (!isset($this->_published[$asset])) {
            $this->_published[$asset] = $asset::register(\Yii::$app->view);
        }
        return $this->_published[$asset];
    }
}