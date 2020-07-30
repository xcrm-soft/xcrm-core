<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application\Component;
use XCrm\Application\Base\Component;
use XCrm\Modules\Reference\Model\ReferenceBook;
use XCrm\Modules\Reference\Model\ReferenceRegistry;
use XCrm\Modules\Reference\Model\ReferenceStructure;
use yii\base\InvalidConfigException;
use yii\base\InvalidArgumentException;

class ReferenceManager extends Component
{
    /**
     * @var string префикс полей, обрабатывемых как ссылки на позиции справочников
     */
    public $referenceKeyPrefix = 'xref_';

    /**
     * @param string $keyName
     * @param bool $throwException
     * @return ReferenceRegistry|null
     * @throws InvalidArgumentException
     */
    public function getInfo($keyName, $throwException = true)
    {
        if ($info = ReferenceRegistry::findOne(['key_name' => $keyName])) {
            return $info;
        }
        if ($throwException) {
            throw new InvalidArgumentException('Reference key ' . $keyName . ' not found');
        }
        return null;
    }

    /**
     * @param string $keyName
     * @param int $value
     * @return string|ReferenceBook|null
     */
    public function getReferenceObject($keyName, $value)
    {
        if ($info = $this->getInfo($keyName, false)) {
            $referenceBook = $info->class_name;
            return $referenceBook::findOne(['id' => $value]);
        }
        return null;
    }

    public function getReferenceBook($key, $searchBy = 'key_name')
    {
        return ReferenceRegistry::findOne([$searchBy => $key]);
    }

    public function isReferenceAttribute($attributeName, $checkReferenceExists = true)
    {
        if ($referenceKey = $this->extractReferenceKeyFrom($attributeName)) {
            return $checkReferenceExists
                ? $this->getReferenceBook($referenceKey)
                : true;
        }
        return false;
    }

    public function extractReferenceKeyFrom($attributeName)
    {
        if (0 === strpos($attributeName, $this->referenceKeyPrefix)) {
            return substr($attributeName, strlen($this->referenceKeyPrefix));
        }
        return false;
    }

    /**
     * @param $keyName
     * @param string|ReferenceBook $className
     * @param string $category
     * @throws InvalidConfigException
     * @return ReferenceRegistry
     */
    public function register($keyName, $className, $category = '/')
    {
        $tableName = $className::getDb()->schema->getRawTableName($className::tableName());
        if (ReferenceRegistry::findOne(['table_name' => $tableName])) {
            throw new InvalidConfigException('Reference book for ' . $tableName . ' exists');
        }

        $parent = ReferenceStructure::findOne(['url' => $category]);
        if (!$parent) {
            throw new InvalidConfigException('Category ' . $category . ' not found');
        }

        $reg = new ReferenceRegistry([
            'key_name' => $keyName,
            'class_name' => $className,
            'table_name' => $tableName,
            'name' => $className::getTitle() ?? $className::tableName(),
            'parent_id' => $parent->id,
        ]);

        if (!$reg->smartSave()) {
            print_r($reg->errors);
            throw new InvalidConfigException('Unable to register reference');
        }

        return $reg;
    }
}