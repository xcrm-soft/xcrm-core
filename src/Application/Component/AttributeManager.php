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
use XCrm\Data\Attribute\Attribute;
use XCrm\Data\Attribute\Special\ReferenceAttribute;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use Yii;

class AttributeManager extends Component
{
    /**
     * @var string директория, содержащая конфигурации встроенных типизированных атрибутов
     *    с зарезервированными именами
     */
    public $coreAttributesDir;
    /**
     * @var Attribute[] сконфигурированные объекты определений атрибутов с зарезервированными именами
     */
    protected $attributesMap = null;

    protected $formSections = [];

    public $labels;

    /**
     * Возарщает объект определения атрибута
     * @param $name
     * @return Attribute
     */
    public function get($name)
    {
        if ($reference = $this->app->referenceManager->isReferenceAttribute($name)) {
            return new ReferenceAttribute([
                'name' => $name,
            ]);
        }

        if (isset($this->attributesMap[$name])) {
            return $this->attributesMap[$name];
        }
        throw new InvalidArgumentException('Unknown attribute ' . $name);
    }

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        $this->ensureAttributeDefinitions();
    }

    /**
     * {@inheritDoc}
     */
    public function __construct($config = [])
    {
        if (!isset($config['coreAttributesDir'])) {
            $config['coreAttributesDir'] = __DIR__ . '/../../../resource/_config/attributes';
        }
        parent::__construct($config);
    }

    protected function ensureAttributeDefinitions()
    {
        if (null !== $this->attributesMap) return;

        $this->attributesMap = [];
        $map = ArrayHelper::merge($this->loadCoreAttributes(), $this->loadRepositoryAttributes());
        foreach ($map as $name => $config) {
            $this->attributesMap[$name] = $attr = Yii::createObject(array_merge([
                'section' => 'content',
                'order' => 100,
            ], $config, ['name' => $name]));

            /** @var Attribute $attr */
            $this->formSections[$attr->section][$name] = $attr->order;
            $this->labels[$name] = $attr->label ?? $name;
        }

        foreach ($this->formSections as $section=>$attributes) {
            asort($this->formSections[$section]);
        }
    }

    public function getSectionAttributes($sectionName)
    {
        if (isset($this->formSections[$sectionName])) {
            return array_keys($this->formSections[$sectionName]);
        }
        return [];
    }

    /**
     * @return array
     * @noinspection PhpIncludeInspection
     */
    protected function loadCoreAttributes()
    {
        $coreAttributes = [];
        $files = FileHelper::findFiles($this->coreAttributesDir, ['only'=>['*.php']]);
        if (is_array($files)) foreach ($files as $file) {
            if (file_exists($file)) $coreAttributes[basename($file, '.php')] = require $file;
        }
        return $coreAttributes;
    }

    protected function loadRepositoryAttributes()
    {
        return [];
    }
}