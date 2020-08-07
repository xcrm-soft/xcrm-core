<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Frontend;
use XCrm\Application\Web\Controller;
use XCrm\Data\ActiveRecordConfigurable;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    /** @var ActiveRecordConfigurable */
    public $rootModelClass = null;
    public $deactivatedPageException = true;



    /**
     * @param  string $url
     * @param  array $params
     * @return string
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function runActionByUrl($url, $params = [])
    {
        if (!$this->rootModelClass) {
            throw new InvalidConfigException('Root model class should be set');
        }

        if ($found = $this->rootModelClass::findByUrl($url)) {
            $url = $this->resolvePath($found, $url);
            if ('/' === $url || empty($url)) $url = null;
            return $this->main($found, $url, $params);
        } else {
            throw new NotFoundHttpException();
        }
    }

    protected function resolvePath($model, $url = null)
    {
        if (null === $url) return null;

        $usedUrl = '';

        if ($this->deactivatedPageException) {
            if (!$model->is_active) throw new NotFoundHttpException();
        }

        if ($path = $model->getFullPath()) {
            foreach ($path as $item) {
                if ($this->deactivatedPageException) {
                    if (!$item->is_active) throw new NotFoundHttpException();
                }
                $usedUrl = str_replace('//', '/', $usedUrl . '/' . $item->url);
                $this->crumb($item->localizationModel->name, str_replace('//', '/', $usedUrl), false);
            }
            $usedUrl = str_replace('//', '/', $usedUrl . '/' . $model->url);
            $this->crumb($model->localizationModel->name, str_replace('//', '/', $usedUrl), false);
        }

        $this->meta($model);

        if ($url === $usedUrl) return null;
    }

    public function main($model, $url = null, $params = [])
    {
        if (!empty($url)) throw new NotFoundHttpException();
        $this->view->params['backgroundPage'] = $model;
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function meta($model)
    {
        $this->layout = $model->layout ?? $this->app->pageManager->defaultLayout;
        $this->app->view->meta($model);
    }
}