<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use xutl\inspinia\Box;
use xutl\inspinia\Toolbar;
use xutl\inspinia\Alert;

/* @var $this yii\web\View */
/* @var $model yuncms\article\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('article', 'Manage Article'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="widget-grid">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 article-view">
            <?= Alert::widget() ?>
            <?php Box::begin([
                'header' => Html::encode($this->title),
            ]); ?>
            <div class="row">
                <div class="col-sm-4 m-b-xs">
                    <?= Toolbar::widget(['items' => [
                        [
                            'label' => Yii::t('article', 'Manage Article'),
                            'url' => ['/article/article/index'],
                        ],
                        [
                            'label' => Yii::t('article', 'Create Article'),
                            'url' => ['/article/article/create'],
                        ],
                        [
                            'label' => Yii::t('article', 'Update Article'),
                            'url' => ['/article/article/update', 'id' => $model->id],
                            'options' => ['class' => 'btn btn-primary btn-sm']
                        ],
                        [
                            'label' => Yii::t('article', 'Delete Article'),
                            'url' => ['/article/article/delete', 'id' => $model->id],
                            'options' => [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]
                        ],
                    ]]); ?>
                </div>
                <div class="col-sm-8 m-b-xs">

                </div>
            </div>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'status',
                    'cover',
                    'description',
                    'content:html',
                    'comments',
                    'views',
                    'is_top:boolean',
                    'is_best:boolean',
                    'user.nickname',
                    'created_at:datetime',
                    'updated_at:datetime',
                    'published_at:datetime',
                ],
            ]) ?>
            <?php Box::end(); ?>
        </article>
    </div>
</section>