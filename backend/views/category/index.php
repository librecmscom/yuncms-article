<?php
use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use xutl\inspinia\Box;
use xutl\inspinia\Toolbar;
use xutl\inspinia\Alert;
use yuncms\admin\grid\TreeGrid;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel yuncms\live\backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('article', 'Manage Category');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 category-index">
            <?= Alert::widget() ?>
            <?php Pjax::begin(); ?>
            <?php Box::begin([
                //'noPadding' => true,
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
                            'label' => Yii::t('article', 'Manage Category'),
                            'url' => ['index'],
                        ],
                        [
                            'label' => Yii::t('article', 'Create Category'),
                            'url' => ['create'],
                        ]
                    ]]); ?>
                </div>
                <div class="col-sm-8 m-b-xs">
                    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?= TreeGrid::widget([
                'dataProvider' => $dataProvider,
                'keyColumnName' => 'id',
                'parentColumnName' => 'parent',
                'parentRootValue' => null, //first parentId value
                'pluginOptions' => [
                    'initialState' => 'collapse',
                ],
                'columns' => [
                    'name',
                    'slug',
                    'slug',
                    'letter',
                    'frequency',
                    [
                        'class' => 'yuncms\admin\grid\PositionColumn',
                        'attribute' => 'sort'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => Yii::t('article', 'Operation'),
                        'template' => '{add} {view} {update} {delete}',
                        'buttons' => ['add' => function ($url, $model, $key) {
                            return Html::a('<span class="fa fa-plus"></span>',
                                Url::toRoute(['/article/category/create', 'parent' => $model->id]), [
                                    'title' => Yii::t('article', 'Add SubCategory'),
                                    'aria-label' => Yii::t('article', 'Add SubCategory'),
                                    'data-pjax' => '0',
                                ]);
                        }]
                    ],
                ],
            ]); ?>
            <?php Box::end(); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
