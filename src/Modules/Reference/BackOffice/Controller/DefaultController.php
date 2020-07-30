<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Reference\BackOffice\Controller;
use XCrm\BackOffice\Controller\Controller;
use XCrm\Modules\Reference\Model\ReferenceRegistry;
use XCrm\Modules\Settings\BackOffice\Module;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->headingIcon = 'reference';
        $this->view->heading = static::t('Обзор справочников');

        $this->crumb(Module::getTitle(), ['/settings/default/index'], false);
        $this->crumb('Обзор справочников', ['default/index']);
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionIndex($category = '/')
    {
        $category = $this->module->model('structure')::findOne(['url'=>$category]);
        if (!$category) {
            throw new NotFoundHttpException();
        }

        $this->crumb($category->name, null, false);
        $this->view->heading = $category->name;

        $categories = $category->children(1)->all();

        $refs = ReferenceRegistry::findAll(['parent_id' => $category->id]);

        return $this->render('index', [
            'category' => $category,
            'folders' => $categories,
            'refs' => $refs,
        ]);
    }
}