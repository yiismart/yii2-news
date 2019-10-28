<?php

use yii\helpers\Html;
use yii\helpers\Url;
use dkhlystov\uploadimage\widgets\UploadImage;
use smart\imperavi\Imperavi;
use smart\widgets\ActiveForm;
use smart\widgets\Datepicker;
use smart\news\backend\assets\NewsAsset;

NewsAsset::register($this);

?>
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'image')->widget(UploadImage::className(), [
        'maxImageWidth' => 300,
        'maxImageHeight' => 300,
    ]) ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'alias', ['append' => [
        ['button' => '<i class="fas fa-sync"></i>', 'options' => ['id' => 'make-alias', 'data-url' => Url::toRoute(['make-alias'])]],
    ]]) ?>

    <?= $form->field($model, 'date')->widget(Datepicker::className(), [
        'format' => $model::FORMAT_DATE,
        'options' => ['class' => 'form-control'],
    ]) ?>

    <?= $form->field($model, 'time')->textInput(['placeholder' => '00:00']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'text')->widget(Imperavi::className()) ?>

    <div class="form-group form-buttons row">
        <div class="col-sm-10 offset-sm-2">
            <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('cms', 'Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
