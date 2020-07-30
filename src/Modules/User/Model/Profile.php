<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */
namespace XCrm\Modules\User\Model;
use Da\User\Validator\TimeZoneValidator;
use XCrm\Application\ApplicationAwareTrait;
use XCrm\Helper\ArrayHelper;
use XCrm\Media\CutterBehavior;
use yii\base\InvalidConfigException;
use Yii;

class Profile extends \Da\User\Model\Profile
{
    use ApplicationAwareTrait;

    public function getId()
    {
        return $this->user_id;
    }

    public function getAvatarUrl($size = 200)
    {
        return $this->getJacketUrl();
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'jacket_img-upload' => [
                'class' => CutterBehavior::class,
            ],
        ]);
    }

    public function __get($name)
    {
        if ('birth_date' === $name) return $this->getBirthDate();
        return parent::__get($name);
    }

    public function getBirthDate()
    {
        return date('d.m.Y', strtotime($this->getAttribute('birth_date')));
    }

    public function afterValidate()
    {
        /**
         * @todo Добавить политики даты рождений пользователя (минимальный возраст и т.д.)
         */
        parent::afterValidate();
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidConfigException
     */
    public function rules()
    {
        return [
            'bioString' => ['bio', 'string'],
            'timeZoneValidation' => [
                'timezone',
                function ($attribute) {
                    if ($this->make(TimeZoneValidator::class, [$this->{$attribute}])->validate() === false) {
                        $this->addError($attribute, Yii::t('usuario', 'Time zone is not valid'));
                    }
                },
            ],
            'websiteUrl' => ['website', 'url'],
            'locationLength' => ['location', 'string', 'max' => 255],
            'websiteLength' => ['website', 'string', 'max' => 255],

            [['name_last', 'name_first', 'name_middle', 'phone',], 'string'],

            [['birth_date'], 'filter', 'filter' => function ($value) {
                return $value ? date('Y-m-d', strtotime($value)) : null;
            }],
           // [['birth_date'], 'date'],
            'jacket_img-type' => ['jacket_img', 'string'],
        ];
    }
}