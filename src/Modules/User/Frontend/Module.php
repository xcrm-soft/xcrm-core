<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\Frontend;
use XCrm\Application\ApplicationAwareTrait;
use XCrm\I18N\I18NTrait;
use XCrm\Modules\User\Frontend\Controller\DefaultController;
use XCrm\Helper\ArrayHelper;
use XCrm\Modules\User\Frontend\Controller\RecoveryController;
use XCrm\Modules\User\Frontend\Controller\RegistrationController;
use XCrm\Modules\User\Frontend\Controller\SecurityController;
use XCrm\Modules\User\Frontend\Model\ConfirmationResendForm;
use XCrm\Modules\User\Frontend\Model\RecoveryForm;
use XCrm\Modules\User\Frontend\Model\RegistrationForm;
use yii\helpers\Html;
use Yii;

class Module extends \XCrm\Modules\User\Module
{
    use ApplicationAwareTrait;
    use I18NTrait;

    public $enableGdprCompliance = true;
    public $gdprPrivacyPolicyUrl = '/docs/privacy-policy';
    public $enableReCaptchaRegistration = false;

    public static function i18nCategory()
    {
        return 'xcrm/person/profile';
    }

    public function beforeAction($action)
    {
        $this->app->view->params['breadcrumbs'][] = [
            'url' => ['/' . $this->id], 'label' => static::t('Личный кабинет')
        ];
        return parent::beforeAction($action);
    }

    public function __construct($id, $parent = null, $config = [])
    {
        parent::__construct($id, $parent, ArrayHelper::merge([
            'classMap' => [
                'RegistrationForm' => RegistrationForm::class,
                'RecoveryForm' => RecoveryForm::class,
                'ResendForm' => ConfirmationResendForm::class,
            ],
            'controllerMap' => [
                'default' => DefaultController::class,
                'security' => SecurityController::class,
                'registration' => RegistrationController::class,
                'recovery' => RecoveryController::class,
            ],
            'viewPath' => '@app/views/_mod-user',
            'administratorPermissionName' => 'global/account-administrator-access',
        ], $config));
    }

    /**
     * @return string with the hit to be used with the give consent checkbox
     */
    public function getConsentMessage()
    {
        $defaultConsentMessage = static::t(
            'Я соглашаюсь на обработку моих персональных данных и использование файлов cookie для облегчения работы этого сайта.<br/>Для получения дополнительной информации ознакомьтесь с нашей {privacyPolicy}',
            [
                'privacyPolicy' => $this->app->view->html::a(
                    static::t( 'политикой конфиденциальности'),
                    $this->gdprPrivacyPolicyUrl,
                    ['target' => '_blank']
                ),
            ]
        );

        return $this->gdprConsentMessage ?: $defaultConsentMessage;
    }
}