<?php

use common\models\File;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\FileSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \common\models\StatisticFileSearch $statisticFileSearch */
/** @var \common\models\StatisticByDateFileSearch $statisticByDateFileSearch */
$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Document', ['file/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row">
        <div class="col-6">
            <?php echo $this->render('../file/_search', ['model' => $statisticFileSearch]); ?>
        </div>
        <div class="col-6">
            <?php echo $this->render('../file/_searchDateFile', ['model' => $statisticByDateFileSearch]); ?>
        </div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            [
                'attribute' => 'filename',
                'value' => function (File $data) {
                    return Html::a(Html::encode($data->filename), Url::to(['file/get', 'file_hash' => $data->file_hash]));
                },
                'format' => 'raw',
            ],
            'type',
        ],
    ]); ?>

</div>
