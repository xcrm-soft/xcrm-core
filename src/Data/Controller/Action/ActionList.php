<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Data\Controller\Action;
use XCrm\Data\Controller\Action;
use XCrm\Data\Model\ActiveSearch;
use yii\data\ActiveDataProvider;

/**
 * Выводит список записей модели по заданным параметрам
 *
 * @package XCrm\Data\Controller\Action
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class ActionList extends Action
{
    public $itemView = '_list-item';

    /**
     * Возвращает модель поиска данных или null, если имя коасса модели поиска не указано.
     * Приоритетным классом для дпействия считается указанный в параметрах контроллера.
     * @return mixed|string|null
     */
    public function getSearchModel()
    {
        return $this->controller->modelSearchClass
            ?? $this->modelClass::hierarchy()['search']
            ?? null;
    }

    protected function getVariables()
    {
        $filterModel = null;
        if($searchModel = $this->getSearchModel()) {
            /** @var ActiveSearch $filterModel */
            $filterModel = new $searchModel;
            $dataProvider = $filterModel->search($this->searchParams ?? \Yii::$app->request->queryParams);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => $this->modelClass::getFindAllQuery()
            ]);
        }

        return [
            'dataProvider' => $dataProvider,
            'filterModel' => $filterModel,
            'itemView' => $this->itemView
        ];
    }
}