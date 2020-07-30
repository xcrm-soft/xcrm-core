<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Controller\Action;
use XCrm\Data\Controller\ActionItem;
use yii\web\NotFoundHttpException;

class ActionView extends ActionItem
{
    public $viewName = 'view';

    /**
     * Перед выполнением действия производит поиск записи по заданным параметрам
     * @return bool флаг возможности выполнения действия
     * @throws NotFoundHttpException если запись не найдена
     */
    public function beforeRun()
    {
        $this->_model = $this->controller->findModel($this->app->request->get($this->queryParamName));
        $this->createCrumb();
        if ($this->_model::hasLocalizations()) {

        }
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function createCrumb()
    {
        if ($this->_model->canGetProperty('name')) {
            $this->defaultTitle = 'Обзор';
        }
        parent::createCrumb();
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultToolbar()
    {
        return [
            'update' => [
                'type' => 'link',
                'url'  => ['update', 'id' => $this->_model->id],
                'text' => $this->_model::actionLabels()['update']['link'] ?? 'Редактировать',
                'visible' => $this->_model->getCanBeUpdated(),
                'options' => [
                    'class' => 'btn btn-primary',
                    'icon'  => 'fas fa-edit'
                ],
            ],

            'translate' => [
                'type' => 'link',
                'url'  => ['translate', 'id' => $this->_model->id],
                'text' => $this->_model::actionLabels()['translate']['link'] ?? 'Изменить перевод',
                'visible' => $this->_model->getCanBeTranslated(),
                'options' => [
                    'class' => 'btn btn-primary',
                    'icon'  => 'fas fa-edit'
                ],
            ],

            'delete' => [
                'type' => 'link',
                'url'  => ['delete', 'id' => $this->_model->id],
                'text' => $this->_model::actionLabels()['delete']['link'] ?? 'Удалить',
                'visible' => $this->_model->getCanBeDeleted(),
                'options' => [
                    'class' => 'btn btn-danger',
                    'icon'  => 'far fa-trash-alt',
                    'data-confirm' => 'Че бля, в натуре?',
                    'data-method' => 'post'
                ],
            ],
        ];
    }
}