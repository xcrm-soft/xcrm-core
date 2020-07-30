<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\Frontend\Model;


use XCrm\I18N\I18NTrait;

class RecoveryForm extends \Da\User\Form\RecoveryForm
{
    use I18NTrait;

    public $password_repeat;

    public static function i18nCategory()
    {
        return 'xcrm/user/attributes';
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_REQUEST => ['email'],
            self::SCENARIO_RESET => ['password', 'password_repeat'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            'emailTrim' => ['email', 'filter', 'filter' => 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
            'passwordRequired' => ['password', 'required'],
            'passwordRepeatRequired' => ['password_repeat', 'required'],
            'passwordLength' => ['password', 'string', 'max' => 72, 'min' => 6],
            'passwordCompare' => ['password', 'compare'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => static::t('Подтверждение пароля'),
            'password_repeat' => static::t('Пароль'),
        ];
    }
}