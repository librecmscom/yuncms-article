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
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yuncms\article\models\Article;
use yuncms\article\models\ArticleComment;

/**
 * Class CommentController
 * @package yuncms\article\frontend\controllers
 */
class CommentController extends Controller
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
                        'actions' => ['index', 'create'],
                        'roles' => ['@', '?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['store'],
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($id)
    {
        $model = $this->findModel($id);
        $query = ArticleComment::find()->where([
            'model_id' => $model->id,
        ])->active()->with('user');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->renderPartial('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 提交评论
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {
        if (($source = $this->findModel(Yii::$app->request->post('model_id'))) != null) {
            $model = new ArticleComment();
            $model->scenario = ArticleComment::SCENARIO_CREATE;
            if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
                $source->updateCounters(['comments' => 1]);
                if ($model->to_user_id > 0) {
                    //notify(Yii::$app->user->id, $model->to_user_id, 'reply_comment', $source->title, $source->id, $model->content, 'article', $source->id);
                } else {
                    //notify(Yii::$app->user->id, $source->user_id, 'comment_article', $source->title, $source->id, $model->content, 'article', $source->id);
                }
                return $this->renderPartial('detail', ['model' => $model]);
            }
        }
        throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist'));
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
        }
        throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist'));
    }
}