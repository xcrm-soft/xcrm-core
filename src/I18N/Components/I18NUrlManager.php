<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\I18N\Components;
use XCrm\Application\Web\UrlManager;

class I18NUrlManager extends UrlManager
{
    public $enablePrettyUrl = true;
    public $showScriptName = false;

    public function getLanguages()
    {
        return $this->app->i18n->languages;
    }

    public function getDefaultLanguage()
    {
        return strtolower($this->app->defaultLanguage);
    }

    public function createUrl($params, $throwException = true)
    {
        $language = null;
        /* if (isset($params['language'])) { // строим урл для указанного языка
             if (!isset($this->getLanguages()[$params['language']])) {
                 if ($throwException) throw new InvalidArgumentException('Unknown language id ' . $params['language']);
             }
             $language = strtolower($params['language']);
             unset($params['language']);
         } else {*/
        $language = strtolower($this->app->request->requestedLanguage ?? $this->app->defaultLanguage);
        //}

        if ($language === $this->getDefaultLanguage()) {
            $language = null;
        }

        $url = parent::createUrl($params);

        if ($language) {
            return '/' == $url ? '/' . $language : '/' . $language . $url;
        } else {
            return $url;
        }

    }
}