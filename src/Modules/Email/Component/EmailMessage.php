<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Email\Component;
use XCrm\Application\Base\Component;

/**
 * Сообщение для отправки по электронной почте
 *
 * @package XCrm\Modules\Email\Component
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class EmailMessage extends Component
{
    public $to;
    public $subject;
    public $fromAddress;
    public $from;
    public $replyToAddress;
    public $replyTo;
    public $messageText;
    public $messageHtml;
    public $params;
    public $language = null;
    public $underscoreText = null;
    public $underscoreHtml = null;

    public function send($to = null)
    {
        $message = $this->app->mailer->compose()
            ->setFrom([$this->fromAddress => $this->from])
            ->setReplyTo([$this->replyToAddress => $this->replyTo])
            ->setSubject($this->subject)
            ->setTextBody($this->messageText)
            ->setHtmlBody($this->messageHtml);

        $message->setTo($to ?? $this->to);

        return $message->send();
    }

    public function init()
    {
        parent::init();
        if (!$this->language) {
            $this->language = $this->app->user->getContentLanguage() ?? $this->app->defaultLanguage;
        }
    }
}