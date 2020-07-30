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
use SideKit\Config\Contracts\ConfigurationBuilderInterface;
use SideKit\Config\Exception\InvalidConfigException;
use SideKit\Config\Support\Filesystem;
use yii\helpers\ArrayHelper;

class Builder implements ConfigurationBuilderInterface
{
    protected $fileSystem = null;
    protected $cacheDirectory;
    protected $useCache;
    protected $configPath;

    public function __construct(Filesystem $fileSystem = null)
    {
        $this->fileSystem = $fileSystem ?: ConfigKit::filesystem();
    }

    /**
     * @param string $name
     * @return array|mixed
     * @throws \SideKit\Config\Exception\FileNotFoundException
     */
    public function build($name)
    {
        $cached = $this->cacheDirectory.DIRECTORY_SEPARATOR.$name.'-config.php';

        if ($this->useCache && $this->fileSystem->exists($cached)) {
            return $this->fileSystem->getRequiredFileValue($cached);
        }


        $config = $this->fileSystem->getRequiredFileValue($this->configPath.DIRECTORY_SEPARATOR.'app.php');
        $sections = $this->buildSections($this->configPath);

        $config = ArrayHelper::merge($config, $sections);
        $config = ArrayHelper::merge($this->fileSystem->getRequiredFileValue(dirname($this->configPath).DIRECTORY_SEPARATOR.'defaults.php'), $config);
        $config = ArrayHelper::merge($config, $this->buildEnv($name, ConfigKit::env()->get('YII_ENV')));
        $this->cacheFile($cached, $config);

        if ('cli' !== php_sapi_name()) {
            if (!isset($config['components']['request']['cookieValidationKey']) && 'cli' !== php_sapi_name()) {
                $configFileName = $this->configPath . DIRECTORY_SEPARATOR . 'app.php';
                $config['components']['request']['cookieValidationKey'] = md5($configFileName . filemtime($configFileName));
            }
        }

        return $config;
    }

    public function useCache($value)
    {
        $this->useCache = $value;
        return $this;
    }

    public function useCacheDirectory($path)
    {
        if (!$this->fileSystem->isDirectory($path)) {
            $this->fileSystem->makeDirectory($path, 0755, false, true);
        }

        $this->cacheDirectory = $path;

        return $this;
    }

    public function useDirectory($path)
    {
        if (!is_dir($path)) {
            throw new InvalidConfigException('Configuration folder path seems to be incorrect. ' . $path);
        }
        $this->configPath = $path;

        return $this;
    }

    protected function buildSections($path)
    {
        $directories = $this->fileSystem->directories($path);

        $sections = [];

        foreach ($directories as $directory => $path) {
            foreach ($this->fileSystem->allFiles($path, '/^.*\.php/i') as $basename => $filePath) {
                $config = $this->fileSystem->getRequiredFileValue($filePath);
                if (is_array($config)) {
                    $sections[$directory][$basename] = $config;
                }
            }
        }

        return $sections;
    }

    protected function buildEnv($name, $env)
    {
        $config = [];
        $sections = [];
        $configPath = ConfigKit::config()->getEnvConfigPath().DIRECTORY_SEPARATOR.$name;
        $path = $configPath.DIRECTORY_SEPARATOR.$env;

        if ($this->fileSystem->exists($path)) {
            $envConfig = $path.DIRECTORY_SEPARATOR.'app.php';

            if ($this->fileSystem->exists($envConfig)) {
                $config = $this->fileSystem->getRequiredFileValue($envConfig);
                if (!is_array($config)) {
                    $config = [];
                }
            }
            $sections = $this->buildSections($path);
        }

        /*
         * Local configuration always overrides
         */
        $local = ConfigKit::str()->is($env, 'local')
            ? $sections // local env? is an override
            : ArrayHelper::merge($sections, $this->buildEnv($name, 'local'));

        return ArrayHelper::merge($config, $local);
    }

    protected function cacheFile($path, $config)
    {
        if ($this->useCache) {
            $varStr = str_replace('\\\\', '\\', var_export($config, true));
            $this->fileSystem->put($path, "<?php\n\nreturn {$varStr};");
        }
    }
}