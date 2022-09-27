<?php

use common\models\File;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\File $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="file-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'upload')->fileInput() ?>

    <?= $form->field($model, 'type')->dropDownList(FILE::getFilesTypes()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
