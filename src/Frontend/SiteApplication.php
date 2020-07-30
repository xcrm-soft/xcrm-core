<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Frontend;
use XCrm\Application\Web\Application;
use XCrm\Helper\ArrayHelper;
use XCrm\I18N\Components\I18NRequest;
use XCrm\I18N\Components\I18NUrlManager;

/**
 * Фронт-контроллер веб-сайта.
 *
 * Сайт является типовым веб-приложением и реализует функционал модуля по умолчанию для поиска и
 * вывода статичных страниц, если правилами роутинга управление не было передано другому контроллеру или модулю
 *
 * @property-read PageView $view
 * @property-read I18NRequest $request
 * @property-read I18NUrlManager $urlManager
 *
 * @package XCrm\Frontend
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class SiteApplication extends Application
{
    /**
     * @var string идентификатор модуля по умолчанию
     *     Модуль по умолчанию отвечает за вывод текстовых страниц. Если на маршрут запроса явно не назначен
     *     контроллер или модуль, управление передается модулю по умолчанию для поиска страницы, соответствующей
     *     переданному URL адресу. Если ни одна из страниц модуля не соответствует адресу, выводится
     *     страница ошибки 404.
     */
    public $defaultModule = 'website';
    /**
     * @var string код языка интернационализации по умолчанию
     */
    public $defaultLanguage = 'ru';


    /**
     * Добавляет к предопределенным компонентам менеджер URL адресов и обработчики запроса и ответа
     * с функцией обработки мультиязычных урлов (URL страницы первым вхождением содержит идентификатор языка, либо
     * если первое вхождение урла не соответствует ни одному из идентификаторов языков, то приложение использует
     * язык по умолчанию)
     *
     * @return array
     */
    public function coreComponents()
    {
        return ArrayHelper::merge(parent::coreComponents(), [
            'urlManager' => ['class' => I18NUrlManager::class],
            'request'    => ['class' => I18NRequest::class],
            'view'       => ['class' => PageView::class],
        ]);
    }

    public function runAction($route, $params = [])
    {
        $pos = strpos($route, '/');
        if ($first = substr($route, 0, $pos)) {
            if ($first !== $this->defaultModule) {
                if ($this->hasModule($first)) {
                    $module = $this->getModule($first);
                    $route = substr($route, $pos + 1);
                    return $module->runAction($route, $params);
                }
            }
            $controllerRoute = substr($route, $pos + 1);
        } else {
            $first = $route;
            $controllerRoute = null;
        }

        if ($controller = $this->createController($first)) {

            if ($pos2 = strpos($controllerRoute, '/')) {
                $action  = substr($controllerRoute, 0, $pos2);
                $restUrl = substr($controllerRoute, $pos2 + 1);
            } else {
                if (empty($controllerRoute)) {
                    $action = 'index';
                } else {
                    $action = $controllerRoute;
                }
                $restUrl = null;
            }
            return $controller[0]->runAction($action, array_merge($params, [
                '_rest_url' => $restUrl,
            ]));
        }

        $module = $this->getModule($this->defaultModule);
        return $module->runAction($route, $params);
    }
}