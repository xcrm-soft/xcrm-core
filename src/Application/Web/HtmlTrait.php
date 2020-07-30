<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Application\Web;


trait HtmlTrait
{
    protected static function prepareText(&$options)
    {
        $text = $options['text'];

        if (isset($options['options']['icon'])) {
            $text = static::tag('i', '', ['class' => $options['options']['icon']])
                . static::tag('span', '&nbsp;' . $text, ['class' => 'icon-button-caption']);
            unset($options['options']['icon']);
        }
        return $text;
    }

    public static function renderButton($config)
    {
        $text = self::prepareText($config);
        $url = $config['url'] ?? null;
        $options = $config['options'] ?? [];

        switch ($config['type'] ?? 'link') {
            case 'submit':
                return static::submitButton($text, $options);
            case 'reset':
                return static::resetButton($text, $options);
            default: //если явно не указан тип, считаем, что рендерится ссылка или якорь
                return parent::a($text, $url, $options);
        }
    }
}