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

class PageService extends ActiveRecordConfigurable
{
    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return '{{%website_service}}';
    }

    /**
     * {@inheritDoc}
     */
    public static function allowsCreate()
    {
        return false;
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
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public static function hierarchy()
    {
        return [
            'i18n' => PageServiceI18N::class
        ];
    }
}