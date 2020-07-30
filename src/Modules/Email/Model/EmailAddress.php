<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Email\Model;
use XCrm\Data\ActiveRecordConfigurable;
use XCrm\Helper\ArrayHelper;

/**
 * Class EmailAddress
 *
 * @property int $id
 * @property string $name_system
 * @property string $email
 * @property string $email_name
 * @property string $email_reply
 * @property string $email_reply_name
 * @property string $content_short
 * @property string $content_full
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @package XCrm\Modules\Email\Model
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class EmailAddress extends ActiveRecordConfigurable
{
    public static function i18nCategory()
    {
        return 'xcrm/modules/email';
    }

    public static function tableName()
    {
        return '{{%email_address}}';
    }

    public static function hierarchy()
    {
        return [
            'i18n' => EmailAddressI18N::class
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'content_short' => static::t('Подпись для текстовой версии'),
            'content_full' => static::t('Подпись для HTML версии'),
        ]);
    }
}