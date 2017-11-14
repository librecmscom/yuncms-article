<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use xutl\inspinia\ActiveForm;
use yuncms\article\models\Category;

/* @var \yii\web\View $this */
/* @var yuncms\article\models\Category $model */
/* @var ActiveForm $form */

$categories = Category::find()->select(['id', 'name'])->orderBy(['sort' => SORT_ASC])->asArray()->all();

?>
<?php $form = ActiveForm::begin([
    'layout' => 'horizontal'
]); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>

<?= $form->field($model, 'parent')->dropDownList(ArrayHelper::map($categories, 'id', 'name'), [
    'prompt' => Yii::t('article', 'Please select')
]); ?>

<div class="hr-line-dashed"></div>

<?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>

<?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>

<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>

<?= $form->field($model, 'letter')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>

<?= $form->field($model, 'sort')->input('number') ?>
<div class="hr-line-dashed"></div>


<div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('article', 'Create') : Yii::t('article', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

