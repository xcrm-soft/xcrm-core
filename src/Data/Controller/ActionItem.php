<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Controller;
use XCrm\Data\ActiveRecordConfigurable;
use XCrm\Data\Localization;
use yii\web\NotFoundHttpException;

/**
 * Базовая реализация действия CRUD контроллера для работы с существующей записью
 *
 * @property-read ActiveRecordConfigurable|Localization $model
 *
 * @package XCrm\Data\Controller
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
abstract class ActionItem extends Action
{

    public $queryParamName = 'id';
    /**
     * @var ActiveRecordConfigurable
     * @see getModel()
     * @see setModel()
     */
    protected $_model = null;


    /**
     * Перед выполнением действия производит поиск записи по заданным параметрам
     * @return bool флаг возможности выполнения действия
     * @throws NotFoundHttpException если запись не найдена
     */
    public function beforeRun()
    {
        $this->_model = $this->controller->findModel($this->app->request->get($this->queryParamName));
        $this->createCrumb();
        return true;
    }

    public function getModel()
    {
        return $this->_model;
    }

    public function setModel($model)
    {
        $this->_model = $model;
    }

    /**
     * Возвращает массив параметров для отрисовки представления
     * В общем случает требуется только объект модели
     * @return array
     */
    protected function getVariables()
    {
        return [
            'model' => $this->_model
        ];
    }
}