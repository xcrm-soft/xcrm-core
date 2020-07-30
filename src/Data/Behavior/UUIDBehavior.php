<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Behavior;
use Ramsey\Uuid\Uuid;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use Exception;

class UUIDBehavior extends AttributeBehavior
{
    public $attribute = 'uuid';

    /**
     * {@inheritDoc}
     * @see beforeSave()
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeSave'
        ];
    }

    /**
     * @throws Exception
     */
    public function beforeSave()
    {
        $this->owner->{$this->attribute} = Uuid::uuid4()->toString();
    }
}