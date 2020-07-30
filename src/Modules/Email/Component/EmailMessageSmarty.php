<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Email\Component;

/**
 * Расширение функционала сообщения электронной почты редактируемыми шаблонами
 *
 * @package XCrm\Modules\Email\Component
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class EmailMessageSmarty extends EmailMessage
{
    public $htmlTemplate = null;
    public $textTemplate = null;

    public function init()
    {
        parent::init();
        if ($this->htmlTemplate) {
            $this->messageHtml = $this->app->smarty->fetch('xcrm:' . $this->htmlTemplate, $this->params)
                . $this->underscoreHtml;
        }
        if ($this->textTemplate) {
            $this->messageText = $this->app->smarty->fetch('xcrm:' . $this->textTemplate, $this->params)
                . $this->underscoreText;
        }
    }
}