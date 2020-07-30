<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\I18N\Model;
use yii\db\ActiveRecord;


class SourceMessageAuto extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%i18n_auto_source}}';
    }

    public function rules()
    {
        return [
            ['id', 'integer'],
            ['message', 'string'],
            ['message', 'required']
        ];
    }
}