<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Helper;

/**
 * Class StringHelper
 * @package XCrm\Data\Helper
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class StringHelper extends \yii\helpers\StringHelper
{
    /**
     * Делит строку на две по первому слева вхождению раздлелителя
     * @param string $string
     * @param string $delimiter
     * @return string|array
     */
    public static function leftSplit($string, $delimiter)
    {
        $left = $string;
        $right = null;
        if (false !== ($pos = strpos($string, $delimiter))) {
            $left = substr($string, 0, $pos);
            $right = substr($string, $pos + strlen($delimiter));
        }

        return $right ? [trim($left), trim($right)] : trim($left);
    }

    public static function rightSplit($string, $delimiter)
    {
        $right = $string;
        $left = null;
        if (false !== ($pos = strrpos($string, $delimiter))) {
            $left = substr($string, 0, $pos);
            $right = substr($string, $pos + strlen($delimiter));
        }

        return $right ? [trim($right), trim($left)] : trim($right);
    }

    public static function translit($value)
    {
        $url = str_replace(array(
            '?','!','.',',',':',';','*','(',')','{','}','%','#','№','@','$','^','-','+','/','\\','=','|','"','\'',
            'а','б','в','г','д','е','ё','з','и','й','к',
            'л','м','н','о','п','р','с','т','у','ф','х',
            'ъ','ы','э',' ','ж','ц','ч','ш','щ','ь','ю','я'
        ), array(
            '','','','','','-','','','','','','','','','','','','-','','-','','','','','',
            'a','b','v','g','d','e','e','z','i','y','k',
            'l','m','n','o','p','r','s','t','u','f','h',
            'j','i','e','-','zh','ts','ch','sh','shch',
            '','yu','ya'
        ), mb_strtolower($value));

        while (false !== strpos($url, '--')) $url = str_replace('--', '-', $url);
        return $url;
    }

    public static function decamelize($string)
    {
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
    }
}