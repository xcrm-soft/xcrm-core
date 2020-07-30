<?php
/**
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2019, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Media;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use XCrm\Application\ApplicationAwareTrait;
use yii\base\InvalidArgumentException;
use yii\behaviors\AttributeBehavior;
use yii\web\UploadedFile;
use XCrm\Data\ActiveRecord;
use XCrm\Data\Helper\StringHelper;
use Yii;

class FileUploadBehavior extends AttributeBehavior
{
    use ApplicationAwareTrait;

    /** @var string имя атрибута модели */
    public $attribute = '_jacket_image_svg';
    /** @var string директория для сохранения загруженныъх файлов */
    public $baseDir;
    /** @var string корневая директория для сохранения загруженных файлов */
    public $basePath = null;
    /** @var int качество изображения при кадрировании или изменении размера */
    public $quality = 92;
    /** @var int права для новых директорий */
    public $createDirectoryMode = 0777;
    /** @var string */
    public $altAttribute;

    /** @var UploadedFile */
    private $_uploadedFile = null;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'prepare',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'prepare',
            ActiveRecord::EVENT_AFTER_INSERT  => 'save',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'save',
            ActiveRecord::EVENT_BEFORE_DELETE => 'delete',
        ];
    }

    public function getFileUrl($attributeName)
    {
        if ($attributeName === $this->attribute) {
            return ($this->app->params['hosts.mediaBaseUrl'] ?? $this->app->env('MEDIA_BASE_URL') ?? '//')
                . str_replace('\\', '/', $this->baseDir)
                . '/' . $this->owner->primaryKey
                . '/' . $this->attribute . '.' . $this->owner->{$this->attribute};
        }
        return null;

    }

    public function attach($owner)
    {
        parent::attach($owner);
        if (!$this->baseDir) {
            $ownerClass = get_class($this->owner)::getDb()->schema->getRawTableName($this->owner::tableName());
            $ownerName = substr($ownerClass, strrpos($ownerClass, '\\'));
            $this->baseDir = '/' . StringHelper::decamelize($ownerName);
        }
    }

    /**
     * Перед сохранением загруженного файла заполняет соответстующий атрибут модели
     * значением расширекния файла изображения
     */
    public function prepare()
    {
        $this->_uploadedFile = UploadedFile::getInstance($this->owner, $this->attribute);

        if ($this->_uploadedFile) {
            if (!$this->owner->isNewRecord) $this->delete();
            $this->owner->{$this->attribute} = substr(strrchr($this->_uploadedFile->name, '.'), 1);
        } elseif (isset($this->owner->oldAttributes[$this->attribute])) {
            $this->owner->{$this->attribute} = $this->owner->oldAttributes[$this->attribute];
        }
    }

    /**
     * Сохраняет загруженный файл после сохранения модели (когда присвоено значение первичного ключа)
     */
    public function save()
    {
        if (!$this->_uploadedFile) return;
        $croppingFileDir  = $this->owner->primaryKey;
        $croppingFileResultPath = Yii::getAlias($this->basePath) . $this->baseDir
            . DIRECTORY_SEPARATOR . $croppingFileDir
            . DIRECTORY_SEPARATOR . $this->attribute . strrchr($this->_uploadedFile->name, '.');

        $this->_ensureDirectory(dirname($croppingFileResultPath));
        move_uploaded_file($this->_uploadedFile->tempName, $croppingFileResultPath);
    }

    private function _ensureDirectory($dir)
    {
        if (!is_dir($dir)) {
            mkdir($dir, $this->createDirectoryMode, true);
            if (!is_dir($dir)) {
                throw new InvalidArgumentException('Unable to create DIR ' . $dir);
            }
        }
    }

    public function delete()
    {
        $file = Yii::getAlias($this->basePath) . $this->baseDir
            . DIRECTORY_SEPARATOR . $this->owner->primaryKey
            . DIRECTORY_SEPARATOR . $this->attribute . '.' . $this->owner->oldAttributes[$this->attribute];
        if (is_file($file) && file_exists($file)) {
            unlink($file);
        }
    }

    public function init()
    {
        parent::init();
        if (!$this->basePath) $this->basePath = '@media/public';
    }
}