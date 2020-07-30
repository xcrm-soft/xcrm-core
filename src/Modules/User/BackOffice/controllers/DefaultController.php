<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\BackOffice\controllers;
use Da\User\Controller\AdminController;
use XCrm\Modules\User\BackOffice\helpers\AssignmentsHelper;
use XCrm\Modules\User\Model\User;
use Da\User\Query\UserQuery;
use yii\base\Module;
use Yii;
use yii\web\NotFoundHttpException;

class DefaultController extends AdminController
{
    public function actionAssignments($id)
    {
        /** @var User $user */
        $user = $this->userQuery->where(['id' => $id])->one();
        if (!$user) throw new NotFoundHttpException();

        $helper = new AssignmentsHelper(['user' => $user]);

        return $this->render(
            '_assignments',
            [
                'user' => $user,
                'model' => $helper->model,
                'availableItems' => $helper->items,
            ]
        );
    }

    public function __construct($id, Module $module, UserQuery $userQuery, array $config = [])
    {
        $config['viewPath'] = $config['viewPath'] ?? dirname(__DIR__) . '/views/default';
        parent::__construct($id, $module, $userQuery, $config);
    }
}