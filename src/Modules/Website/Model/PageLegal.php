<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Website\Model;
use XCrm\Data\ActiveRecordConfigurable;

class PageLegal extends ActiveRecordConfigurable
{
    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return '{{%website_legal}}';
    }

    /**
     * {@inheritDoc}
     */
    public static function allowsCreate()
    {
        return \Yii::$app->user->can('website/page-structure');
    }

    /**
     * {@inheritDoc}
     */
    public static function allowsUpdate()
    {
        return \Yii::$app->user->can('website/page-content');
    }

    /**
     * {@inheritDoc}
     */
    public static function allowsDelete()
    {
        return \Yii::$app->user->can('website/page-structure');
    }

    /**
     * {@inheritDoc}
     */
    public static function hierarchy()
    {
        return [
            'i18n' => PageLegalI18N::class
        ];
    }
}