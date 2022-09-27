<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\StatisticFileSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Files Statistics';
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'count',
            'type',
        ],
    ]); ?>

</div>
