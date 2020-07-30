<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Reference\BackOffice;
use XCrm\Modules\Reference\Model\ReferenceRegistry;
use XCrm\Modules\Reference\BackOffice\Controller\CategoriesController;
use XCrm\Modules\Reference\BackOffice\Controller\DefaultController;
use XCrm\Modules\Reference\BackOffice\Controller\RegistryController;
use Yii;

class Module extends \XCrm\Modules\Reference\Module
{
    public function coreControllerMap()
    {
        $map = [
            'default' => DefaultController::class,
            'categories' => CategoriesController::class,
            'registry' => RegistryController::class,
        ];

        $refs = ReferenceRegistry::find()->all();
        foreach ($refs as $ref) {
            $map[$ref->uuid] = [
                'class' => $ref->class_name::backendControllerClass(),
                'modelClass' => $ref->class_name
            ];
        }

        return $map;
    }

    /**
     * {@inheritDoc}
     */
    public static function getNavigation()
    {
        return [
            'section' => 'settings',
            'title' => static::getTitle(),
            'icon' => 'reference',
            'links' => [
                ['label' => 'Обзор справочников', 'url' => ['default/index'], 'visible' => true],
                ['label' => 'Реестр справочников', 'url' => ['registry/index'], 'visible' => true],
                ['label' => 'Рубрикатор справочников',  'url' => ['categories/index'], 'visible' => true],
            ]
        ];
    }

    public function __construct($id, $parent = null, $config = [])
    {
        $config['viewPath'] = $config['viewPath'] ?? Yii::getAlias('@XCrmResource') . '/Reference/BackOffice/views';
        parent::__construct($id, $parent, $config);
    }
}