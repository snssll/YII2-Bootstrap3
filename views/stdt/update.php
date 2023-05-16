<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stdt */

$this->title = 'Update Stdt: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stdts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stdt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
