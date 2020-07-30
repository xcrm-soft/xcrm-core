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
use Da\User\Query\TokenQuery;
use Da\User\Traits\ContainerAwareTrait;
use XCrm\Base\Service;
use XCrm\Helper\ArrayHelper;
use XCrm\Modules\User\Model\User;
use XCrm\Modules\User\Module;

/**
 * Class AbstractUserService
 *
 * @property-read null|bool $mailStatus
 * @property-read Module $module
 *
 * @package XCrm\Modules\User\Service
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
abstract class AbstractUserService extends Service
{
    use ContainerAwareTrait;

    protected $_mailStatus = self::STATUS_NONE;
    protected $_form;

    public function getForm()
    {
        return $this->_form;
    }

    public function getModule()
    {
        return $this->app->getModule('user');
    }

    public function getMailStatus()
    {
        return $this->_mailStatus;
    }

    public function run()
    {
        return [
            'serviceStatus' => $this->serviceStatus,
            'mailStatus' => $this->mailStatus
        ];
    }

    /**
     * @return TokenQuery
     */
    public function createTokenQuery()
    {
        return new TokenQuery($this->module->classMap['Token']);
    }

    /**
     * @param $template
     * @param User $user
     * @param Token|null $token
     * @param array $params
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    protected function mail($template, User $user, Token $token = null, $params = [])
    {
        $this->_mailStatus = $this->app->email->compose($template, ArrayHelper::merge([
            'user'    => $user,
            'profile' => $user->getProfile()->one(),
            'token'   => $token,
            'module'  => $this->getModule(),
            'form'    => $this->getForm()
        ], $params))->send($user->email);

        return $this->_mailStatus;
    }


}