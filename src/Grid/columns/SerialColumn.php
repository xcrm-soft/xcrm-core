<?php
/**
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2019, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Grid\columns;


class SerialColumn extends \yii\grid\SerialColumn
{
    public $contentOptions = ['style' => 'width: 10px; white-space: nowrap; text-align: right;'];
}