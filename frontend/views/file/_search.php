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
        'action' => ['file/statistics'],
        'method' => 'get',
    ]); ?>
    <div class="form-group">
        <p>Statistic between days</p>
        <?= $form->errorSummary($model) ?>
        <?php echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'from_date',
            'language' => 'ru',
            'dateFormat' => 'dd-MM-yyyy',
        ]); ?>

        <?php echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'to_date',
            'language' => 'ru',
            'dateFormat' => 'dd-MM-yyyy',
        ]); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
