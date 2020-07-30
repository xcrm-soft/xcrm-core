<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Database;
use XCrm\Application\ApplicationAwareTrait;
use XCrm\Database\Helper\TableDescriptionHelper;
use yii\helpers\ArrayHelper;
use SideKit\Config\ConfigKit;

class Connection extends \yii\db\Connection
{
    use ApplicationAwareTrait;

    /**
     * @var TableDescriptionHelper[]
     */
    private $_descriptions = [];

    public function __construct($config = [])
    {
        parent::__construct(ArrayHelper::merge([
            'dsn'         => ConfigKit::env()->get('DATABASE_DSN'),
            'username'    => ConfigKit::env()->get('DATABASE_USER'),
            'password'    => ConfigKit::env()->get('DATABASE_PASSWORD'),
            'charset'     => ConfigKit::env()->get('DATABASE_CHARSET'),
            'tablePrefix' => ConfigKit::env()->get('DATABASE_TABLE_PREFIX'),
        ], $config));
    }

    protected function getDefaultConfig($name)
    {
        return [];
    }

    public function describeTable($tableName, $skipAttributes = null)
    {

        $raw = $this->getSchema()->getRawTableName($tableName);
        if (!isset($this->_descriptions[$raw])) {

            if ($schema = $this->getSchema()->getTableSchema($tableName))
            $this->_descriptions[$raw] = new TableDescriptionHelper($schema->getColumnNames(), [
                'skipAttributes' => $skipAttributes
            ]);
        }
        return $this->_descriptions[$raw] ?? null;
    }
}