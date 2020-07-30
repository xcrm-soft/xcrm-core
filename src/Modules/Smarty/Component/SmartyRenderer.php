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
use XCrm\Helper\ArrayHelper;
use XCrm\Modules\Smarty\Model\SmartyTemplate;
use yii\base\InvalidConfigException;
use Yii;
use Smarty;
use SmartyException;

/**
 * Class SmartyRenderer
 *
 * @property-read SmartyRegistry $registry
 * @property string $templateLanguage
 *
 * @package XCrm\Modules\Smarty\Component
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class SmartyRenderer extends Component
{
    public $registryConfig = [
        'class' => SmartyRegistry::class,
    ];

    public $pluginDirs = [];
    /**
     * @var SmartyRegistry
     * @see getRegistry()
     */
    private $_registry = null;
    /**
     * @var string
     * @see getTemplateLanguage()
     * @see setTemplateLanguage()
     */
    private $_templateLanguage = null;
    /**
     * @var Smarty
     */
    private $_smarty;

    /**
     * @param $template
     * @param array $params
     * @return bool|string
     * @throws SmartyException
     */
    public function fetch($template, $params = [])
    {
        $this->_smarty->clearAllAssign();
        if (!empty($params)) foreach ($params as $k=>$v) $this->_smarty->assign($k, $v);
        return $this->_smarty->fetch('xcrm:' . $template);
    }

    /**
     * @param $fullName
     * @return SmartyTemplate|\XCrm\Data\Localization
     */
    public function getTemplate($fullName)
    {
        list ($category, $group, $keyName) = explode('/', $fullName);
        return $this->registry->getTemplate($category, $group, $keyName);
    }

    /**
     * @return object|SmartyRegistry
     * @throws InvalidConfigException
     */
    public function getRegistry()
    {
        if (null === $this->_registry) {
            $this->_registry = Yii::createObject($this->registryConfig);
        }
        return $this->_registry;
    }

    public function setTemplateLanguage($language)
    {
        $this->_templateLanguage = $language;
    }

    public function getTemplateLanguage()
    {
        return $this->_templateLanguage ?? $this->app->user->getContentLanguage();
    }


    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->_smarty = new Smarty();
        $pluginDirs = ArrayHelper::merge([__DIR__ . '/Plugin'], $this->pluginDirs);
        foreach ($pluginDirs as $pluginDir) $this->_smarty->addPluginsDir($pluginDir);
    }
}