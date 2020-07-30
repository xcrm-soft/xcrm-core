<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Media;
use XCrm\Data\ActiveRecord;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\base\InvalidCallException;

class FileUploadHelper extends BaseObject
{
    public static function uploadCustom(ActiveRecord $model, $files = [])
    {
        if (empty($files)) return null;
        if ($model->isNewRecord) {
            throw new InvalidCallException('Upload Custom is not supported for new records');
        }

        $tableName = $model::getDb()->schema->getRawTableName($model::tableName());
        $dir = \Yii::getAlias('@media/public') . '/' . $tableName . '/' . $model->primaryKey;
        if (!is_dir($dir)) {
            $created = mkdir($dir, 0777, true);
            if (!$created) throw new InvalidCallException('Unable to create directory ' . $dir);
        }

        $up = 0;
        foreach ($files as $attribute=>$fileName) {
            if (!file_exists($fileName)) throw new InvalidArgumentException('File not found ' . $fileName);
            if ($model->canModify($attribute)) {
                ++ $up;
                $extension = strrchr($fileName, '.');
                $resultFile = $dir . '/' . $attribute . $extension;
                copy($fileName, $resultFile);
                chmod($resultFile, 0777);
                $model->$attribute = substr($extension, 1);
            }
        }

        if ($up) $model->smartSave();
        return $up;
    }
}