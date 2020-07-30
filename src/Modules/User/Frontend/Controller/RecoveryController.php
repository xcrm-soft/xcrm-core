<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\Frontend\Controller;
use Da\User\Model\Token;
use XCrm\Application\ApplicationAwareTrait;
use XCrm\Frontend\PageView;
use XCrm\Frontend\SiteApplication;
use XCrm\I18N\I18NTrait;
use XCrm\Modules\User\Service\RecoveryRequestService;
use XCrm\Modules\User\Service\RecoveryResetService;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class RecoveryController
 *
 * @property-read SiteApplication $app
 * @property-read PageView $view
 *
 * @package XCrm\Modules\User\Frontend\Controller
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class RecoveryController extends \Da\User\Controller\RecoveryController
{
    use ApplicationAwareTrait;
    use I18NTrait;

    public static function i18nCategory()
    {
        return 'xcrm/user/alerts';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['request', 'request-success', 'reset'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Вывоодит форму запроса ссылки для восстановления/сброса пароля
     * @return string|void
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     */
    public function actionRequest()
    {
        $this->view->service('user/recovery/request');

        if (!$this->module->allowPasswordRecovery) throw new NotFoundHttpException();
        $service = new RecoveryRequestService();

        if ($status = $service->run()) {
            if ($status['serviceStatus']) {
                $this->app->session->set('user.reset.status', $status);
                return $this->redirect(['request-success']);
            }
        } else $status = false;

        return $this->render('request', [
            'model'  => $service->getForm(),
            'module' => $this->module,
            'status' => $status,
        ]);
    }

    /**
     * Страница с сообщением об успешной отправке письма восстановления/сброса пароля
     */
    public function actionRequestSuccess()
    {
        $this->view->service('user/recovery/request-success');

        $status = $this->app->session->pop('user.reset.status', false);
        if (!is_array($status) || !$this->module->allowPasswordRecovery) {
            return $this->redirect(['request']);
        }
        return $this->render('request-success', $status);
    }

    public function actionReset($id, $code)
    {
        $this->view->service('user/recovery/reset');

        if (($token = $this->tokenQuery->whereUserId($id)->whereCode($code)->whereIsRecoveryType()->one()) && $this->module->allowPasswordRecovery) {
            /** @var Token $token */
            $service = new RecoveryResetService($token);
            if ($status = $service->run()) {
                if ($status['serviceStatus']) {
                    $this->app->session->setFlash('success', $this->t('Пароль успешно обновлен'));
                    return $this->redirect(['/user/login']);
                }
            } else $status->false;

            return $this->render('reset', [
                'model'  => $service->getForm(),
                'module' => $this->module,
                'status' => $status,
            ]);
        }
        throw new NotFoundHttpException();
    }
}