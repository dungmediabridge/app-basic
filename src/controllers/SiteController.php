<?php

namespace app\basic\controllers;

use app\basic\forms\ContactForm;
use app\basic\models\UserModels;
use yii\captcha\CaptchaAction;
use yii\base\Model;
use yii\mail\MailerInterface;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;
use yii\web\filters\AccessControl;
use yii\web\filters\VerbFilter;

/**
 * SiteController is the controller Web Application Basic.
 **/
class SiteController extends Controller
{
    private $_User;

	/**
     * behaviors
     *
	 * @return array behaviors config.
	 **/
	public function behaviors()
	{
		return [
			'access' => [
				'__class' => AccessControl::class,
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'__class' => VerbFilter::class,
				'actions' => [
					'logout' => ['POST'],
				],
			],
		];
	}

	/**
     * actions
     *
	 * @return array actions config.
	 **/
	public function actions()
	{
		return [
			'error' => [
				'__class' => ErrorAction::class,
			],
			'captcha' => [
				'__class' => CaptchaAction::class,
				'fixedVerifyCode' => (YII_ENV === 'test') ? 'testme' : null,
			],
		];
	}

	/**
     * actionIndex
	 * Displays homepage.
	 *
	 * @return string
	 **/
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
     * actionAbout
	 * Displays about page.
	 *
	 * @return string
	 **/
	public function actionAbout()
	{
		return $this->render('about');
	}

	/**
     * actionContact
	 * Displays contact page.
	 *
	 * @return Response|string
	 **/
	public function actionContact()
	{
        $model = new ContactForm();

		if ($model->load($this->app->request->post()) && $model->validate()) {
            $this->sendContact($this->app->params['adminEmail'], $model);
			$this->app->session->setFlash('contactFormSubmitted');
			return $this->refresh();
		}

		return $this->render('contact', [
			'model' => $model,
		]);
	}

    /**
     * sendContactForm
	 * Sends an email to the specified email address using the information collected by this model.
     *
	 * @param string $email the target email address.
     * @param Model $model.
	 * @return bool whether the model passes validation.
	 **/
	public function sendContact(string $email, Model $model)
	{
		$this->app->mailer->compose()
		    ->setTo($email)
			->setFrom([$model->email => $model->name])
			->setSubject($model->subject)
			->setTextBody($model->body)
			->send();
    }    
}
