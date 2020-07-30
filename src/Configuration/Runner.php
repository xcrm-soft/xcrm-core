<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Configuration;

use SideKit\Config\ConfigKit;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use XCrm\Application\Console\Application as ConsoleApplication;
use XCrm\Application\Web\Application as WebApplication;
use yii\base\InvalidConfigException;
use Yii;

/**
 * Class Environment
 *
 * @package XCrm\Configuration
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class Runner
{
    private $_rootDirectory;

    /**
     * @param null $id
     * @return object
     * @throws InvalidConfigException
     */
    public function createApplication($id = null)
    {
        $hostConfig = [];
        if (null === $id) {
            if ('cli' === php_sapi_name()) $id = 'console';
            else {
                $applicationHost = $_SERVER['HTTP_HOST'];
                $hosts = require $this->_rootDirectory . '/config/hosts.php';
                foreach ($hosts as $app=>$list) {
                    if (isset($list[$applicationHost])) {
                        $id = $app;
                        $hostConfig = $list[$applicationHost];
                        break;
                    }
                }
            }
            if (null === $id) $id = 'unknown';
        }

        $config = ArrayHelper::merge([
            'id'                  => $id,
            'basePath'            => $this->_rootDirectory . '/applications/' . $id,
            'runtimePath'         => $this->_rootDirectory . '/runtime/' . $id,
            'vendorPath'          => $this->_rootDirectory . '/vendor',
            'controllerNamespace' => 'app\\' . $id . '\\controllers',
            'class'               => ('cli' === php_sapi_name()) ? ConsoleApplication::class : WebApplication::class,
            'aliases' => [
                '@bower' => '@vendor/bower-asset',
            ],
        ], ConfigKit::config()->build($id, ConfigKit::env()->get('CONFIG_USE_CACHE', true)), $hostConfig);

        if (!is_dir($config['runtimePath'])) {
            mkdir($config['runtimePath'], 0777, true);
        }

        return Yii::createObject($config);
    }

    /**
     * Environment constructor.
     * @param string $rootDirectory
     * @param Builder $configBuilder
     * @noinspection PhpIncludeInspection
     */
    public function __construct($rootDirectory, Builder $configBuilder = null)
    {
        if (!is_dir($rootDirectory)) throw new InvalidArgumentException('Unknown directory ' . $rootDirectory);
        $this->_rootDirectory = $rootDirectory;

        if (null === $configBuilder) {
            $configBuilder = new Builder();
        }

        ConfigKit::config()
            ->useConfigurationBuilder($configBuilder)
            ->useRootPath($rootDirectory);

        ConfigKit::env()->load();

        defined('YII_DEBUG') or define('YII_DEBUG', ConfigKit::env()->get('YII_DEBUG', false));
        defined('YII_ENV')   or define('YII_ENV', ConfigKit::env()->get('YII_ENV', 'prod'));

        require_once $rootDirectory . '/vendor/yiisoft/yii2/Yii.php';
    }
}