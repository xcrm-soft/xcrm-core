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
use Da\User\Model\Profile;
use XCrm\Modules\User\Frontend\Model\RegistrationForm;
use XCrm\Modules\User\Model\User;
use XCrm\Modules\User\Module;
use yii\base\InvalidConfigException;
use yii\db\Exception;

/**
 * Сервис регистрации учетной записи пользователя
 *
 * @property-read Module $module
 * @property-read RegistrationForm $form
 *
 * @package XCrm\Modules\User\Service
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class RegistrationService extends AbstractUserService
{
    /**
     * @var User $user
     */
    private $_user;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @return array
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function run()
    {
        if ($this->_form->load($this->app->request->post())) {
            $this->_user = $this->_createUser();
            $transaction = $this->_user::getDb()->beginTransaction();
            $this->_user->setScenario('register');
            $this->_user->setAttributes(array_intersect_key($this->_form->attributes, $this->_user->attributes));
            $this->_user->password = $this->_form->password;
            if ($this->_user->save()) {
                $profile = $this->_user->getProfile()->one();
                if (null === $profile) $profile = $this->make(Profile::class, [], ['user_id' => $this->_user->id]);
                $profile->setAttributes(array_intersect_key($this->_form->attributes, $profile->attributes));
                if ($profile->save()) {
                    if ($this->module->enableEmailConfirmation) {
                        $token = TokenFactory::makeConfirmationToken($this->_user->id);
                    } else {
                        $token = null;
                        $this->_user->confirmed_at = time();
                        $this->_user->save();
                    }
                    $transaction->commit();
                    $this->_serviceStatus = self::STATUS_SUCCESS;
                    $this->mail('user.welcome', $this->_user, $token);
                } else {
                    // @todo: Произошла ошибка при регистрации учетной записи
                }
            }
            $transaction->rollBack();

        }
        return parent::run();
    }

    /**
     * @return User|object
     * @throws InvalidConfigException
     */
    private function _createUser()
    {
        return $this->make('Da\User\Model\User');
    }

    /**
     * RegistrationService constructor.
     * @param array $config
     * @throws InvalidConfigException
     */
    public function __construct($config = [])
    {
        $this->_form = $this->make($this->module->classMap['RegistrationForm']);
        $this->make('Da\User\Validator\AjaxRequestModelValidator', [$this->_form])->validate();
        parent::__construct($config);
    }
}