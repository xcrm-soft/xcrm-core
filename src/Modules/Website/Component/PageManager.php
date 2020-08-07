<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Website\Component;
use XCrm\Application\Base\Component;

/**
 * Компонент для управления страницами
 *
 * @package XCrm\Modules\Website\Component
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class PageManager extends Component
{
    /**
     * @var string[] масиив определений макетов страниц
     */
    public $availableLayouts = [
        '//main'  => 'Внутренняя страница',
        '//index' => 'Главная страница',
        '//blank' => 'Пустая страница',
    ];
    /**
     * @var string идентификатор макета страницы, применяемый по умолчанию
     */
    public $defaultLayout = '//main';
}