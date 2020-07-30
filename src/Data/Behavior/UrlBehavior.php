<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Behavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use XCrm\Data\Helper\StringHelper;

class UrlBehavior extends AttributeBehavior
{
    public $urlAttribute = 'url';
    public $nameAttribute = 'name';
    public $value = null;

    public function getValue($event)
    {
        $valueAttribute = $this->urlAttribute;
        if (!$this->owner->$valueAttribute) {
            $sourceAttribute = $this->nameAttribute;
            if ($sourceValue = $this->owner->$sourceAttribute) {
                return StringHelper::translit($sourceValue);
            }
        }
        return $this->owner->$valueAttribute;
    }

    public function init()
    {
        parent::init();
        if (empty($this->attributes)) {
            $this->attributes = [
                ActiveRecord::EVENT_BEFORE_INSERT => [$this->urlAttribute],
                ActiveRecord::EVENT_BEFORE_UPDATE => [$this->urlAttribute],
            ];
        }
    }
}