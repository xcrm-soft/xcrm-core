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
use yii\db\ActiveRecord;
use yii\base\InvalidConfigException;
use XCrm\I18N\Components\I18N;
use Yii;

/**
 * Исходные сообщения для интернационализации интерфейсов
 *
 * @package XCrm\I18N\Model
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class SourceMessage extends ActiveRecord
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
        $i18n = Yii::$app->i18n;
        if (!isset($i18n->sourceMessageTable)) {
            throw new InvalidConfigException('You should configure i18n component');
        }
        return $i18n->sourceMessageTable;
    }

    /**
     * {@inheritDoc}
     */
    public static function find()
    {
        return new SourceMessageQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['message', 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => static::t('Категория'),
            'message' => static::t('Сообщение'),
            'status' => static::t('Статус перевода')
        ];
    }

    public function getMessages()
    {
        return $this->hasMany(Message::class, ['id' => 'id'])->indexBy('language');
    }

    /**
     * @return array|SourceMessage[]
     */
    public static function getCategories()
    {
        return SourceMessage::find()->select('category')->distinct('category')->asArray()->all();
    }

    public function initMessages()
    {
        $messages = [];
        foreach (Yii::$app->getI18n()->languages as $language) {
            if (!isset($this->messages[$language])) {
                $message = new Message;
                $message->language = $language;
                $messages[$language] = $message;
            } else {
                $messages[$language] = $this->messages[$language];
            }
        }
        $this->populateRelation('messages', $messages);
    }

    public function saveMessages()
    {
        /** @var Message $message */
        foreach ($this->messages as $message) {
            $this->link('messages', $message);
            if (!$message->save()) {
                print_r($message->errors);
                die;
            }
        }
    }

    public function isTranslated()
    {
        foreach ($this->messages as $message) {
            if (!$message->translation) {
                return false;
            }
        }
        return true;
    }
}