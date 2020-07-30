<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\Frontend\Controller;
use XCrm\Application\ControllerTrait;
use XCrm\Frontend\PageView;
use XCrm\Frontend\SiteApplication;
use yii\base\InvalidConfigException;

/**
 * Class SecurityController
 *
 * @property-read SiteApplication $app
 * @property-read PageView $view
 *
 * @package XCrm\Modules\User\Frontend\Controller
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class SecurityController extends \Da\User\Controller\SecurityController
{
    use ControllerTrait;

    /**
     * Отображает форму аутентификации пользователя для воода логина и пароля,
     * обрабатывает полученные от пользователя данные
     *
     * @return mixed
     * @throws InvalidConfigException
     */
    public function actionLogin()
    {
        $this->view->service('user/security/login');
        return parent::actionLogin();
    }
}