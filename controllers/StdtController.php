<?php

namespace app\controllers;

use Yii;
use app\models\Stdfile;
use app\models\Stdt;
use app\models\Classt;
use app\models\StdtSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\db\Expression;
use yii\base\Exception;

/**
 * StdtController implements the CRUD actions for Stdt model.
 */
class StdtController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Stdt models.
     * @return mixed
     */
    public function actionIndex()
    {		
        $searchModel = new StdtSearch();
		$dataProvider = $searchModel -> searchbysql( Yii::$app->request->queryParams );

		$cache = Yii::$app->cache; 
		$c_list = $cache->get( 'cache_classt' );

		if ( $c_list === false ) {
			
			//搜索参数
			$c_list = Classt::find() -> orderBy('id DESC')->all(); //获取 “班级” 数据

			$cacheData = $c_list;
			//set方法的第一个参数是我们的数据对应的key值，方便我们获取到 
			//第二个参数即是我们要缓存的数据 
			//第三个参数是缓存时间，如果是0，意味着永久缓存。默认是0 

			$cache->set( 'cache_classt', $cacheData, 0*0 );

			$c_list = $cache->get( 'cache_classt' );
		}		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'c_list' => $c_list,
        ]);
    }

    /**
     * Displays a single Stdt model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Stdt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /**public function actionCreate_bak()
    {
        $model = new Stdt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }*/

	public function actionCreate() //
    {			
		$model = new UploadForm();

		return $this->render( 'create', [
			'model' => $model,			
		] );
    }

	public function actionDoupload() //
    { 		
		if (
			Yii::$app->request->isPost
		) {			
			$post_params = Yii::$app->request->post(); 
			$transaction = Yii::$app->db->beginTransaction();

			try{							
				$model = new UploadForm();
				$model -> data_list = UploadedFile::getInstances( $model, 'data_list' ); 
				$model -> std_name = $post_params['UploadForm']['std_name'];
				$model -> std_age = $post_params['UploadForm']['std_age'];

				if (
					$model -> data_list 
					and
					$model -> validate()
				) { 

					$std_obj = new Stdt();
					$std_obj -> std_name = $model -> std_name;
					$std_obj -> std_age = $model -> std_age;

					if ( 
						$std_obj->validate() 
						and
						$std_obj->save() 
					) {
						
						foreach( 
							$model -> data_list as $file 
						) {
							
							//设置上传路径
							$path = './uploads';

							if(!is_dir($path) || !is_writable($path)) {  
							
								\yii\helpers\FileHelper::createDirectory($path,0777,true); //创建文件目录
							}

							//文件名处理
							$f_name = $file -> baseName . '.' . $file -> extension;
							
							$std_file_obj = new Stdfile();								
							$std_file_obj -> std_id = $std_obj -> id;
							$std_file_obj -> f_name = $f_name;

							if ( 
								$std_file_obj->validate() 
								and
								$std_file_obj->save() 
							) {
								//上传文件
								$filePath = $path  . '/' . $f_name;
								$file -> saveAs( $filePath ); //上传到文件保存位置	
							}
						}
					}

				}else{
				
					$error=array_values( $model->getFirstErrors() )[0];
					throw new Exception($error);//抛出异常
				}

				$transaction -> commit();
			
			}catch ( \Exception $e ) {
						
				//如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
				$transaction -> rollBack();					
				//return Helper::arrayReturn(['status'=>false,'msg'=>$e->getMessage()]);
				var_dump( $e->getMessage() );
				exit;
			}

			return $this->redirect( [ 'stdt/index' ] );		
		}			
    }

    /**
     * Updates an existing Stdt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Stdt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Stdt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stdt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stdt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
