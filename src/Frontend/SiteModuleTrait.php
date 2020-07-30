<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Frontend;
use yii\base\InvalidRouteException;


trait SiteModuleTrait
{
    /**
     * Если для модуля установлен контроллер с идентификатором site, будет произведена попытка поиска сущности
     * по урлу и в случае успеха - запуск соответствующего типу сущности действия.
     * Если поиск сущности вернул false и не выбросил исключение, управление будет передано
     * стандартному методу runAction()
     *
     * @param  string $route
     * @param  array $params
     * @return mixed
     * @throws InvalidRouteException
     */
    public function runAction($route, $params = [])
    {
        if ($controller = $this->createController('site')) {
            if (($response = $controller[0]->runActionByUrl($route, $params)) !== null) {
                return $response;
            }
        }
        return parent::runAction($route, $params);
    }
}