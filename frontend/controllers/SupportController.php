<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\article\frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yuncms\article\models\Article;
use yuncms\article\models\Support;

/**
 * Class SupportController
 * @package yuncms\article\frontend\controllers
 */
class SupportController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * 提交评论
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $source = $this->findModel(Yii::$app->request->post('model_id'));
        if (Support::find()->where(['model_id' => $source->id])->exists()) {
            return ['status' => 'supported'];
        }
        $model = new Support();
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            $source->updateCounters(['supports' => 1]);
            return ['status' => 'success'];
        }
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne(['id' => $id])) != null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist'));
        }
    }
}