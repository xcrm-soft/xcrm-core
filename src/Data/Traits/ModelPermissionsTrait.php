<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Traits;

/**
 * Трейт для моделей, реализует управление разграничением доступа к данным
 * и к выполнению действий над данными
 *
 * @package XCrm\Data\Traits
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
trait ModelPermissionsTrait
{
    /**
     * Конфигуратор имен разрешений, необходимых пользователю для выполнения действий
     * над данной моделью
     * @return array
     */
    public static function actionPermissions()
    {
        return [];
    }

    /**
     * @param string $action идентификатор действия над моделью
     * @return string|null
     */
    public static function getPermissionName($action)
    {
        return static::actionPermissions()[$action] ?? null;
    }

    public static function checkPermissionName($action, $defaultValue = true)
    {
        if ($permission = static::getPermissionName($action)) {
            return \Yii::$app->user->can($permission);
        }
        return $defaultValue;
    }

    /**
     * Возвращает флаг доступности обзора списка записей модели
     * @return bool
     */
    public static function allowsIndex()
    {
        return static::checkPermissionName('index');
    }

    /**
     * Возвращает флаг доступности детального просмотра одной записи модели
     * Метод не учитывает права доступа к конкретной записи, возвращает только общее разрешение, то есть,
     * если пользователю разрешено просматривать только одну из записей, метод возвращает всегда true
     * @return bool
     */
    public static function allowsView()
    {
        return static::checkPermissionName('view');
    }

    /**
     * Возвращает флаг доступности добавления записей модели
     * @return bool
     */
    public static function allowsCreate()
    {
        return static::checkPermissionName('create');
    }

    /**
     * Возвращает флаг доступности редактирования одной записи модели
     * Метод не учитывает права доступа к конкретной записи, возвращает только общее разрешение, то есть,
     * если пользователю разрешено редактировать только одну из записей, метод возвращает всегда true
     * @return bool
     */
    public static function allowsUpdate()
    {
        return static::checkPermissionName('update');
    }

    /**
     * Возвращает флаг, может ли данная запись быть отредактирована пользователем приложения
     * @return bool
     */
    public function getCanBeUpdated()
    {
        return static::allowsUpdate();
    }

    /**
     * Возвращает флаг доступности удаления одной записи модели
     * Метод не учитывает права доступа к конкретной записи, возвращает только общее разрешение, то есть,
     * если пользователю разрешено удалять только одну из записей, метод возвращает всегда true
     * @return bool
     */
    public static function allowsDelete()
    {
        return static::checkPermissionName('delete');
    }

    /**
     * Возвращает флаг, может ли данная запись быть удалена пользователем приложения
     * @return bool
     */
    public function getCanBeDeleted()
    {
        return static::allowsDelete();
    }
}