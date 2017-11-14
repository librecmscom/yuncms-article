<?php
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \yuncms\tag\models\Tag[] $tags
 */
?>
<div class="widget-box">
    <h2 class="h4 widget-box-title"><?= Yii::t('article', 'Hot Topic') ?> <a href="<?=Url::to(['/topic/index'])?>" title="<?= Yii::t('article', 'More') ?>">»</a></h2>
    <ul class="taglist-inline multi">
        <?php
        foreach ($tags as $tag):?>
            <li class="tagPopup"><a href="<?= Url::to(['/article/article/tag', 'tag' => $tag->name]) ?>" class="tag" rel="tag"><?= Html::encode($tag->name) ?></a></li>
        <?php endforeach;?>
    </ul>
</div>
