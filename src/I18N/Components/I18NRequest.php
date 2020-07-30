<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\I18N\Components;
use XCrm\Application\Web\Request;

class I18NRequest extends Request
{
    /**
     * @var null|string чистый URL без параметра локализации
     */
    private $_clearUrl = null;

    public $requestedLanguage = null;

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {
        if (null === $this->_clearUrl) {
            $requestUrl = parent::getUrl();
            $urlList = explode('/', $requestUrl);
            $lang = isset($urlList[1]) ? $urlList[1] : null;

            if ($lang && in_array($lang, $this->app->i18n->getLanguages())) {
                $this->requestedLanguage = $lang;
                $this->_clearUrl = str_replace('//', '/', '/' . substr($requestUrl, mb_strlen($lang) + 1));
                if ($lang === $this->app->defaultLanguage) {
                    $this->app->response->redirect($this->_clearUrl)->send();
                } else {
                    $this->app->language = $lang;
                }
            } else {
                $this->app->language = $this->app->defaultLanguage;
                $this->_clearUrl = $requestUrl;
            }
        }

        return $this->_clearUrl;
    }
}