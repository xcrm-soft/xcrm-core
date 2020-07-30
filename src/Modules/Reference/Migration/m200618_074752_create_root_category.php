<?php
namespace XCrm\Modules\Reference\Migration;
use XCrm\Modules\Reference\Model\ReferenceStructure;
use XCrm\Media\FileUploadHelper;
use yii\db\Migration;
use Yii;

/**
 * Class m200618_074752_create_root_category
 */
class m200618_074752_create_root_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $rc = new ReferenceStructure([
            'name' => 'Все справочники',
            'url' => '/',
            'is_active' => 1,

        ]);

        if ($rc->makeRoot()) {
            FileUploadHelper::uploadCustom($rc, [
                'jacket_svg' => Yii::getAlias('@XCrmResource') . '/Reference/icons/category.svg',
            ]);
        }
    }
}
