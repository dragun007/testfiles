<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\File $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="file-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'filename',
            'file_hash',
            'type',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
