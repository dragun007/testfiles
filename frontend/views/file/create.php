<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\File $model */

$this->title = 'Create File';
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
