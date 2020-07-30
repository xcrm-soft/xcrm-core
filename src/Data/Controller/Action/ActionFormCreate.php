<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Controller\Action;


class ActionFormCreate extends ActionForm
{
    public $returnUrl = ['index'];

    public function beforeRun()
    {
        $this->_model = $this->controller->createModel();
        $this->createCrumb();
        return true;
    }
}