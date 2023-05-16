<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StdtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stdts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stdt-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<div class="row">

		<div class="col-md-8">

			<!--搜索表单-->
			<?php $form = ActiveForm::begin([  
				'action' => ['index'],  
				'method' => 'get', 
				'type' => ActiveForm::TYPE_HORIZONTAL,

			]); ?>  
		
			<div class="row">

				<div class="col-sm-5">
					<?= $form->field($searchModel, 'stdname')->textInput( [ 'autofocus' => false, 
																			'placeholder' => '请输入学生姓名 ...',
																			"value" => !empty( $_GET["StdtSearch"]["stdname"] ) ? 
																							$_GET["StdtSearch"]["stdname"] : "",
																		  ] ) -> label( false ) ?>
				</div>
					
				<div class="col-sm-5">
					<?= $form->field($searchModel, 'classname')->widget(Select2::classname(), [
								'data' => ArrayHelper::map( $c_list, 'id', 'class_name' ),
								'size' => Select2::MEDIUM,
								'options' => [
										'placeholder' => '请选择班级 ...',
										'class'=>'form-control', 								
										'style'=>'  ',
										"value" => !empty( $_GET["StdtSearch"]["classname"] ) ? $_GET["StdtSearch"]["classname"] : "",
								],
								'pluginOptions' => [
									'allowClear' => true
								],
					]) -> label( false ); ?>
				</div>

				<div class="col-sm-1">
					<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
				</div>
			</div>

			<?php ActiveForm::end(); ?>

		</div>
	</div>

    <p>
        <?= Html::a('Create Stdt', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php
// 数据库依赖
$dependency_1_1 = new \yii\caching\DbDependency(
	[ 
		'sql' => 'SELECT max( std_t.update_date ) FROM std_t',
	] );

$dependency_1_2 = new \yii\caching\DbDependency(
	[ 
		'sql' => 'SELECT count( * ) FROM std_file',
	] );

if( 
	$this -> beginCache( 'cache_1_stdt_index_' . ( isset( $_GET['page'] ) ? $_GET['page'] : 0 ), 
								[ 'dependency' => new \yii\caching\ChainedDependency( [ 
														'dependOnAll'=>true,
														'dependencies' => [ $dependency_1_1, $dependency_1_2 ]
													] ), 
								  'duration' => 3600 
								] 
				) 
) {
?>

    <?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'tableOptions' => [ 'class' => 'table table-bordered table-hover', "id"=>"example2", 'style' => 'font-size:16px;  ' ],
		'caption' => "",
		'showHeader' => true,
		"filterPosition" => GridView::FILTER_POS_FOOTER,
		'summary' => "<div class='summary' style=' padding-top:15px; padding-bottom:6px; font-size:16px; '>共 {totalCount} 门课程</div>",
		'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<span style="color:#959595; font-size:16px; ">空</span>'],
		'pager'=>[
			   //'options'=>['class'=>'hidden']//关闭自带分页
			   'maxButtonCount'=>20,
			   'firstPageLabel'=>"首页",
			   'prevPageLabel'=>'上一页',
			   'nextPageLabel'=>'下一页',
			   'lastPageLabel'=>'尾页',
	   ],
        'columns' => [
            
			//['class' => 'yii\grid\SerialColumn'],
			[
				'class' => 'yii\grid\SerialColumn',
				'headerOptions' => [ 'width' => '5%', "style" => "color:#1B809E; font-weight:normal; text-align:center; " ],
				'contentOptions' => [ 'style' => "text-align:center; " ],
			],	

            //'std_name',
			[
				'attribute' => 'std_name',
				'value' => function ($model) {

					return $model["std_name"];

				},
				'headerOptions' => [ 'width' => '15%', "style" => "color:#1B809E; font-weight:normal; " ],
				'contentOptions' => [ 'style' => "color:#333333; " ],
				"label"=>"学生姓名",
				"format"=>"raw",
			],

			'std_age',
            'class_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

<?php
	$this->endCache();
}
?>	
</div>
