<?php
namespace XCrm\Modules\I18N\Migration;
use yii\db\Migration;

/**
 * Class m200319_035515_create_reference_category
 */
class m200619_035515_create_reference_category extends Migration
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
            'name' => 'Интернационализация',
            'url' => 'i18n',
            'is_active' => 1,
            'parent_id' => $rc->id
        ]);

        if ($ic->smartSave()) {
            \XCrm\Media\FileUploadHelper::uploadCustom($ic, [
                'jacket_svg' => \Yii::getAlias('@XCrmResource') . '/I18N/icons/category.svg',
            ]);
        }
    }
}
