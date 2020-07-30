<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

class Smarty_Resource_Xcrm extends Smarty_Resource_Custom
{
    use \XCrm\Application\ApplicationAwareTrait;

    public function fetch($name, &$source, &$mtime)
    {
        list($category, $group, $keyName) = explode('/', $name);

        if ($template = Yii::$app->smarty->registry->getTemplate(substr($category, 5), $group, $keyName)) {
            $mtime = $template->updated_at;
            $source = $template->source_code;
        }
    }
}