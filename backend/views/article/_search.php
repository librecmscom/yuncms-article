<?php

use yii\helpers\Html;
use xutl\inspinia\ActiveForm;

/* @var $this yii\web\View */
/* @var $model yuncms\article\backend\models\ArticleSearch */
/* @var $form ActiveForm */
?>

<div class="article-search  pull-right">

    <?php $form = ActiveForm::begin([
        'layout' => 'inline',
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', [
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('id'),
        ],
    ]) ?>

    <?= $form->field($model, 'title', [
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('title'),
        ],
    ]) ?>

    <?php //echo $form->field($model, 'status', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('status'),],]) ?>

    <?php //echo $form->field($model, 'cover', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('cover'),],]) ?>

    <?php //echo  $form->field($model, 'comments', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('comments'),],]) ?>

    <?php // echo $form->field($model, 'views') ?>

    <?php // echo $form->field($model, 'is_top') ?>

    <?php // echo $form->field($model, 'is_hot') ?>

    <?php // echo $form->field($model, 'is_best') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'published_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('article', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('article', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
