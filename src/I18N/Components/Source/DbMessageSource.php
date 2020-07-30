<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\I18N\Components\Source;


class DbMessageSource extends \yii\i18n\DbMessageSource
{
    public $sourceMessageTable = '{{%i18n_message_source}}';
    public $messageTable = '{{%i18n_message}}';
}