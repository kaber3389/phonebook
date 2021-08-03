<?php

namespace app\controllers;

use Adldap\Models\Model;
use Adldap\Models\User;
use app\models\Contact;
use Yii;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSearch()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $this->layout = false;

        $contactQuery = Contact::find()
            ->andWhere(['is_active' => 1])
            ->orderBy('order');

        if ($query = strip_tags(Yii::$app->request->getQueryParam('query')))
        {
            $contactQuery->andFilterWhere([
                'or',
                ['like', 'department', $query],
                ['like', 'position', $query],
                ['like', 'full_name', $query],
                ['like', 'email', $query],
                ['like', 'phone', $query]
            ]);
        }

        $contactsByDepartment = [];
        foreach ($contactQuery->all() as $contact)
        {
            /** @var $contact Contact */
            $contactsByDepartment[strtoupper($contact->department)][] = $contact;
        }

        return $contactsByDepartment;
    }
}
