<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data;
use XCrm\Application\ApplicationAwareTrait;
use XCrm\Data\Traits\ModelPermissionsTrait;
use XCrm\I18N\I18NTrait;
use Yii;


trait ModelTrait
{
    use ApplicationAwareTrait;
    use I18NTrait;
    use ModelPermissionsTrait;

    /**
     * Возвращает массив заголовков и подписей элементов управления для различных действий над моделью
     * @return array
     */
    public static function actionLabels()
    {
        return [];
    }

    /**
     * Возвращает текстовую метку для заданного элемента управления заданного действия над моделью
     * @param string $action идентификатор действия
     * @param string $area идентификатор элемента управления
     * @param string|null $defaultValue значение подписи по умолчанию
     *     если значение по умолчнию не задано явно и при этом подпись заданного элемента управления не задана
     *     методом actionLabels() значение генерируется из идентификатора действия и идентификатора элемента
     *     управления, разделенных пробелами
     * @param string|bool $translateDefaultValue опции интернационализации значения подписи по умолчанию
     *     если передан false - перевод производиться не будет
     *     если передан true - подпись по умолчанию будет переведена в пространстве имен модели
     *     при передачи любой строки ее значение расценивается как пространство имен для интернационализации
     *     значения подписи элемента управления по умолчанию
     * @return mixed|string|null
     */
    public static function getActionLabel($action, $area, $defaultValue = null, $translateDefaultValue = false)
    {
        if (isset(static::actionLabels()[$action][$area])) {
            return static::actionLabels()[$action][$area];
        }
        if (true === $translateDefaultValue) {
            $defaultValue = static::t($defaultValue);
        } elseif (is_string($translateDefaultValue)) {
            $defaultValue = Yii::t($translateDefaultValue, $defaultValue);
        }
        return $defaultValue;
    }

    /**
     * Конфигуратор иерархии моделей, связанных с данной.
     * @return array
     */
    public static function hierarchy()
    {
        return [];
    }

    public static function hasLocalizations()
    {
        return Yii::$app->i18n->getHasMultipleLanguages()
            ? isset(static::hierarchy()['i18n'])
            : false;
    }

    public function getCanBeTranslated()
    {
        return static::hasLocalizations();
    }

    /**
     * Возвращает модель локализации атрибутов для заданной модели.
     * Если модель локализации контента не задана в иерархии, будет возвращен null
     * @param string|null $language
     * @return ActiveRecordConfigurable
     */
    public function getLocalizationModel($language = null, $autofill = false)
    {
        $model = null;
        if (null === $language) $language = $this->app->user->getContentLanguage();

        if ($this->getCanBeTranslated()) {
            $localizationClassName = static::hierarchy()['i18n'];
            $searchCondition = [
                'master_id' => $this->primaryKey,
                'language' => $language
            ];
            $model = $localizationClassName::findOne($searchCondition);
            if (!$model) $model = new $localizationClassName([
                'master_id' => $this->primaryKey,
                'language' => $language,
            ]);

            if ($autofill && $model->isNewRecord) {
                $cols = static::getDescription()->attributes;
                foreach ($cols as $column) {
                    $attribute = $this->app->attributeManager->get($column);
                    if ($attribute->i18n) {
                        $model->$column = $this->app->i18n->auto($language, $this->$column);
                    }
                }
            }

        }

        return $model;
    }

    public function localize($language = null)
    {
        if (true === $language) $language = null;
        return new Localization($this, $language);
    }

    /**
     * Возвращает true, если пользователю разрешено редактировать заданный атрибут модели
     * В общем случае пользователю доступно редактирование всех атрибутов модели
     * @param string $name имя атрибута, в отношении которого выполняется проверка
     * @return mixed
     */
    public function canModify($name)
    {
        return $this->hasAttributeName($name);
    }

    /**
     * Возврашает true, если пользователю разрешено редактировать хотя бы один атрибут модели из переданных
     * @param array $names массив имен атрибутов, для которых выполняется проверка
     * @return bool
     */
    public function canModifyOneOf(array $names)
    {
        foreach ($names as $name) {
            if ($this->canModify($name)) return true;
        }
        return false;
    }


}