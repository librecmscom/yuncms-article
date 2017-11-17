<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yuncms\article\models\Article;
use yuncms\article\models\ArticleCategory;
use yuncms\ueditor\UEditor;
use xutl\inspinia\ActiveForm;
use xutl\fileupload\SingleUpload;

/* @var \yii\web\View $this */
/* @var yuncms\article\models\Article $model */
/* @var ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>


<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'sub_title')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(ArticleCategory::getDropDownList(), 'id', 'name')); ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'status')->inline(true)->radioList($model->getStatusList()) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'cover')->widget(SingleUpload::className(), [
    'onlyImage' => true,
]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'is_top')->inline(true)->radioList([true => Yii::t('yii', 'Yes'), false => Yii::t('yii', 'No')]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'is_best')->inline(true)->radioList([true => Yii::t('yii', 'Yes'), false => Yii::t('yii', 'No')]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'description')->textInput(['maxlength' => true, 'rows' => 5]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'content')->widget(UEditor::className(), [

]) ?>

<div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>


<?php ActiveForm::end(); ?>

