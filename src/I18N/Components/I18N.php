<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\I18N\Components;
use XCrm\I18N\Components\Translations\AbstractTranslator;
use XCrm\I18N\Model\MessageAuto;
use XCrm\I18N\Model\SourceMessage;
use XCrm\I18N\Model\SourceMessageAuto;
use XCrm\Modules\I18N\Model\Ref\RefLanguages;
use yii\base\InvalidConfigException;
use Yii;
use yii\base\NotSupportedException;
use XCrm\I18N\Components\Source\DbMessageSource;

/**
 * Class I18N
 *
 * @property-read array $languages
 * @property-read array $contentLanguages
 * @property-read array $languagesList
 * @property-read array $contentLanguagesList
 *
 * @package XCrm\I18N\Components
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class I18N extends \yii\i18n\I18N
{
    /**
     * @var string имя таблицы БД для хранения исходных сообщений
     */
    public $sourceMessageTable = '{{%i18n_message_source}}';
    /**
     * @var string имя таблицы БД для хранения переведенных сообщений
     */
    public $messageTable = '{{%i18n_message}}';
    /**
     * @var callable хендлер события отстутствующей интернационализации
     */
    public $missingTranslationHandler = [
        I18NMissingTranslation::class, 'handle'
    ];
    /**
     * @var null|array конфигурация компонента машинного перевода
     */
    public $translator = null;

    /**
     * @var array массив кодов и имен языков интернационализации контента
     * @see getLanguages()
     */
    private $_contentLanguages = null;
    /**
     * @var array массив кодов и имен языков интернационализации интерфейсов
     * @see getInterfaceLanguages()
     */
    private $_interfaceLanguages = null;
    /**
     * @var AbstractTranslator
     */
    private $_translatorHelper = null;
    /**
     * @var RefLanguages[] полный массив кодов языков из соответствующего справочника,
     *    ключами массива являются ключевые поля для каждого яхыка интернационализации
     */
    private $_allLanguages = null;

    public function getLanguages()
    {
        return array_keys($this->getContentLanguagesList());
    }

    public function getLanguagesCount()
    {
        return count($this->getLanguages());
    }

    public function getHasMultipleLanguages()
    {
        return 1 < $this->getLanguagesCount();
    }

    public function getInterfaceLanguages()
    {
        return array_keys($this->getInterfaceLanguagesList());
    }

    /**
 * @return array
 */
    public function getInterfaceLanguagesList()
    {
        if (null === $this->_interfaceLanguages) {
            $this->_interfaceLanguages = ['ru' => 'Русский'];
            if ($this->_allLanguages) {
                foreach ($this->_allLanguages as $k => $v) if ($v->is_primary) {
                    $this->_interfaceLanguages[$v->key_name] = $v->name;
                }
            }
        }
        return $this->_interfaceLanguages;
    }

    /**
     * @return array
     */
    public function getContentLanguagesList()
    {
        if (null === $this->_contentLanguages) {
            $this->_contentLanguages = ['ru' => 'Русский'];
            if ($this->_allLanguages) {
                foreach ($this->_allLanguages as $k => $v) if ($v->is_secondary) {
                    $this->_contentLanguages[$v->key_name] = $v->name;
                }
            }
        }
        return $this->_contentLanguages;
    }


    /**
     * @return AbstractTranslator|object|null
     * @throws InvalidConfigException
     * @throws NotSupportedException
     */
    public function getTranslator()
    {
        if (null === $this->translator) {
            throw new NotSupportedException('Machine translation is not supported');
        }
        if ($this->translator && !$this->_translatorHelper) {
            $this->_translatorHelper = Yii::createObject($this->translator);
        }
        return $this->_translatorHelper;
    }

    public function isAutoTranslationSupported()
    {
        try {
            return boolval($this->getTranslator());
        } catch (\Exception $e) {
        }
        return false;
    }

    public function auto($language, $message)
    {
        if ($translator = $this->getTranslator()) {

            $cache = SourceMessageAuto::findOne(['message' => $message]);
            if ($translated = MessageAuto::findOne(['id' => $cache->id, 'language' => $language])) {
                return $translated->translation;
            }

            if ($translatedMessage = $translator->translate($message, $language)) {
                if (!$cache) {
                    $cache = new SourceMessageAuto(['message' => $message]);
                    if ($cache->save()) {
                        $translated = new MessageAuto([
                            'id' => $cache->id,
                            'language' => $language,
                            'translation' => $translatedMessage
                        ]);
                        $translated->save();
                    }
                    return $translated->translation;
                }
            }
        }
        return null;
    }

    public function init()
    {

        try {
            $this->_allLanguages = RefLanguages::find()->indexBy('key_name')->all();
        } catch (\Exception $e) {
            $this->_allLanguages = ['en' => ['name' => 'English']];
        }

        if (!$this->_allLanguages) {
            $this->_allLanguages = ['en' => ['name' => 'English']];
        }
        foreach (['xcrm*', 'site*', 'app*'] as $prefix) {
            if (!isset($this->translations[$prefix])) $this->translations[$prefix] = [
                'class' => DbMessageSource::class,
                'db' => \Yii::$app->db,
                'sourceLanguage' => 'default',
                'sourceMessageTable' => $this->sourceMessageTable,
                'messageTable' => $this->messageTable,
                'on missingTranslation' => $this->missingTranslationHandler
            ];
        }

        parent::init();
    }
}