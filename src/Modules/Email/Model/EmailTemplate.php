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
use XCrm\Modules\Smarty\Model\SmartyTemplate;
use XCrm\Modules\Smarty\Model\SmartyTemplateI18N;

/**
 * Хранилище шаблонов системных сообщений электронной почты
 *
 * @property int $id
 * @property string $name_system
 * @property string $heading
 * @property string $key_name
 * @property int $html_id
 * @property int $text_id
 * @property int $sender_id
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @package XCrm\Modules\Email\Model
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class EmailTemplate extends ActiveRecordConfigurable
{
    /**
     * @var SmartyTemplate|null
     * @see getHtmlTemplate()
     * @see setHtmlTemplate()
     */
    private $_htmlTemplate = null;
    /**
     * @var SmartyTemplate|null
     * @see getTextTemplate()
     * @see setTextTemplate()
     */
    private $_textTemplate = null;

    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return '{{%email_template}}';
    }

    /**
     * {@inheritDoc}
     */
    public static function hierarchy()
    {
        return [
            'i18n' => EmailTemplateI18N::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription($skipAttributes = null)
    {
        return parent::getDescription($skipAttributes ?? [
           'html_id', 'text_id', 'sender_id'
        ]);
    }


    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['htmlTemplate', 'textTemplate'], 'string']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'heading' => static::t('Тема сообщения'),
            'text_id' => static::t('Шаблон тела сообщения (текст)'),
            'html_id' => static::t('Шаблон тела сообщения (html)'),
            'sender_id' => static::t('Адрес отправителя'),
        ]);
    }

    public function beforeValidate()
    {
        if (!$this->isNewRecord) {
            if ($this->_htmlTemplate && !$this->_htmlTemplate->validate()) {
                if ($e = $this->_htmlTemplate->getErrors('source_code'))  {
                    foreach ($e as $error) $this->addError('htmlTemplate', $error);
                }
            }
            if ($this->_textTemplate && !$this->_textTemplate->validate()) {
                if ($e = $this->_textTemplate->getErrors('source_code'))  {
                    foreach ($e as $error) $this->addError('textTemplate', $error);
                }
            }
        }
        return parent::beforeValidate();
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $transaction = static::getDb()->beginTransaction();
        if (parent::save($runValidation, $attributeNames)) {
            $success = $this->_htmlTemplate ? $this->_htmlTemplate->save() : true;
            if ($success && $this->_textTemplate) $success = $this->_textTemplate->save();
            if ($success) {
                $transaction->commit();
                return true;
            }
        }
        $transaction->rollBack();
        return false;
    }

    public function getAttributeLabel($attribute)
    {
        switch ($attribute) {
            case 'htmlTemplate': return parent::getAttributeLabel('html_id');
            case 'textTemplate': return parent::getAttributeLabel('text_id');
        }
        return parent::getAttributeLabel($attribute);
    }

    public function hasHtmlTemplate()
    {
        return boolval($this->_htmlTemplate);
    }

    public function getHtmlTemplate()
    {
        return $this->_htmlTemplate
            ? $this->_htmlTemplate->source_code
            : null;
    }

    public function setHtmlTemplate($value)
    {
        if ($this->_htmlTemplate) $this->_htmlTemplate->source_code = $value;
    }

    public function hasTextTemplate()
    {
        return boolval($this->_textTemplate);
    }

    public function getTextTemplate()
    {
        return $this->_textTemplate
            ? $this->_textTemplate->source_code
            : null;
    }

    public function setTextTemplate($value)
    {
        if ($this->_textTemplate) $this->_textTemplate->source_code = $value;
    }

    /**
     * @param bool $localize
     * @return SmartyTemplate|SmartyTemplateI18N|null
     */
    public function getHtml($localize = true)
    {
        if ($template = SmartyTemplate::findOne(['id' => $this->html_id])) {
            return $localize ? $template->getLocalizationModel() : $template;
        }
        return null;
    }

    public function getHtmlTemplateName()
    {
        return $this->_htmlTemplate
            ? $this->_htmlTemplate->fullName
            : null;
    }

    public function getTextTemplateName()
    {
        return $this->_textTemplate
            ? $this->_textTemplate->fullName
            : null;
    }

    /**
     * @param bool $localize
     * @return SmartyTemplate|SmartyTemplateI18N|null
     */
    public function getText($localize = true)
    {
        if ($template = SmartyTemplate::findOne(['id' => $this->text_id])) {
            return $localize ? $template->getLocalizationModel() : $template;
        }
        return null;
    }

    /**
     * @param bool $localize
     * @return \XCrm\Data\Localization|EmailAddress|null
     */
    public function getSender($localize = true)
    {
        $sender = EmailAddress::findOne(['id' => $this->sender_id]);
        return $localize ? $sender->localize($localize) : $sender;
    }

    public function afterFind()
    {
        parent::afterFind();
        if (!$this->isNewRecord) {
            if ($this->html_id) $this->_htmlTemplate = $this->getHtml(false);
            if ($this->text_id) $this->_textTemplate = $this->getText(false);
        }
    }
}