<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\I18N\Components;
use yii\base\BaseObject;
use yii\i18n\MissingTranslationEvent;
use XCrm\I18N\Model\SourceMessage;
use Yii;

class I18NMissingTranslation extends BaseObject
{
    public static function handle(MissingTranslationEvent $event)
    {
        $driver = Yii::$app->getDb()->getDriverName();
        $caseInsensitivePrefix = $driver === 'mysql' ? 'binary' : '';
        $sourceMessage = SourceMessage::find()
            ->where('category = :category and message = ' . $caseInsensitivePrefix . ' :message', [
                ':category' => $event->category,
                ':message' => $event->message
            ])
            ->with('messages')
            ->one();
        if (!$sourceMessage) {
            $sourceMessage = new SourceMessage;
            $sourceMessage->setAttributes([
                'category' => $event->category,
                'message' => $event->message
            ], false);
            $sourceMessage->save(false);
        }

        $sourceMessage->initMessages();

        if ($translator = Yii::$app->i18n->getTranslator()) {
            /** @var Yandex $translator */
            //$messages = $sourceMessage->getMessages()->all();
            //$debug = [];

            foreach ($sourceMessage->messages as $target=>$message) {
                $message->translation = $translator->translate($sourceMessage->message, $target);
                //$message->save();
                //$debug[$target] = $message->attributes;
            }
            //print_r($debug);
            //die;
        }
        $sourceMessage->saveMessages();
    }
}