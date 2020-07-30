<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application\Web;
use dianakaal\DatePickerMaskedWidget\DatePickerMaskedWidget;
use dosamigos\selectize\SelectizeDropDownList;
use himiklab\yii2\recaptcha\ReCaptcha2;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use trntv\aceeditor\AceEditor;
use XCrm\Application\ApplicationAwareTrait;
use XCrm\Form\ActiveForm;
use XCrm\Grid\GridView;
use XCrm\I18N\I18NTrait;
use XCrm\Media\CutterWidget;
use XCrm\Resource\Icons\Icon;
use XCrm\Widget\ListView4;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use Yii;

/**
 * Class View
 *
 * @property Theme $theme
 * @property-read Html $html
 *
 * @package XCrm\Application\Web
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class View extends \yii\web\View
{
    use ApplicationAwareTrait;
    use I18NTrait;

    public $heading;
    protected $_widgets;
    protected $_widgetsCustom = [];

    public function t($message, $params = [])
    {
        if (method_exists(get_class($this->context), 't')) {
            return $this->context::t($message, $params);
        }
        return Yii::t('xcrm/' . $this->app->id . '/views', $message, $params);
    }

    /**
     * @var array|Icon
     */
    protected $_icons = [
        'class' => Icon::class,
    ];

    public function beforeRender($viewFile, $params)
    {
        if ($this->theme) {
            $this->theme->registerAssetBundles($this);

        }
        if (isset($this->params['breadcrumbs'])) {
            $cn = count($this->params['breadcrumbs']) - 1;
            if (isset($this->params['breadcrumbs'][$cn]['url'])) {
                unset($this->params['breadcrumbs'][$cn]['url']);
            }
        }
        return parent::beforeRender($viewFile, $params);
    }

    public function getDefaultIconStyle()
    {
        return 'white';
    }

    public function icon($category, $id, $style = null)
    {
        if (is_array($this->_icons)) $this->_icons = Yii::createObject($this->_icons);
        return $this->_icons->getIcon($category, $id, $style ?? $this->getDefaultIconStyle());
    }

    /**
     * @return string|Html
     */
    public function getHtml()
    {
        $defaultHtmlHelper = Html::class;
        if ($this->theme) {
            return $this->theme->getHtml();
        }
        return $defaultHtmlHelper;
    }

    public function getCoreWidgets()
    {
        return [
            'breadcrumbs' => Breadcrumbs::class,
            'list4' => ListView4::class,
            'form' => ActiveForm::class,
            'grid' => GridView::class,
            'cutter' => CutterWidget::class,
            'lookup' => Select2::class,
            'editor' => CKEditor::class,
            'datepicker' => DatePicker::class,
            'datepickerMask' => DatePickerMaskedWidget::class,
            'selectize' => SelectizeDropDownList::class,
            'reCaptcha' => ReCaptcha2::class,
            'ace' => AceEditor::class
        ];
    }

    /**
     * Объединенный масив соответствия псевдонимов виджетов их классам на уровнях представления и темы
     * @return array
     */
    public function getWidgets()
    {
        return $this->_widgets;
    }

    /**
     * Вызывает метод widget() виджета
     * @param string $id имя класса или псевдоним виджета
     * @param array $config массив конфигурации, передается в метод виджета как акрумент
     * @return mixed
     * @throws NotSupportedException
     */
    public function widget($id, $config = [])
    {
        return $this->runWidgetStaticMethod($id, 'widget', $config);
    }

    /**
     * Вызывает метод begin() виджета
     * @param string $id имя класса или псевдоним виджета
     * @param array $config массив конфигурации, передается в метод виджета как акрумент
     * @return mixed
     * @throws NotSupportedException
     */
    public function begin($id, $config = [])
    {
        return $this->runWidgetStaticMethod($id, 'begin', $config);
    }

    /**
     * Вызывает метод end() виджета
     * @param string $id имя класса или псевдоним виджета
     * @param array $config массив конфигурации, передается в метод виджета как акрумент
     * @return mixed
     * @throws NotSupportedException
     */
    public function end($id, $config = null)
    {
        return $this->runWidgetStaticMethod($id, 'end', $config);
    }

    /**
     * Выполняет статичный метод виджета
     * @param string $id имя класса или псевдоним виджета
     * @param string $methodName имя статичного метода
     * @param array $config массив конфигурации, передается в метод виджета как акрумент
     * @return mixed
     * @throws NotSupportedException если остутствует класс виджета или его метод
     */
    protected function runWidgetStaticMethod($id, $methodName, $config = [])
    {
        $id = $this->getWidgets()[$id] ?? $id;
        if (class_exists($id) && method_exists($id, $methodName)) {
            return $id::$methodName($config);
        }
        throw new NotSupportedException('Widget ' . $id . ' is not supported');
    }

    /**
     * Синоним вызова begin() для формы
     * @param array $config
     * @return mixed
     * @throws NotSupportedException
     */
    public function beginForm($config = [])
    {
        return $this->begin('form', $config);
    }

    /**
     * Синоним вызова end() для формы
     * @return mixed
     * @throws NotSupportedException
     */
    public function endForm()
    {
        return $this->end('form');
    }

    /**
     * Синоним вызова begin() для PJax
     * @param array $config
     * @return mixed
     * @throws NotSupportedException
     */
    public function beginPjax($config = [])
    {
        return $this->begin('pjax', $config);
    }

    /**
     * Синоним вызова end() для PJax
     * @return mixed
     * @throws NotSupportedException
     */
    public function endPjax()
    {
        return $this->end('pjax');
    }

    public function init()
    {
        parent::init();

        $this->_widgets = ArrayHelper::merge(
            $this->getCoreWidgets(),
            $this->theme ? $this->theme->getCoreWidgets() : [],
            $this->_widgetsCustom
        );
    }
}