<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Controller;
use XCrm\Application\Web\Controller;
use XCrm\Application\Web\View;
use XCrm\Data\ActiveRecord;
use XCrm\Data\Controller\Action\ActionFormCreate;
use XCrm\Data\Controller\Action\ActionFormUpdate;
use XCrm\Data\Controller\Action\ActionGrid;
use XCrm\Data\Controller\Action\ActionList;
use XCrm\Data\Controller\Action\ActionMove;
use XCrm\Data\Controller\Action\ActionRemove;
use XCrm\Data\Controller\Action\ActionTranslate;
use XCrm\Data\Controller\Action\ActionView;
use XCrm\Data\Helper\StringHelper;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class CrudController
 *
 * @property-read View|\XCrm\ControlPanel\View $view
 *
 * @package XCrm\Data\Controller
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class CrudController extends Controller
{
    /**
     * @var null|string|ActiveRecord имя класса модели, с которой работает данный контроллер
     *    по конфигурациям модели строится набор действий, доступных контроллеру и фильтр
     *    разрешений пользователя для выполнения этих действий
     */
    public $modelClass = null;
    /**
     * @var null|string имя класса модли для поиска
     */
    public $modelSearchClass = null;


    public function behaviors()
    {
        return [
            [
                'class' => AccessControl::class,
                'rules' => [
                    ['allow' => true, 'roles' => ['@']]
                ],
            ]
        ];
    }

    /**
     * Собирает массив разрешенных действий на основе разрешений основной модели
     * @return array
     */
    public function actions()
    {
        $actions = [];

        if ($this->modelClass::allowsIndex()) {
            $actions['index'] = [
                'class' => ActionGrid::class,
            ];
        }

        if ($this->modelClass::allowsView()) {
            $actions['view'] = ['class' => ActionView::class];
        }

        if ($this->modelClass::allowsCreate()) {
            $actions['create'] = ['class' => ActionFormCreate::class];
        }

        if ($this->modelClass::allowsUpdate()) {
            $actions['update'] = ['class' => ActionFormUpdate::class];
            if ($this->modelClass::isSortable()) {
                $actions['move-left'] = ['class' => ActionMove::class, 'direction' => ActionMove::MOVE_LEFT];
                $actions['move-right'] = ['class' => ActionMove::class, 'direction' => ActionMove::MOVE_RIGHT];
            }
        }

        if ($this->modelClass::allowsDelete()) {
            $actions['delete'] = ['class' => ActionRemove::class];
        }

        if ($this->modelClass::hasLocalizations()) {
            $actions['translate'] = ['class' => ActionTranslate::class];
        }

        return $actions;
    }

    public function init()
    {
        parent::init();
        if (false !== strpos($this->modelClass, '.')) {
            list($mod, $id) = StringHelper::leftSplit($this->modelClass, '.');
            $this->modelClass = $this->app->getModule($mod)->model($id);
        }
        $this->view->heading = $this->module::getTitle();
        $this->view->headingIcon = $this->module::getNavigation()['icon'] ?? null;
    }

    public function addModelCrumbs($model)
    {

    }

    public function addModelTabs($model)
    {

    }

    public function findModel($condition)
    {
        if ($model = $this->modelClass::findOne($condition)) {
            $this->addModelCrumbs($model);
            $this->addModelTabs($model);
            return $model;
        }
        throw new NotFoundHttpException();
    }

    public function createModel($config = [])
    {
        $modelClass = $this->modelClass;
        if ($model = new $modelClass($config)) {
            // $this->addModelCrumbs($model);
            $this->addModelTabs($model);
            return $model;
        }
        throw new NotFoundHttpException();
    }

    public function __construct($id, $module, $config = [])
    {
        $config['viewPath'] = $config['viewPath'] ?? '@app/views/_mod-content';
        parent::__construct($id, $module, $config);
    }
}