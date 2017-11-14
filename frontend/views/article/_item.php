<?php

/**
 * @var
 */
use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php if ($model->cover): ?>
    <div class="article-rank hidden-xs">
        <a href="<?= Url::to(['/article/article/view', 'uuid' => $model->uuid]); ?>" target="_blank">
            <img style="width: 200px;height:120px;" src="<?=$model->cover?>">
        </a>
    </div>
<?php endif; ?>
<div class="summary">
    <h2 class="title"><a href="<?= Url::to(['/article/article/view', 'uuid' => $model->uuid]); ?>"
                         target="_blank"><?= Html::encode($model->title) ?></a></h2>
    <p class="excerpt wordbreak"><?= mb_substr(strip_tags($model->content), 0, 100) ?></p>
    <ul class="author list-inline mt-20">
        <li class="pull-right" title="<?= $model->collections ?> <?=Yii::t('article', 'Collect');?>">
            <span class="glyphicon glyphicon-bookmark"></span> <?= $model->collections ?>
        </li>
        <li class="pull-right" title="<?= $model->supports ?> <?=Yii::t('article', 'Support');?>">
            <span class="glyphicon glyphicon-thumbs-up"></span> <?= $model->supports ?>
        </li>
        <li>
            <a href="<?=Url::to(['/user/space/view','id'=>$model->user_id])?>" target="_blank">
                <img class="avatar-20 mr-10 hidden-xs" src="<?=$model->user->getAvatar('small')?>"
                     alt="<?=$model->user->nickname?>"> <?=$model->user->nickname?>
            </a>
        </li>
        <li><?=Yii::t('article', 'Published in');?> <?= Yii::$app->formatter->asRelativeTime($model->created_at); ?></li>
        <li><?=Yii::t('article', 'Views');?> ( <?= $model->views ?> )</li>
    </ul>
</div>



