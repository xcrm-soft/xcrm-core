<?php
/**
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2019, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Grid\columns;
use yii\db\ActiveRecord;
use yii\bootstrap\Html;
use Yii;
use yii\helpers\Url;


class ActionColumn extends \yii\grid\ActionColumn
{
    public $template = '{view}{update}{delete}';
    public $contentOptions = ['class' => 'buttons-cell'];

    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye', ['class' => 'btn btn-info']);
        $this->initDefaultButton('update', 'edit', ['class' => 'btn btn-primary ml-1']);
        $this->initDefaultButton('delete', 'trash-alt', [
            'class' => 'btn btn-danger ml-1',
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
        ]);
    }

    /**
     * Initializes the default button rendering callback for single button.
     * @param string $name Button name as it's written in template
     * @param string $iconName The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions Array of additional options
     * @since 2.0.11
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                /** @var ActiveRecord $model */
                switch ($name) {
                    case 'view':
                        if (method_exists($model, 'allowsView') && !$model->allowsView())return $this->initForbiddenButton($iconName);
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        if (method_exists($model, 'allowsUpdate') &&  !$model->allowsUpdate())return $this->initForbiddenButton($iconName);
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        if (method_exists($model, 'allowsDelete') &&  !$model->allowsDelete())return $this->initForbiddenButton($iconName);
                        if (method_exists($model, 'getDeleteConfirmationMessage') && isset($additionalOptions['data-confirm'])) {
                            $additionalOptions['data-confirm'] = $model->getDeleteConfirmationMessage();
                        }
                        $title = Yii::t('yii', 'Delete');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "far fa-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }

    protected function _renderDataCellContent($model, $key, $index)
    {
        return '<div class="action-buttons">' . parent::renderDataCellContent($model, $key, $index) . '</div>';
    }

    protected function initForbiddenButton($iconName)
    {
        return Html::a(Html::tag('span', '', ['class' => "far fa-$iconName"]), null, [
            'title' => Yii::t('app', 'Недостаточно прав для выполнения действия'),
            'aria-label'  => Yii::t('app', 'Недостаточно прав для выполнения действия'),
            'class' => 'btn btn-secondary',
            'disabled' => 'disabled'
        ]);
    }
}