<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Classt */

$this->title = 'Update Classt: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Classts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="classt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
