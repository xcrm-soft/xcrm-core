<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data;


use XCrm\Helper\ArrayHelper;
use yii\base\BaseObject;

/**
 * Class Localization
 *
 * @property string $language
 * @property int $master_id
 *
 * @package XCrm\Data
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class Localization extends BaseObject
{
    private $_mainModel;
    private $_i18nModel;

    private $_attributes = [];

    public function __get($name)
    {
        $value = null;
        if ($this->_i18nModel && $this->_i18nModel->canGetProperty($name)) $value = $this->_i18nModel->$name;
        if (empty($value) && $this->_mainModel->canGetProperty($name)) {
            $value = $this->_mainModel->$name;
            if (is_object($value)) {

            }
        }
        return $value;
    }

    public function attributes()
    {
        return $this->_mainModel->attributes();
    }

    public function attributeLabels()
    {
        return $this->_mainModel->attributeLabels();
    }

    public function __construct(ActiveRecordConfigurable $mainModel, $language = null)
    {
        $this->_mainModel = $mainModel;
        /**
         * @todo связи, лейблы и тд
         */
        if ($this->_i18nModel = $mainModel->getLocalizationModel($language)) {

        } else {

        }
    }
}