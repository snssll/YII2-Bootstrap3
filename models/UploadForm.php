<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $data_list;
	public $std_name;
	public $std_age;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
			[['std_name', 'std_age'], 'required'],
            [['std_age'], 'integer'],
            [['std_name'], 'string', 'max' => 50],
			[['data_list'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf', 'maxFiles' => 100 ],

        ];

		/**
		[ 
			[ 'data_list' ], 'file', 
			'skipOnEmpty' => false, 
			'checkExtensionByMimeType' => false, 
			'extensions' => 'pdf', 
			'maxFiles' => 100 
		],
		**/
    }

	public function attributeLabels()
    {
        return [

			'data_list' => Yii::t('app', '文件'),
        
		];
    }
}

?>
