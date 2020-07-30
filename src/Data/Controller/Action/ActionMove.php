<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Controller\Action;
use XCrm\Data\Controller\Action;

/**
 * Перемещение узла (записи) в пределах модели
 *
 * @package XCrm\Data\Controller\Action
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class ActionMove extends Action
{
    const MOVE_NONE = 0;
    const MOVE_LEFT = 1;
    const MOVE_RIGHT = 2;
    public $rememberUrl = false;
    public $direction = self::MOVE_NONE;
    public $returnUrl = null;

    protected $_model;

    public function run()
    {
        switch ($this->direction) {
            case self::MOVE_RIGHT:
                if ($this->_model->getNext()) {
                    $this->_model->moveRight();
                }
                break;

            case self::MOVE_LEFT:
                if ($this->_model->getPrevious()) {
                    $this->_model->moveLeft();
                }
                break;
        }

        if ($this->getApp()->request->isPjax) {

        }
        return $this->controller->redirect($this->resolveCallable($this->returnUrl) ?? \Yii::$app->request->referrer ?? ['index']);
    }

    public function beforeRun()
    {
        $this->_model = $this->controller->findModel($this->app->request->get('id'));
        return parent::beforeRun();
    }
}