<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "std_t".
 *
 * @property integer $id
 * @property string $std_name
 * @property integer $std_age
 */
class Stdfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'std_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['f_name', 'std_id'], 'required'],
            [['std_id'], 'integer'],
            [['f_name'], 'string', 'max' => 50],		
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
           
        ];
    }
}
