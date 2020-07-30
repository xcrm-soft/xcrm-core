<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Database\Migration;
use XCrm\Database\Migration;
use yii\base\Exception;
use yii\rbac\DbManager;
use yii\rbac\ManagerInterface;
use yii\rbac\Rule;
use Yii;

/**
 * Миграция для быстрого добавления разрешений и правил в RBAC
 *
 * @property-read DbManager $authManager
 *
 * @package XCrm\Database\Migration
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class MigrationOfRbac extends Migration
{
    protected $permissions = [];

    /**
     * @return bool|void
     * @throws \Exception
     */
    public function safeUp()
    {
        foreach ($this->permissions as $config) {

            if (isset($config['rule'])) {
                $ruleClassName = $config['rule'];
                $rule = new $ruleClassName;
                $this->authManager->add($rule);
            } else {
                $rule = null;
            }
            $permission = $this->authManager->createPermission($config['name']);
            $permission->description = $config['description'] ?? $config['name'];
            if ($rule) {
                if ($rule instanceof Rule) {
                    $permission->ruleName = $rule->name;
                } else {
                    throw new Exception('Wrong rule class');
                }
            }
            $this->authManager->add($permission);
        }
    }

    public function safeDown()
    {
        foreach ($this->permissions as $config) {
            if (isset($config['rule'])) {
                $ruleClassName = $config['rule'];
                $rule = new $ruleClassName;
                if ($obj = $this->authManager->getRule($rule->name)) $this->authManager->remove($obj);
            }

            if ($obj = $this->authManager->getPermission($config['name'])) {
                $this->authManager->remove($obj);
            }
        }
    }

    /**
     * @return ManagerInterface
     * @throws Exception
     */
    public function getAuthManager()
    {
        $manager = Yii::$app->authManager;
        if (!$manager instanceof DbManager) throw new Exception('Configure authManager to use database');
        return $manager;
    }
}