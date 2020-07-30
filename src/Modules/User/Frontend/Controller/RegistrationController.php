<?php
/**
 * This file is a part of XCRM Core Package
 *
 * @link      https://webwizardry.ru/projects/xcrm
 * @license   https://webwizardry.ru/projects/xcrm/license/
 * @copyright Copyright (c) 2020, Web Wizardry (http://webwizardry.ru)
 */

namespace XCrm\Modules\User\Frontend\Controller;
use XCrm\Application\ControllerTrait;
use XCrm\Frontend\PageView;
use XCrm\Modules\User\Model\User;
use XCrm\Modules\User\Service\ConfirmationResendService;
use XCrm\Modules\User\Service\ConfirmationService;
use XCrm\Modules\User\Service\RegistrationService;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\base\InvalidConfigException;
use yii\db\Exception;

/**
 * Class RegistrationController
 *
 * @property PageView $view
 *
 * @package XCrm\Modules\User\Frontend\Controller
 * @author Alexey Volkov <webwizardry@hotmail.com>
 */
class RegistrationController extends \Da\User\Controller\RegistrationController
{
    use ControllerTrait;

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
                        'actions' => ['register', 'connect'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['confirm', 'resend', 'resend-success'],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Выврлит форму регистрации учетной записи и обрабатывает полученные данные
     * @return string
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function actionRegister()
    {
        $this->view->service('user/registration');
        $this->crumb('Регистрация');

        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        $service = new RegistrationService();
        if ($status = $service->run()) {
            if ($status['serviceStatus']) {
                if ($this->module->enableEmailConfirmation) {
                    $this->view->service('user/registration-confirm');
                    return $this->render('@app/views/_mod-pages/service', [
                        'user'   => $service->getUser(),
                        'module' => $this->module,
                        'content' => $this->renderPartial('register-success', ['user' => $service->user])
                    ]);
                } else {
                    return $this->redirect(['/' . $this->module->id]);
                }
            }
        } else $status = false;

        return $this->render('register', [
            'model'  => $service->getForm(),
            'module' => $this->module,
            'status' => $status
        ]);
    }


    /**
     * Активация аккаунта по одноразовой ссылке из письма
     * @param $id
     * @param $code
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionConfirm($id, $code)
    {
        $this->crumb('Подтверждение учетной записи');
        $service = new ConfirmationService($id, $code);


        if (($status = $service->run()) && $status['serviceStatus'] && $service->user) {
            $this->app->user->login($service->user, $this->module->rememberLoginLifespan);
            $this->view->service('user/registration-confirm-success');
            $viewName = 'confirm-success';
        } else {
            $status = false;
            $this->view->service('user/registration-confirm-error');
            $viewName = 'confirm-error';
        }

        return $this->render('@app/views/_mod-pages/service', [
            'user' => $service->user,
            'status' => $status,
            'shortContentType' => $status ? 'success' : 'danger',
            'content' => $this->renderPartial($viewName, ['user' => $service->user])
        ]);
    }

    public function actionResend()
    {
        if (!$this->module->enableEmailConfirmation) {
            throw new NotFoundHttpException();
        }

        $service = new ConfirmationResendService();

        if ($status = $service->run()) {
            if ($status['serviceStatus']) {
                $this->app->session->set('user.resend.status', $status);
                return $this->redirect(['resend-success']);
            }
        }

        return $this->render('resend', [
            'model'  => $service->getForm(),
            'module' => $this->module,
            'status' => $status
        ]);
    }

    public function actionResendSuccess()
    {
        $status = $this->app->session->pop('user.resend.status', false);
        if (!is_array($status) || !$this->module->enableEmailConfirmation) {
            return $this->redirect('/');
        }
        return $this->render('resend-success', $status);
    }
}