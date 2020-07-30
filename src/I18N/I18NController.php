<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\I18N;
use XCrm\Application\Web\Controller;

class I18NController extends Controller
{
    public function actionIndex($lang = null)
    {
        $languagesMap = $this->app->i18n->languages;
        if (in_array($lang, $languagesMap)) {
            $this->app->user->setContentLanguage($lang);
        }
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}