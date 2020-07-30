<?php
/**
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2019, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Media;
use XCrm\Application\ApplicationAwareTrait;
use yii\base\InvalidParamException;
use yii\bootstrap\InputWidget;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use kartik\file\FileInput;
use yii\helpers\Json;
use Yii;

class CutterWidget extends InputWidget
{
    use ApplicationAwareTrait;

    public $noImageUrl = null;
    /** @var array */
    public $imageOptions;

    /** @var array */
    public $jcropOptions = [];

    /**
     * @var array
     */
    private $defaultJcropOptions = [
        'dashed' => false,
        'zoomable' => false,
        'rotatable' => false
    ];

    /**
     * only call this method after a form closing and
     * when user hasn't used in the widget call the parameter $form
     * this adds to every form in the view the field validation.
     *
     * @param array $config
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    static function manualValidation($config = [])
    {
        if (!array_key_exists('model', $config) || !array_key_exists('attribute', $config)) {
            throw new InvalidParamException('Config array must have a model and attribute.');
        }

        $view = Yii::$app->getView();
        $field_id = Html::getInputId($config['model'], $config['attribute']);
        $view->registerJs('$("#' . $field_id . '").urlParser("launchValidation");');
    }

    /**
     * Renders the field.
     */
    public function run()
    {
        if (is_null($this->imageOptions)) {
            $this->imageOptions = [
                'alt' => 'Crop this image'
            ];
        }

        $this->imageOptions['id'] = Yii::$app->getSecurity()->generateRandomString(10);

        $inputField = Html::getInputId($this->model, $this->attribute, [
            'data-image_id' => $this->imageOptions['id']
        ]);

        $this->jcropOptions = array_merge($this->defaultJcropOptions, $this->jcropOptions);

        echo Html::beginTag('div', ['class' => 'uploadcrop']);


        echo Html::beginTag('div', [
            'id' => 'preview-pane',
            'style' => ($this->model->{$this->attribute} || $this->noImageUrl) ? 'display:block' : 'display:none'
        ]);
        echo Html::beginTag('div', ['class' => 'preview-container']);

        if ($this->model->{$this->attribute}) {
            $src = $this->model->jacketUrl;
        } else {
            $src = $this->noImageUrl;
        }

        $previewOptions = [
            'class' => 'preview_image'
        ];
        echo Html::img($src, $previewOptions);
        echo Html::endTag('div');
        echo Html::endTag('div');

        echo FileInput::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'pluginOptions' => [
                'showPreview' => false,
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'theme' => 'fa',
            ]
        ]); // ($this->model, $this->attribute);

        Modal::begin([
            'header' => '<h3>Выберите область изображения</h3>',
            'closeButton' => [],
            'footer' => Html::button('Отменить', [
                    'id' => $this->imageOptions['id'] . '_button_cancel', 'class' => 'btn btn-default'
                ]) . Html::button('Обрезать и применить', [
                    'id' => $this->imageOptions['id'] . '_button_accept', 'class' => 'btn btn-success'
                ]),
            'size' => Modal::SIZE_LARGE,
        ]);

        echo Html::beginTag('div', ['id' => 'image-source', 'class' => 'col-centered']);
        echo Html::img('', $this->imageOptions);
        echo Html::endTag('div');

        echo html::hiddenInput($this->attribute . '-cropping[x]', '', ['id' => $inputField . '-x']);
        echo html::hiddenInput($this->attribute . '-cropping[width]', '', ['id' => $inputField . '-width']);
        echo html::hiddenInput($this->attribute . '-cropping[y]', '', ['id' => $inputField . '-y']);
        echo html::hiddenInput($this->attribute . '-cropping[height]', '', ['id' => $inputField . '-height']);

        Modal::end();

        echo Html::endTag('div');

        $view = $this->getView();

        CutterAsset::register($view);

        $jcropOptions = [
            'inputField' => $inputField,
            'jcropOptions' => $this->jcropOptions
        ];

        $jcropOptions = Json::encode($jcropOptions);

        $view->registerJs('jQuery("#' . $inputField . '").cutter(' . $jcropOptions . ');');
    }
}