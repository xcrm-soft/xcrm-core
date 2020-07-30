<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Reference\Model;
use XCrm\Data\ActiveRecordConfigurable;
use XCrm\Helper\StringHelper;
use XCrm\Modules\Reference\BackOffice\Controller\ValuesController;

/**
 * Class ReferenceBook
 *
 * @property-read string $keyName
 *
 * @package XCrm\Modules\Reference\Model
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
abstract class ReferenceBook extends ActiveRecordConfigurable
{
    public static function getTitle()
    {
        return StringHelper::decamelize(basename(static::class));
    }

    public static function isRegistrationAllowed()
    {
        return false;
    }

    public static function backendControllerClass()
    {
        return ValuesController::class;
    }

    public function getKeyName()
    {
        return $this->key_name;
    }

    /**
     * @return ReferenceRegistry|null
     */
    public function getBookInfo()
    {
        return ReferenceRegistry::findOne(['class_name' => get_class($this)]);
    }

    public function canModify($name)
    {
        if (in_array($name, ['uuid'])) return false;
        if (in_array($name, ['ky_name'])) return $this->isNewRecord;
        return parent::canModify($name);
    }
}