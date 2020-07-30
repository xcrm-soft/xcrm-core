<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */
namespace XCrm\Data\Controller\Action;
use yii\web\NotFoundHttpException;

/**
 * Действие для ручного перевода значений атрибутов модели на выбранный язык инфтерфейса
 *
 * @package XCrm\Data\Controller\Action
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class ActionTranslate extends ActionFormUpdate
{
    /**
     * {@inheritDoc}
     */
    public function beforeRun()
    {
        if ($mainModel = $this->controller->findModel($this->app->request->get($this->queryParamName))) {
            $this->model = $mainModel->getLocalizationModel(null, true);
            $this->createCrumb();
            return true;
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function createCrumb()
    {
        if ($this->model->canGetProperty('name')) {
            $this->defaultTitle = strtoupper($this->model->language);
        }
        parent::createCrumb();
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultToolbar()
    {
        if (!$this->model) return null;

        return [
            'submit' => [
                'type'    => 'submit',
                'text'    => 'Сохранить изменения',
                'visible' => true,
                'options' => [
                    'class' => 'btn btn-primary',
                    'icon'  => 'far fa-save'
                ],
            ],

            'view' => [
                'type' => 'link',
                'url'  => ['view', 'id' => $this->model->master_id],
                'text' => $this->model::getActionLabel('view', 'link', 'Выйти без сохранения'),
                'visible' => $this->model->getCanBeUpdated(),
                'options' => [
                    'class' => 'btn btn-warning',
                    'icon'  => 'fas fa-undo'
                ],
            ],
        ];
    }

    public function __construct($id, $controller, $config = [])
    {
        if (!isset($config['returnUrl'])) $config['returnUrl'] = function(ActionTranslate $action) {
            return ['view', 'id' => $action->model->master_id];
        };
        parent::__construct($id, $controller, $config);
    }
}