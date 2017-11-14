<?php

/**
 * @var
 */
use yii\helpers\Url;
use yii\helpers\Html;

?>


<div class="summary">
    <h2 class="title"><a href="<?= Url::to(['/article/article/view', 'id' => $model->id]); ?>"
                         target="_blank"><?= Html::encode($model->title) ?></a></h2>
    <p class="excerpt wordbreak"><?= mb_substr(strip_tags($model->content), 0, 100) ?></p>
    <ul class="author list-inline mt-20">

        <li><?=Yii::t('article', 'Published in');?> <?= Yii::$app->formatter->asRelativeTime($model->created_at); ?></li>

    </ul>
</div>



