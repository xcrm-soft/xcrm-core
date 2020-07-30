<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Integrations\Yandex;
use XCrm\I18N\Components\Translations\AbstractTranslator;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

class YaTranslate extends AbstractTranslator
{
    public $apiUrl = 'https://translate.yandex.net/api/v1.5/tr.json/translate';
    public $apiUrlDetect = 'https://translate.yandex.net/api/v1.5/tr.json/detect';
    public $apiKey;

    /**
     * You can translate text from one language
     * to another language
     * @param string $source Source language
     * @param string $target Target language
     * @param string $text   Source text string
     * @return array
     */
    public function translate($text, $target, $source = null)
    {
        $langDirection = $source
            ? explode('-', $source)[0].'-'.explode('-', $target)[0]
            : $target;

       if (empty($text)) return null;

        $translation = (strlen($text)>300)
            ? $this->getPostResponse($text, $langDirection)
            : $this->getResponse($text, $langDirection);

        if (isset($translation['code']) && 200 == $translation['code'] && isset($translation['text'][0])) {
            return $translation['text'][0];
        } else {
            die ('Invalid Translation');
        }

    }

    /**
     * Forming query parameters
     * @param  string $text   Source text string
     * @param  string $lang   Translation direction ru-en, en-es
     * @return array          Data properties
     */
    protected function getPostResponse($text = '', $lang = 'en-ru')
    {
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query(
                    [
                        'key' => $this->apiKey,
                        'lang' => $lang,
                        'text' => $text,
                        'format' => 'html',
                    ]
                )
            )
        );

        $context  = stream_context_create($opts);

        $response = file_get_contents($this->apiUrl, false, $context);
        return Json::decode($response, true);
    }

    /**
     * Forming query parameters
     * @param  string $text   Source text string
     * @param  string $lang   Translation direction ru-en, en-es
     * @return array          Data properties
     */
    protected function getResponse($text = '', $lang = 'en-ru')
    {
        $request = $this->apiUrl . '?' . http_build_query(
                [
                    'key' => $this->apiKey,
                    'lang' => $lang,
                    'text' => $text,
                    'format' => 'html',
                ]
            );

        $response = file_get_contents($request);
        return Json::decode($response, true);
    }

    public function __construct($config = [])
    {
        $config['apiKey'] = $config['apiKey'] ?? $this->app->env('YANDEX_TRANSLATE_KEY');
        if (!isset($config['apiKey'])) {
            throw new InvalidConfigException('API Key should be set');
        }
        parent::__construct($config);
    }
}