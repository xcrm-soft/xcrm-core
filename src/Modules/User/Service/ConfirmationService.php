<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\Service;
use XCrm\Modules\User\Model\User;
use yii\db\StaleObjectException;
use Da\User\Model\Token;

/**
 * Class ConfirmationService
 *
 * @property-read User $user
 *
 * @package XCrm\Modules\User\Service
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class ConfirmationService extends AbstractUserService
{
    /**
     * @var Token
     */
    private $_token;
    /**
     * @var User
     * @see getUser()
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
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function run()
    {
        if ($this->_token instanceof Token && !$this->_token->getIsExpired()) {
           if ($this->_user = $this->_token->getUser()->one()) {
               $this->_token->delete();
               $this->_user->updateAttributes(['confirmed_at' => time()]);
               $this->_serviceStatus = self::STATUS_SUCCESS;
           }
        }
        return parent::run();
    }

    public function __construct($id, $code, $config = [])
    {
        $this->_token = $this->createTokenQuery()
            ->whereUserId($id)
            ->whereCode($code)
            ->whereIsConfirmationType()
            ->one();
        parent::__construct($config);
    }
}