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
use Da\User\Traits\ContainerAwareTrait;
use XCrm\Application\Base\Component;
use XCrm\Modules\User\Frontend\Model\RecoveryForm;
use XCrm\Modules\User\Module;
use yii\base\InvalidConfigException;

/**
 * Class RecoveryRequestService
 *
 * @property-read Module $module
 * @property-read RecoveryForm $form
 *
 * @package XCrm\Modules\User\Service
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class RecoveryRequestService extends AbstractUserService
{
    use ContainerAwareTrait;

    /**
     * @return array
     * @throws InvalidConfigException
     */
    public function run()
    {
        if ($this->_form->load($this->app->request->post()) && $this->_form->validate()) {
            $this->_serviceStatus = self::STATUS_SUCCESS;
            if ($user = $this->module->classMap['User']::findOne(['email' => $this->_form->email])) {
                if ($token = TokenFactory::makeRecoveryToken($user->id)) {
                    $this->mail('user.recovery', $user, $token);
                }
            }
        }
        return parent::run();
    }

    /**
     * RecoveryRequestService constructor.
     * @param array $config
     * @throws InvalidConfigException
     */
    public function __construct($config = [])
    {
        $this->_form = $this->make($this->module->classMap['RecoveryForm'], [], ['scenario' => RecoveryForm::SCENARIO_REQUEST]);
        $this->make('Da\User\Validator\AjaxRequestModelValidator', [$this->_form])->validate();
        parent::__construct($config);
    }
}