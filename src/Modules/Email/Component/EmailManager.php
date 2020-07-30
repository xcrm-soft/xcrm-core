<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Email\Component;
use XCrm\Modules\Email\Model\EmailAddress;
use yii\base\InvalidArgumentException;
use XCrm\Application\Base\Component;
use XCrm\Modules\Email\Model\EmailTemplate;
use Yii;
use yii\base\InvalidConfigException;

class EmailManager extends Component
{
    private $_defaultSenderId = null;

    public function register($keyName, $subject, $html, $text = null)
    {
        $html = $this->app->smarty->getTemplate($html);
        if ($text) $text = $this->app->smarty->getTemplate($text);

        if (!$html) {
            throw new InvalidArgumentException('Html template is required');
        }

        $message = new EmailTemplate([
            'name_system' => $subject,
            'heading' => $subject,
            'key_name' => $keyName,
            'html_id' => $html->id,
            'text_id' => $text ? $text->id : null,
            'sender_id' => $this->_defaultSenderId
        ]);

        if (!$message->save()) {
            throw new InvalidArgumentException('Unable to register email message');
        }
    }

    public function compose($templateName, $params = [], $language = null)
    {
        if (null === $language) $language = $this->app->user->getContentLanguage() ?? $this->app->language;

        if ($masterTemplate = EmailTemplate::findOne(['key_name' => $templateName])) {
            $htmlBody = $masterTemplate->getHtmlTemplateName();
            $textBody = $masterTemplate->getTextTemplateName();
            $masterTemplate->localize($language);

            $sender = $masterTemplate->getSender($language);

            return new EmailMessageSmarty([
                'subject' => $masterTemplate->heading,
                'from' => $sender->email_name,
                'fromAddress' => $sender->email,
                'replyTo' => $sender->email_reply_name,
                'replyToAddress' => $sender->email_reply,
                'htmlTemplate' => $htmlBody,
                'textTemplate' => $textBody,
                'params' => $params,
                'underscoreText' => $sender->content_short,
                'underscoreHtml' => $sender->content_full,
            ]);

        } else {
            throw new InvalidArgumentException('Email template ' . $templateName . ' not found');
        }
    }

    public function init()
    {
        parent::init();
        if ($defaultSender = EmailAddress::find()->orderBy(['id' => SORT_ASC])->limit(1)->one()) {
            $this->_defaultSenderId = $defaultSender->id;
        } else {
            throw new InvalidConfigException('Default Sender is not set');
        }
    }
}