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

    public static function tableName()
    {
        return 'litter';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->birthdate = strtotime($this->birthdate); // форматируем дату из datepecker'a в timestamp
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['birthdate', 'father_id', 'mother_id', 'charcode'], 'required'],
            [['father_id', 'mother_id'], 'integer'],
            [['birthdate'], 'date', 'format' => 'php:d.m.Y'],
            [['charcode'], 'string', 'max' => 2],
            [['father_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pet::className(), 'targetAttribute' => ['father_id' => 'id']],
            [['mother_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pet::className(), 'targetAttribute' => ['mother_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
            'charcode' => Yii::t('forms', 'Charcode'),
            'birthdate' => Yii::t('forms', 'Birthdate'),
            'father_id' => Yii::t('forms', 'Father ID'),
            'mother_id' => Yii::t('forms', 'Mother ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPets()
    {
        return $this->hasMany(Pet::className(), ['litter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFather()
    {
        return $this->hasOne(Pet::className(), ['id' => 'father_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMother()
    {
        return $this->hasOne(Pet::className(), ['id' => 'mother_id']);
    }
}
