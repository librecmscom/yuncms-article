<?php

use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use xutl\inspinia\Box;
use xutl\inspinia\Toolbar;
use xutl\inspinia\Alert;

/* @var $this yii\web\View */
/* @var yuncms\article\backend\models\ArticleSearch $searchModel  */
/* @var yii\data\ActiveDataProvider $dataProvider  */

$this->title = Yii::t('article', 'Manage Article');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
jQuery(\"#batch_deletion\").on(\"click\", function () {
    yii.confirm('" . Yii::t('app', 'Are you sure you want to delete this item?') . "',function(){
        var ids = jQuery('#gridview').yiiGridView(\"getSelectedRows\");
        jQuery.post(\"batch-delete\",{ids:ids});
    });
});
", View::POS_LOAD);

?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 article-index">
            <?= Alert::widget() ?>
            <?php Pjax::begin(); ?>
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
                            'label' => Yii::t('article', 'Manage Category'),
                            'url' => ['/article/category/index'],
                        ],
                        [
                            'label' => Yii::t('article', 'Create Article'),
                            'url' => ['/article/article/create'],
                        ],
                        [
                            'options' => ['id' => 'batch_deletion', 'class' => 'btn btn-sm btn-danger'],
                            'label' => Yii::t('article', 'Batch Deletion'),
                            'url' => 'javascript:void(0);',
                        ]
                    ]]); ?>
                </div>
                <div class="col-sm-8 m-b-xs">
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <?= GridView::widget([
                'options' => ['id' => 'gridview'],
                'layout' => "{items}\n{summary}\n{pager}",
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        "name" => "id",
                    ],
                    // ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'title',
                    //'cover',
                    'comments',
                    'supports',
                    'collections',
                    'views',
                    'is_top:boolean',
                    'is_best:boolean',
                    // 'description',
                    'user.nickname',
                    [
                        'header' => Yii::t('article', 'Status'),
                        'value' => function ($model) {
                            if (!$model->isActive) {
                                return Html::a(Yii::t('article', 'Pending'), ['audit', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-success btn-block',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('article', 'Are you sure you want to Accepted this article?'),
                                ]);
                            } else {
                                return Html::tag('span', Yii::t('article', 'Accepted'), ['class' => 'badge badge-primary']);
                            }
                        },
                        'format' => 'raw',
                    ],
                    'created_at:datetime',
                    // 'updated_at:datetime',
                    ['class' => 'yii\grid\ActionColumn', 'header' => Yii::t('article', 'Operation'),],
                ],
            ]); ?>
            <?php Box::end(); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
