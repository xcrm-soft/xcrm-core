<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\Service;

use Da\User\Factory\TokenFactory;
use XCrm\Modules\User\Frontend\Model\ConfirmationResendForm;
use yii\base\InvalidConfigException;

/**
 * Class ConfirmationResendService
 *
 * @property-read ConfirmationResendForm $form
 *
 * @package XCrm\Modules\User\Service
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class ConfirmationResendService extends AbstractUserService
{
    /**
     * @return array
     * @throws InvalidConfigException
     */
    public function run()
    {
        if ($this->_form->load($this->app->request->post()) && $this->_form->validate()) {
            if ($user = $this->module->classMap['User']::findOne(['email' => $this->_form->email])) {
                $this->_serviceStatus = self::STATUS_SUCCESS;

                if ($token = TokenFactory::makeConfirmationToken($user->id)) {
                    $this->mail('user.confirmation', $user, $token);
                }
            }
        }
        return parent::run();
    }

    /**
     * ConfirmationResendService constructor.
     * @param  array $config
     * @throws InvalidConfigException
     */
    public function __construct($config = [])
    {
        $this->_form = $this->make($this->module->classMap['ResendForm']);
        $this->make('Da\User\Validator\AjaxRequestModelValidator', [$this->_form])->validate();
        parent::__construct($config);
    }
}