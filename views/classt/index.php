<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClasstSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Classts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classt-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Classt', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'class_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
