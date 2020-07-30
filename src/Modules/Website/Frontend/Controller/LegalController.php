<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Website\Frontend\Controller;
use XCrm\Modules\Website\Model\PageLegal;
use yii\web\NotFoundHttpException;

class LegalController extends \XCrm\Frontend\SiteController
{
    /**
     * @param  string|null $url
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($url = null)
    {
        $this->crumb('Юридическая информация', ['index']);

        if (null !== $url) {
            $document = PageLegal::findOne(['url' => $url]);
            if (!$document) throw new NotFoundHttpException();

            $this->meta($document);


            return $this->render('legal-document', [
                'document' => $document->localize()
            ]);
        }

        return $this->render('legal-list');
    }

    public function __construct($id, $module, $config = [])
    {
        $config['viewPath'] = $config['viewPath'] ?? $this->app->getModule('website')->viewPath;
        parent::__construct($id, $module, $config);
    }
}