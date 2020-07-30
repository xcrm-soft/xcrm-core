<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Database\Migration;


use XCrm\Media\FileUploadHelper;
use XCrm\Modules\Reference\Model\ReferenceBook;
use yii\base\Exception;
use yii\helpers\Json;

class MigrationOfReferenceBook extends MigrationOfConfigurable
{
    const SKIP_ON_EXISTS = 10;
    const UPDATE_ON_EXISTS = 20;

    /**
     * @param ReferenceBook|string $class
     * @param $file
     * @param int $onExists
     * @param string $field
     * @throws Exception
     */
    public function uploadJson($class, $file, $onExists = self::SKIP_ON_EXISTS, $field = '_key_name')
    {
        if (!file_exists($file)) throw new Exception('File not fond ' . $file);
        $json = Json::decode(file_get_contents($file), true);

        if (!empty($json)) foreach ($json as $item) {
            if (!isset($item[$field])) throw new Exception('Key field ' . $field . ' not found');
            if ($e = $class::findOne([$field => $item[$field]])) {
                if (self::UPDATE_ON_EXISTS == $onExists) {
                    $e->attributes = $item;
                }
                if (self::SKIP_ON_EXISTS == $onExists) continue;
            } else {
                $e = new $class($item);
            }
            if (!$e->save()) {
                print_r($e->errors);
                throw new Exception('Unable to update reference');
            }
        }
    }

    /**
     * @param string $key
     * @param ReferenceBook|string $class
     * @param array $columns
     * @param string $category
     * @param null $options
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function createReferenceBook($key, $class, $columns = [], $category = '/', $options = null)
    {
        $reg = $this->app->referenceManager->register($key, $class, $category);

        if (isset($options['upload'])) {
            FileUploadHelper::uploadCustom($reg, $options['upload']);
            unset($options['upload']);
        }

        if (isset($options['info'])) {
            $reg->content_short = $options['info'];
            $reg->save();
        }

        $options = $options['db'] ?? null;

        if (empty($columns)) {
            $columns = [
                'id',
                'merge_id',
                'uuid',
                'key_name',
                'name',
                'created_at',
                'created_by',
                'updated_at',
                'updated_by'
            ];
        }

        $this->createTable($class::tableName(), $columns, $options);
        if (isset($columns['merge_id'])) $this->createIndex('IDX_' . $key . '_merge_id', $class::tableName(), '_merge_id');
        if (isset($columns['is_default'])) $this->createIndex('IDX_' . $key . '_is_default', $class::tableName(), '_is_default');
    }

    /**
     * @param ReferenceBook|string $class
     */
    public function dropReferenceBook($class)
    {
        return $this->dropTable($class::tableName());
        // @todo убрать из реестра
    }
}