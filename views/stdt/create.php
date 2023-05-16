<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Stdt */

$this->title = 'Create Stdt';
$this->params['breadcrumbs'][] = ['label' => 'Stdts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stdt-create">

    <h1><?= Html::encode($this->title) ?></h1>

	<?php
		//正文上传
		$form = ActiveForm::begin(
			[
				'action' => [ 'stdt/doupload' ], 
				'method'=>'post', 
				//'type' => ActiveForm::TYPE_HORIZONTAL,
				'formConfig' => ['labelSpan' => 5, 'deviceSize' => ActiveForm::SIZE_MEDIUM],
				'options' => ['enctype' => 'multipart/form-data',
							  'style' => 'align-items: flex-start',	
							 ],															 									
		   ] );	
	?>

		<?= $form->field($model, 'std_name')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'std_age')->textInput() ?>

		<?= $form -> field( $model, 'data_list[]' )
				  ->hint( 
						"-&nbsp;文件上传提示信息"
					)
				  -> widget( FileInput::classname(), 
							[ 
								'options' => [ 
												//'accept' => 'text/pdf',
												'multiple' => true,
								],
								'pluginOptions' => [
									'showUpload' => true,
									'browseLabel' => '浏览',
									//'removeLabel' => '删除',
									//'mainClass' => 'input-group-sm',
									'maxFileSize' => 6000,
									'showUpload' => false,
									'showPreview' => false,
									'showRemove' => false,
									//'allowedFileExtensions' => [ 'pdf', 'doc', 'docx' ],
								],													
							]
				  )
				  ->label( "文件上传" ) 
		?>

		<div class="form-group">
			<?= Html::submitButton( Yii::t('app', '导入'), [ 'class' => 'btn btn-success' ] ) ?>
		</div>

    <?php ActiveForm::end(); ?>

</div>
