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
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yuncms\article\models\Collection;
use yuncms\article\models\Support;
use yuncms\tag\models\Tag;
use yuncms\article\jobs\UpdateViewsJob;
use yuncms\article\models\ArticleIndex;
use yuncms\article\models\Article;

/**
 * Class ArticleController
 * @package yuncms\article\controllers
 */
class ArticleController extends Controller
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
                    'delete' => ['post'],
                    'support' => ['post'],
                    'collection' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['@', '?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'support', 'delete', 'upload', 'collection'],
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'yuncms\ueditor\UEditorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Article::find()->active();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->applyOrder(Yii::$app->request->get('order', 'new'));
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * 搜索
     * @param string $q
     * @return string
     */
    public function actionSearch($q)
    {
        $query = ArticleIndex::find()->match($q);
        $dataProvider = new \yii\sphinx\ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('search', ['dataProvider' => $dataProvider, 'q' => $q]);
    }

    /**
     * 显示标签页
     *
     * @param string $tag 标签
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionTag($tag)
    {
        Url::remember('', 'actions-redirect');
        if (($model = Tag::findOne(['name' => $tag])) != null) {
            $query = Article::find()->anyTagValues($tag, 'name')->with('user');
            $query->andWhere(['>', Article::tableName() . '.status', 0]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            return $this->render('tag', ['model' => $model, 'dataProvider' => $dataProvider]);
        } else {
            throw new NotFoundHttpException (Yii::t('yii', 'The requested page does not exist.'));
        }
    }

    /**
     * 文章点赞
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionSupport()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $source = $this->findModel(Yii::$app->request->post('model_id'));
        if($source->isSupported){
            return ['status' => 'supported'];
        } else {
            $model = new Support();
            if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
                $source->updateCounters(['supports' => 1]);
            }
        }
        return ['status' => 'success'];
    }

    /**
     * 收藏文章
     * @return array
     */
    public function actionCollection()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $source = $this->findModel(Yii::$app->request->post('model_id'));
        if (($collect = Collection::find()->where(['model_id' => $source->id])->one()) != null) {
            $collect->delete();
            return ['status' => 'unCollect'];
        }
        $model = new Collection();
        $model->subject = $source->title;
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            $source->updateCounters(['collections' => 1]);
            return ['status' => 'collected'];
        }
    }

    /**
     * 查看文章
     * @param int $id
     * @param string $uuid
     * @return string|\yii\web\Response
     */
    public function actionView($id = null, $uuid = null)
    {
        if (!is_null($id)) {
            $model = $this->findModel($id);
        } else {
            $model = $this->findModelByUUID($uuid);
        }
        if ($model && ($model->isActive || $model->isAuthor)) {
            if (!$model->isAuthor) {
                Yii::$app->queue->push(new UpdateViewsJob(['id' => $model->id]));
            }
            return $this->render('view', [
                'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('success', Yii::t('article', 'Article does not exist.'));
            return $this->redirect(['index',]);
        }
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'uuid' => $model->uuid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param int $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->isAuthor) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('article', 'Article updated.'));
                return $this->redirect(['view', 'uuid' => $model->uuid]);
            }
            return $this->render('update', ['model' => $model]);
        }
        throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->isAuthor && $model->delete()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('article', 'Article has been deleted'));
            return $this->redirect(['index']);
        }
        throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
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

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $uuid
     *
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelByUUID($uuid)
    {
        if (($model = Article::findOne(['uuid' => $uuid])) != null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist'));
    }
}