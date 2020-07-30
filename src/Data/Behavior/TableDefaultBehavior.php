<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Behavior;
use XCrm\Data\ActiveRecordConfigurable;
use yii\base\Behavior;

/**
 * Class TableDefaultBehavior
 *
 * @property-read ActiveRecordConfigurable $owner
 *
 * @package XCrm\Data\Behavior
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class TableDefaultBehavior extends Behavior
{
    public function smartSave()
    {
        return $this->owner->save();
    }

    public function getValidParentsQuery()
    {
        return $this->owner->getFindAllQuery();
    }
}