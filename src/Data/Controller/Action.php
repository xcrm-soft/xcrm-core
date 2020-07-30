<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Controller;

use XCrm\Application\ApplicationAwareTrait;
use XCrm\Data\ActiveRecord;
use XCrm\I18N\I18NTrait;
use yii\base\InvalidConfigException;

/**
 * Базовая реализация действия CRUD контроллера
 *
 * @property-read CrudController $controller
 *
 * @package XCrm\Data\Controller
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
abstract class Action extends \XCrm\Application\Base\Action
{
    use ApplicationAwareTrait;
    use I18NTrait;

    public $defaultTitle = null;

    public $toolbar;
    /**
     * @var string|ActiveRecord имя класса основной модели CRUD коетроллера,
     *     которому принадлежит данное действие
     */
    protected $modelClass;

    public $innerView = null;

    /**
     * Добавляет путь в хлебные крошки
     */
    public function createCrumb()
    {
        $defaultTitle = $this->id;
        if ($this->defaultTitle) $defaultTitle = static::t($this->defaultTitle);
        $this->controller->crumb($this->modelClass::actionLabels()[$this->id]['title'] ?? $defaultTitle);
    }

    public static function i18nCategory()
    {
        return 'xcrm/data/actions';
    }

    protected function performActions($returnBoolValue = false)
    {
        return null;
    }

    protected function getVariables()
    {
        return [];
    }

    /**
     * Формирует панель управления (кнопки и ссылки формы) для данного действия.
     * По умолчанию панель не содержит элементов управления.
     * @return array|null
     */
    protected function getDefaultToolbar()
    {
        return null;
    }


    public function run()
    {
        if ($r = $this->performActions()) return null;


        return $this->render(array_merge([
            'toolBar'   => $this->renderToolbar(),
            'tabs'      => $this->renderTabs(),
            'innerView' => $this->innerView,
        ], $this->getVariables()));
    }

    protected function renderTabs()
    {
        return null;
    }

    protected function renderToolbar()
    {
        $languageSelector = null;
        $toolBar = $this->resolveCallable($this->toolbar) ?? $this->getDefaultToolbar();

        if ( $this->modelClass::hasLocalizations() ) {
            $languageSelector = [
                'languages' => $this->app->i18n->getContentLanguagesList(),
                'current' => $this->app->user->getContentLanguage(),
            ];
            if (empty($languageSelector['languages']) || 1 == count($languageSelector['languages'])) $languageSelector = null;
        }

        if (is_array($toolBar)) foreach ($toolBar as $k=>$v) {
            if (isset($v['visible']) && !$v['visible']) unset($toolBar[$k]);
        }

        if (!empty($toolBar) || $languageSelector) {
            return [
                'buttons' => $toolBar,
                'languageSelector' => $languageSelector,
            ];
        }

        return null;
    }

    protected function renderLanguageSelector()
    {
        return null;
    }

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->modelClass = $this->modelClass ?? $this->controller->modelClass;
        if (!$this->modelClass) {
            throw new InvalidConfigException('Model class should be set');
        }
    }
}