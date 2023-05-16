<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Classt */

$this->title = 'Create Classt';
$this->params['breadcrumbs'][] = ['label' => 'Classts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
