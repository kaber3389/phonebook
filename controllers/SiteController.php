<?php

namespace app\controllers;

use app\models\Contact;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
