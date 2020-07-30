<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\Service;
use Da\User\Model\Token;
use Da\User\Traits\ContainerAwareTrait;
use XCrm\Application\Base\Component;
use XCrm\Modules\User\Frontend\Model\RecoveryForm;

class RecoveryResetService extends AbstractUserService
{
    /**
     * @var Token
     */
    private $_token;

    public function run()
    {
        if ($this->_form->load($this->app->request->post()) && $this->_form->validate()) {
            $user = $this->_token->user;
            $user->password = $this->_form->password;
            if ($user->save()) {
                $this->_token->delete();
                $this->_serviceStatus = self::STATUS_SUCCESS;
            }
        }
        return parent::run();
    }

    public function __construct(Token $token, $config = [])
    {
        $this->_token = $token;
        $this->_form = $this->make($this->module->classMap['RecoveryForm'], [], ['scenario' => RecoveryForm::SCENARIO_RESET]);
        $this->make('Da\User\Validator\AjaxRequestModelValidator', [$this->_form])->validate();
        parent::__construct($config);
    }
}