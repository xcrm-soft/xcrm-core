<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\BackOffice\Component;
use yii\base\InvalidConfigException;
use Yii;

class View extends \XCrm\Application\Web\View
{
    public $heading;
    public $headingIcon;
    public $tabs;

    protected $_navigation = [
        'class' => NavigationBuilder::class,
    ];

    public function beforeRender($viewFile, $params)
    {
        if (!$this->heading && isset($this->context->module) && method_exists(get_class($this->context->module), 'getTitle')) {
            $this->heading = $this->context->module::getTitle();
        }
        return parent::beforeRender($viewFile, $params);
    }

    /**
     * @return object
     * @throws InvalidConfigException
     */
    public function getNavigation()
    {
        if (is_array($this->_navigation)) $this->_navigation = Yii::createObject($this->_navigation);
        return $this->_navigation;
    }
}