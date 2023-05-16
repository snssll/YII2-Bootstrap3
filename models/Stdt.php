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
class Stdt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'std_t';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['std_name', 'std_age'], 'required'],
            [['std_age'], 'integer'],
            [['std_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'std_name' => 'Std Name',
            'std_age' => 'Std Age',
        ];
    }
}
