<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "cat".
 *
 * @property integer $id
 * @property string $name
 * @property string $birthdate
 * @property integer $title_id
 * @property string $gender
 * @property integer $color_id
 * @property integer $is_owned
 *
 * @property Color $color
 * @property Title $title
 * @property Litter[] $litters
 * @property Litter[] $litters0
 */
class Cat extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'cat';
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

    public function rules()
    {
        return [
            [['name', 'birthdate', 'gender', 'color_id', 'title_id', 'is_owned'], 'required'],
            [['title_id', 'color_id', 'is_owned', 'birthdate'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['gender', 'validateGender'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
            [['title_id'], 'exist', 'skipOnError' => true, 'targetClass' => Title::className(), 'targetAttribute' => ['title_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
            'name' => Yii::t('forms', 'Cat name'),
            'birthdate' => Yii::t('forms', 'Birthdate'),
            'title_id' => Yii::t('forms', 'Title'),
            'gender' => Yii::t('forms', 'Gender'),
            'color_id' => Yii::t('forms', 'Color'),
            'is_owned' => Yii::t('forms', 'Is owned'),
        ];
    }

    public function validateGender($attribute, $params, $validator)
    {
        if (!in_array($this->$attribute, ['m', 'f', 'n'])) {
            $this->addError($attribute, Yii::t('forms', 'The gender must be either "m", "f" or "n".'));
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitle()
    {
        return $this->hasOne(Title::className(), ['id' => 'title_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLitters()
    {
        return $this->hasMany(Litter::className(), ['father_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLitters0()
    {
        return $this->hasMany(Litter::className(), ['mother_id' => 'id']);
    }
}
