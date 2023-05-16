<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Stdt;

use yii\data\SqlDataProvider;

/**
 * StdtSearch represents the model behind the search form about `app\models\Stdt`.
 */
class StdtSearch extends Stdt
{
    /**
     * @inheritdoc
     */
	public $classname;
    public function rules()
    {
        return [
            [['id', 'std_age'], 'integer'],
            [['std_name', 'classname'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Stdt::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'std_age' => $this->std_age,
        ]);

        $query->andFilterWhere(['like', 'std_name', $this->std_name]);

        return $dataProvider;
    }

	public function searchbysql($params)
    {
		$sql = "					
				select
					std_t.std_name, 
					std_t.std_age,
					class_t.class_name
				from
					std_t,
					std_class_t,
					class_t
				where 
					std_class_t.std_id = std_t.id
					and
					std_class_t.class_id = class_t.id				
			  ";
		
		$sql_count = "    
				select
					count( std_t.id )
				from
					std_t,
					std_class_t,
					class_t
				where 
					std_class_t.std_id = std_t.id
					and
					std_class_t.class_id = class_t.id
					 ";

		$get = Yii::$app->request->get(); 

		$stdname = "";
		$classname = "";

		if( 
			!empty( $get['StdtSearch'] ) 
		) {
			$stdname_temp = $get['StdtSearch']['stdname'];
			$classname_temp = $get['StdtSearch']['classname'];
		
			$sql .= " AND std_t.std_name LIKE :status1 ";
			$sql_count .= " AND std_t.std_name LIKE :status1 ";
			$stdname = "%" . $stdname_temp . "%";

			if( 
				!empty( $classname_temp ) 
			) {
				$sql .= " AND std_class_t.class_id = :status2 ";
				$sql_count .= " AND std_class_t.class_id = :status2 ";
				$classname = $classname_temp;
			}else{
				$sql .= " AND 1 = :status2 ";
				$sql_count .= " AND 1 = :status2 ";
				$classname = 1;			
			}			
		}

		$totalCount = Yii::$app->db->createCommand( $sql_count, [ 
														  ':status1' => $stdname, 
														  ':status2' => $classname, 
													   ] ) -> queryScalar();

		$dataProvider = new SqlDataProvider([  
	       'sql' => $sql,  
		   'params' => [ 
				':status1' => $stdname, 
				':status2' => $classname, 
		   ],
           'totalCount' => $totalCount,
           'sort' => [  
                'attributes' => [  
								'std_name'=>[  
											'asc' => ['std_name' => SORT_ASC],
											'desc' => ['std_name' => SORT_DESC],  
											'default' => SORT_ASC,  
											'label' => 'ID-NUM',  
											 ],

								'std_age'=>[  
											'asc' => ['std_age' => SORT_ASC],
											'desc' => ['std_age' => SORT_DESC],  
											'default' => SORT_DESC,  
											'label' => 'ID-NUM',  
											 ],
								],  

				'defaultOrder' => [ 'std_age' => SORT_DESC ],
	        ],    
	       'pagination' => [  
	            'pageSize' => 3,  
	       ],  
	 
		]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }      

        return $dataProvider;
    }


}
