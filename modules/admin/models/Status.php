<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Kitten[] $kittens
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('kitten', 'ID'),
            'title' => Yii::t('kitten', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKittens()
    {
        return $this->hasMany(Kitten::className(), ['status_id' => 'id']);
    }


}
