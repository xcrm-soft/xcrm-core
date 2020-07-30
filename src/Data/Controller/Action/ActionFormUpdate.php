<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Controller\Action;

/**
 * Действие формы для обновления значений атрибутов модели
 *
 * @package XCrm\Data\Controller\Action
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class ActionFormUpdate extends ActionForm
{
    /**
     * @var string[] по умолчанию при сохранении данных формы производится редирект на
     *     заглавное дейсвие контроллера управления данными
     */
    public $returnUrl = ['index'];

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
                'url'  => ['view', 'id' => $this->model->primaryKey],
                'text' => $this->model::getActionLabel('view', 'link', 'Выйти без сохранения'),
                'visible' => $this->model->getCanBeUpdated(),
                'options' => [
                    'class' => 'btn btn-warning',
                    'icon'  => 'fas fa-undo'
                ],
            ],
        ];
    }
}