<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Smarty\Component;
use XCrm\Application\Base\Component;
use XCrm\Modules\Smarty\Model\Ref\RefSmartyCategory;
use XCrm\Modules\Smarty\Model\Ref\RefSmartyGroup;
use XCrm\Modules\Smarty\Model\SmartyTemplate;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;

class SmartyRegistry extends Component
{
    /**
     * @var string|RefSmartyCategory
     */
    public $categoryClass = RefSmartyCategory::class;
    /**
     * @var string|RefSmartyGroup
     */
    public $groupClass = RefSmartyGroup::class;
    /**
     * @var string|SmartyTemplate
     */
    public $templateClass = SmartyTemplate::class;



    public function getCategory($keyName)
    {
        return $this->categoryClass::findOne(['key_name' => strtolower($keyName)]);
    }

    public function getGroup($keyName)
    {
        return $this->groupClass::findOne(['key_name' => strtolower($keyName)]);
    }

    /**
     * @param $category
     * @param $group
     * @param $keyName
     * @return \XCrm\Data\Localization
     */
    public function getTemplate($category, $group, $keyName)
    {
        $categoryRef = $this->getCategory($category);
        $groupRef = $this->getGroup($group);

        if (!$categoryRef) throw new InvalidArgumentException('Unknown category ' . $category);
        if (!$groupRef) throw new InvalidArgumentException('Unknown group ' . $group);

        if ($template = $this->templateClass::findOne([
            'xref_refSmartyCategory' => $categoryRef->primaryKey,
            'xref_refSmartyGroup' => $groupRef->primaryKey,
            'key_name' => $keyName,
        ])) {

            return $template->localize();

        } else throw new InvalidArgumentException('Template ' . $category . '/' . $group . '/' . $keyName . ' not found');
    }

    /**
     * @param string $keyName
     * @param null $name
     * @param bool $isSystem
     * @return object|RefSmartyCategory|null
     * @throws InvalidConfigException
     */
    public function registerCategory($keyName, $name = null, $isSystem = false, $throwException = true)
    {
        if (!($category = $this->getCategory($keyName))) {
            $category = \Yii::createObject([
                'class' => $this->categoryClass,
                'key_name' => strtolower($keyName),
                'name' => $name ?? $keyName,
                'is_system' => intval($isSystem)
            ]);

            if (!$category->save() && $throwException) {
                throw new InvalidConfigException('Unable to create category ' . $keyName);
            }
        }
        return $category;
    }

    /**
     * @param string $keyName
     * @param null $name
     * @param bool $isSystem
     * @return object|RefSmartyCategory|null
     * @throws InvalidConfigException
     */
    public function registerGroup($keyName, $name = null, $isSystem = false, $throwException = true)
    {
        if (!($group = $this->getGroup($keyName))) {
            $group = \Yii::createObject([
                'class' => $this->groupClass,
                'key_name' => strtolower($keyName),
                'name' => $name ?? $keyName,
                'is_system' => intval($isSystem)
            ]);

            if (!$group->save() && $throwException) {
                throw new InvalidConfigException('Unable to create group ' . $keyName);
            }
        }
        return $group;
    }

    public function registerTemplate($category, $group, $keyName, $name, $fileName)
    {
        $categoryRef = $this->getCategory($category);
        $groupRef = $this->getGroup($group);

        if (!$categoryRef || !$groupRef) {
            throw new InvalidArgumentException('Invalid category or group');
        }

        if ($template = $this->templateClass::findOne([
            'xref_refSmartyCategory' => $categoryRef->primaryKey,
            'xref_refSmartyGroup' => $groupRef->primaryKey,
            'key_name' => $keyName
        ])) throw new InvalidArgumentException('Template ' . $category . '/' . $group . '/' . $keyName . ' exists');

        $template = \Yii::createObject([
            'class' => $this->templateClass,
            'xref_refSmartyCategory' => $categoryRef->primaryKey,
            'xref_refSmartyGroup' => $groupRef->primaryKey,
            'key_name' => $keyName,
            'name' => $name,
            'source_code' => file_get_contents($fileName)
        ]);

        if (!$template->save()) {
            throw new InvalidArgumentException('Unable to save template ' . $category->_key_name . '/' . $keyName);
        }
    }
}