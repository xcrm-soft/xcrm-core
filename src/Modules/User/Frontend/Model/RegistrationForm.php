<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\Frontend\Model;
use Da\User\Model\Profile;
use Da\User\Model\User;
use himiklab\yii2\recaptcha\ReCaptchaValidator2;
use XCrm\I18N\I18NTrait;
use Yii;

class RegistrationForm extends \Da\User\Form\RegistrationForm
{
    use I18NTrait;

    public $username;
    public $password;
    public $password_repeat;
    public $email;
    public $birth_date;
    public $phone;
    public $name_last;
    public $name_first;
    public $name_middle;

    public $reCaptcha;

    public static function i18nCategory()
    {
        return 'xcrm/person/profile';
    }

    public function attributeLabels()
    {
        return [
            'username'        => static::t('Имя пользователя'),
            'password'        => static::t('Подтверждение пароля'),
            'password_repeat' => static::t('Пароль'),
            'email'           => static::t('Адрес электронной почты'),
            'birth_date'      => static::t('Дата рождения'),
            'phone'           => static::t('Телефон'),
            'name_last'       => static::t('Фамилия'),
            'name_first'      => static::t('Имя'),
            'name_middle'     => static::t('Отчество'),
            'gdpr_consent' => $this->module->getConsentMessage()
        ];
    }

    public function rules()
    {
        $user = $this->getClassMap()->get(User::class);
        $profile = $this->getClassMap()->get(Profile::class);

        $rules = [

            'usernameTrim' => ['username', 'filter', 'filter' => 'trim'],
            'emailTrim' => ['email', 'filter', 'filter' => 'trim'],

            [['username', 'password', 'password_repeat', 'email', 'phone', 'name_last', 'name_first', 'birth_date'], 'required'],
            [['password'], 'compare'],
            [['email'], 'email'],

            'usernameUnique' => [
                'username',
                'unique',
                'targetClass' => $user,
                'message' => Yii::t('usuario', 'This username has already been taken'),
            ],

            'emailUnique' => [
                'email',
                'unique',
                'targetClass' => $user,
                'message' => Yii::t('usuario', 'This email address has already been taken'),
            ],

            'phoneUnique' => [
                'phone',
                'unique',
                'targetClass' => $profile,
                'message' => Yii::t('usuario', 'This phone number has already been taken'),
            ],
        ];

        if ($this->module->enableReCaptchaRegistration) {
            $rules['reCaptcha'] = ['reCaptcha', ReCaptchaValidator2::class, 'when' => $this->module->enableReCaptchaRegistration];
        }

        return $rules;
    }

    public function attributeHints()
    {
        return [];
    }
}