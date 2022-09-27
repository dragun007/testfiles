<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\FileSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="file-search">

    <?php $form = ActiveForm::begin([
        'action' => ['file/statistics-by-date'],
        'method' => 'get',
    ]); ?>
    <div class="form-group">
        <p>Statistic in period</p>
        <?= $form->errorSummary($model) ?>
        <div class="row">
            <label>day</label>
            <?php echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'day',
                'language' => 'ru',
                'dateFormat' => 'dd-MM-yyyy',
            ]); ?>
        </div>

        <div class="row">
            <label>month</label>
            <?php echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'month',
                'language' => 'ru',
                'dateFormat' => 'MM-yyyy',
            ]); ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
