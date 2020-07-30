<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\BackOffice\helpers;
use Da\User\Model\Assignment;
use Da\User\Service\UpdateAuthAssignmentsService;
use Da\User\Traits\AuthManagerAwareTrait;
use Da\User\Traits\ContainerAwareTrait;
use XCrm\Application\ApplicationAwareTrait;
use XCrm\Modules\User\Model\User;
use XCrm\Modules\User\Module;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use Yii;

class AssignmentsHelper extends BaseObject
{
    use ApplicationAwareTrait;
    use AuthManagerAwareTrait;
    use ContainerAwareTrait;

    /**
     * @var User
     */
    public $user;

    public $items;

    public $model;

    public function init()
    {
        $this->model = $this->make(Assignment::class, [], ['user_id' => $this->user->id]);
        parent::init();

        if ($this->model->load($this->app->request->post())) {
            $this->make(UpdateAuthAssignmentsService::class, [$this->model])->run();
        }
        $this->items[Yii::t('usuario', 'Roles')] = $this->getAvailableItems(Item::TYPE_ROLE);
        if (!$this->getUserModule()->restrictUserPermissionAssignment) {
            $this->items[Yii::t('usuario', 'Permissions')] = $this->getAvailableItems(Item::TYPE_PERMISSION);
        }
    }

    /**
     * @return Module|mixed
     */
    public function getUserModule()
    {
        Yii::$app->getModule('user');
    }

    /**
     * Returns available auth items to be attached to the user.
     *
     * @param int|null type of auth items or null to return all
     * @param null|mixed $type
     *
     * @return array
     */
    protected function getAvailableItems($type = null)
    {
        return ArrayHelper::map(
            $this->getAuthManager()->getItems($type),
            'name',
            function ($item) {
                return empty($item->description)
                    ? $item->name
                    : $item->name . ' (' . $item->description . ')';
            }
        );
    }
}