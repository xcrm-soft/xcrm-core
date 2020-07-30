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
use Yii;

class ActionRemove extends Action
{
    public $rememberUrl = false;
    public $returnUrl = null;

    protected $_model;

    public function run()
    {
        if ($this->_model->allowsDelete()) {
            if ($this->_model->delete()) {
                Yii::$app->session->addFlash('success', 'Запись успешно удалена');
            } else {
                Yii::$app->session->addFlash('error', 'При удалении записи произошла ошибка');
            }
        } else {
            Yii::$app->session->addFlash('warning', 'Запись не может быть удалена');
        }
        return $this->controller->redirect($this->resolveCallable($this->returnUrl) ?? \Yii::$app->request->referrer ?? ['index']);
    }

    public function beforeRun()
    {
        $this->_model = $this->controller->findModel($this->app->request->get('id'));
        return parent::beforeRun();
    }
}