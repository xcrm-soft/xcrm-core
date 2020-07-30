<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\Settings\BackOffice\Controller;
use XCrm\BackOffice\Controller\Controller;
use yii\data\ArrayDataProvider;

class SettingsDashboardController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function beforeAction($action)
    {
        $this->view->heading = 'Настройки';
        $this->view->headingIcon = 'settings';

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => new ArrayDataProvider([
                'models' => $this->view->getNavigation()->sections['settings']['modules'] ?? [],
                'pagination' => false
            ])
        ]);
    }
}