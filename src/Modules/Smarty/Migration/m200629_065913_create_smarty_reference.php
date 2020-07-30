<?php
namespace XCrm\Modules\Smarty\Migration;
use XCrm\Database\Migration\MigrationOfReferenceBook;
use XCrm\Modules\Smarty\Model\Ref\RefSmartyCategory;
use XCrm\Modules\Smarty\Model\Ref\RefSmartyGroup;
use yii\base\Exception;

/**
 * Class m200629_065913_create_smarty_reference
 */
class m200629_065913_create_smarty_reference extends MigrationOfReferenceBook
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $rc = \XCrm\Modules\Reference\Model\ReferenceStructure::find()
            ->orderBy(['tk_left'=>SORT_ASC])
            ->limit(1)
            ->one();

        $ic = new \XCrm\Modules\Reference\Model\ReferenceStructure([
            'name' => 'Smarty',
            'url' => 'smarty',
            'is_active' => 1,
            'parent_id' => $rc->id
        ]);

        if ($ic->smartSave()) {

            \XCrm\Media\FileUploadHelper::uploadCustom($ic, [
                'jacket_svg' => __DIR__ . '/Resource/smarty.svg',
            ]);

            $this->createReferenceBook('refSmartyCategory', RefSmartyCategory::class, [
                'id',
                'key_name',
                'name',
                'jacket_svg',
                'is_system',
                'created_at',
                'created_by',
                'updated_at',
                'updated_by'
            ], 'smarty', [
                'upload'  => ['jacket_svg' => __DIR__ . '/Resource/books.svg'],
            ]);

            $this->createReferenceBook('refSmartyGroup', RefSmartyGroup::class, [
                'id',
                'key_name',
                'name',
                'jacket_svg',
                'is_system',
                'created_at',
                'created_by',
                'updated_at',
                'updated_by'
            ], 'smarty', [
                'upload'  => ['jacket_svg' => __DIR__ . '/Resource/books.svg'],
            ]);

        } else {
            throw new Exception('Unable to create reference category');
        }


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropReferenceBook(RefSmartyCategory::class);
        $this->dropReferenceBook(RefSmartyGroup::class);
    }
}
