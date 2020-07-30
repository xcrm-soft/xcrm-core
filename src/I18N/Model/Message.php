<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\I18N\Model;
use XCrm\I18N\I18NTrait;
use XCrm\I18N\Components\I18N;
use yii\db\ActiveRecord;
use yii\base\InvalidConfigException;

/**
 * Переведенные сообщения интернационализации
 *
 * @package XCrm\I18N\Model
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class Message extends ActiveRecord
{
    use I18NTrait;

    public static function i18nCategory()
    {
        return 'xcrm/i18n/defaults';
    }

    /**
     * @return string
     * @throws InvalidConfigException
     */
    public static function tableName()
    {
        /** @var I18N $i18n */
        $i18n = \Yii::$app->i18n;
        if (!isset($i18n->messageTable)) {
            throw new InvalidConfigException('You should configure i18n component');
        }
        return $i18n->messageTable;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['language', 'required'],
            ['language', 'string', 'max' => 16],
            ['translation', 'string']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language' => static::t('Локализация'),
            'translation' => static::t('Перевод')
        ];
    }
    public function getSourceMessage()
    {
        return $this->hasOne(SourceMessage::class, ['id' => 'id']);
    }
}