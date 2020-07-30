<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Frontend;
use XCrm\Application\Web\View;
use XCrm\Data\ActiveRecord;
use XCrm\Data\Localization;
use XCrm\Frontend\Utils\AnyPropertyModel;
use XCrm\Modules\Website\Model\PageService;

class PageView extends View
{
    /**
     * Имя класса модели статичных текстовых блоков для служебных страниц
     * @var string|PageService
     */
    public $servicePageModel = PageService::class;

    /**
     * @var AnyPropertyModel|Localization|ActiveRecord
     */
    public $servicePage = null;

    /**
     * Маппинг атрибутов моделей к создаваемым мета-тегам
     * @var string[]
     */
    public $metaTagsAttributes = [
        'title' => 'meta_title',
        'keywords' => 'meta_keywords',
        'description' => 'meta_description',
        'heading' => 'heading',
    ];


    /**
     * Извлекает мета-теги из модели
     * @param $model
     * @return Localization
     */
    public function meta($model)
    {
        $localization = $model->localize();

        foreach ($this->metaTagsAttributes as $tag=>$attribute) {
            $value = $localization->$attribute;
            if (!$value) continue;

            if (!empty($value)) switch ($tag) {
                case 'title':
                    $this->title = $value;
                    break;
                case 'heading':
                    $this->heading = $value;
                    break;
                default:
                    $this->params['meta'][$tag] = $value;
            }
        }

        return $localization;
    }

    /**
     * Формирует мета-теги
     * @param $id
     */
    public function service($id)
    {
        if ($service = $this->servicePageModel::findOne(['key_name' => $id])) {
            $this->servicePage = $this->meta($service);
        }
    }

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->servicePage = new AnyPropertyModel();
    }
}