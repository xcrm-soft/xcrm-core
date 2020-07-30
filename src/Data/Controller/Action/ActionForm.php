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
use XCrm\Data\Controller\ActionItem;
use XCrm\Helper\ArrayHelper;
use Yii;

abstract class ActionForm extends ActionItem
{
    public $viewName = 'form';
    public $returnUrl;

    public function performActions($returnBoolValue = false)
    {
        if (!$this->_model) return null;

        if ($this->_model->load($this->app->request->post())) {
            // $this->_model->dump();
            if ($this->model->validate() && $this->_model->smartSave()) {
                Yii::$app->session->addFlash('success', 'Данные успешно сохранены');
                return $returnBoolValue
                    ? true
                    : $this->controller->redirect($this->resolveCallable($this->returnUrl));
            } else {
                Yii::$app->session->addFlash('error', 'Не удалось сохранить данные');
                return false;
            }
        }
    }

    public function getVariables()
    {
        return ArrayHelper::merge(parent::getVariables(), [
            'media' => [
                'title' => 'Медиа',
                'attributes' => ['jacket_img', 'jacket_svg'],
            ],
            'main' => [
                'main' => [
                    'title' => 'Основная информация',
                    'attributes' => ['parent_id', 'key_name', 'key_value', 'uuid', 'table_name', 'class_name',
                        'order_id', 'name', 'url', 'is_active', 'is_primary', 'is_secondary',
                        'email', 'email_name', 'email_reply', 'email_reply_name'
                    ],
                ],
                'content' => [
                    'title' => 'Содержание страницы',
                    'attributes' => ['heading', 'heading_level', 'content_short', 'content_full'],
                ],
                'seo' => [
                    'title' => 'SEO',
                    'attributes' => ['meta_title', 'meta_keywords', 'meta_description', 'jacket_img_alt', 'jacket_svg_alt'],
                ],
            ]
        ]);
    }

    public function getDefaultToolbar()
    {
        if (!$this->_model) return null;

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
        ];
    }

    public function __construct($id, $controller, $config = [])
    {
        if (!isset($config['returnUrl'])) $config['returnUrl'] = function(ActionItem $action) {
            return ['view', 'id' => $action->model->primaryKey];
        };
        parent::__construct($id, $controller, $config);
    }
}