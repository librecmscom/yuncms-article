<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model yuncms\article\models\Article */

$this->title = Yii::t('article', 'Create Article');
$this->params['breadcrumbs'][] = ['label' => Yii::t('article', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
