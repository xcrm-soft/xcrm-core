<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application\Web;
use XCrm\Application\ApplicationAwareTrait;
use yii\web\AssetBundle;

class Theme extends \yii\base\Theme
{
    use ApplicationAwareTrait;

    public function getHtml()
    {
        return Html::class;
    }

    public function getCoreWidgets()
    {
        return [];
    }

    /**
     * Возвращает массив конфигураций банддов ресурсов
     * Если для когнфигурации бандла задан строковый ключ $keyName, его его объект будет сохранен
     * в параметрах представления $view->params['asset'][$keyName]
     * @return AssetBundle[]
     */
    public function assets()
    {
        return [];
    }

    /**
     * Регистрирует в представлении бандлы ресурсов
     * @param View $view
     */
    final public function registerAssetBundles(View $view)
    {
        foreach ($this->assets() as $k=>$className) {
            $asset = $className::register($view);
            if (is_string($k)) $view->params['asset'][$k] = $asset;
        }
    }
}