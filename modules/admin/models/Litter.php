<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "litter".
 *
 * @property integer $id
 * @property string $charcode
 * @property string $birthdate
 * @property integer $father_id
 * @property integer $mother_id
 *
 * @property Kitten[] $kittens
 * @property Cat $father
 * @property Cat $mother
 */
class Litter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'litter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['birthdate'], 'required'],
            [['birthdate'], 'safe'],
            [['father_id', 'mother_id'], 'integer'],
            [['charcode'], 'string', 'max' => 2],
            [['father_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cat::className(), 'targetAttribute' => ['father_id' => 'id']],
            [['mother_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cat::className(), 'targetAttribute' => ['mother_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cat', 'ID'),
            'charcode' => Yii::t('cat', 'Charcode'),
            'birthdate' => Yii::t('cat', 'Birthdate'),
            'father_id' => Yii::t('cat', 'Father ID'),
            'mother_id' => Yii::t('cat', 'Mother ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKittens()
    {
        return $this->hasMany(Kitten::className(), ['litter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFather()
    {
        return $this->hasOne(Cat::className(), ['id' => 'father_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMother()
    {
        return $this->hasOne(Cat::className(), ['id' => 'mother_id']);
    }
}
