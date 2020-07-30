<?php
namespace XCrm\Modules\I18N\Migration;
use XCrm\Database\Migration\MigrationOfReferenceBook;
use XCrm\Modules\I18N\Model\Ref\RefLanguages;
use XCrm\Modules\I18N\Model\Ref\RefCategory;

/**
 * Class m200319_065501_create_ref_languages
 */
class m200619_065501_create_ref_languages extends MigrationOfReferenceBook
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createReferenceBook('refLanguage', RefLanguages::class, [
            'id',
            'merge_id',
            'uuid',
            'key_name',
            'name',
            'is_primary',
            'is_secondary',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by'
        ], 'i18n', [
            'upload' => ['jacket_svg' => \Yii::getAlias('@XCrmResource') . '/I18N/icons/language.svg'],
            'info' => 'Коды языков интернационализации, на которые будут переведены интерфейсы и содержание приложений'
        ]);

        $this->createReferenceBook('refCategory', RefCategory::class, [
            'id',
            'merge_id',
            'uuid',
            'key_name',
            'name',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by'
        ], 'i18n', [
            'upload' => ['jacket_svg' => \Yii::getAlias('@XCrmResource') . '/I18N/icons/translation.svg'],
            'info' => 'Имена категорий переводимых сообщений интерфейсов для присвоения им текстовых меток на языках интернационализации'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropReferenceBook(RefLanguages::class);
        $this->dropReferenceBook(RefCategory::class);
    }
}
