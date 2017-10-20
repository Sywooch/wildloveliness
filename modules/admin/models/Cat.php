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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'birthdate', 'gender', 'color_id', 'title_id', 'is_owned'], 'required'],
            [['birthdate'], 'safe'],
            [['title_id', 'color_id', 'is_owned'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['gender', 'validateGender'],

            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
            [['title_id'], 'exist', 'skipOnError' => true, 'targetClass' => Title::className(), 'targetAttribute' => ['title_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cat', 'ID'),
            'name' => Yii::t('cat', 'Name'),
            'birthdate' => Yii::t('cat', 'Date of birth'),
            'title_id' => Yii::t('cat', 'Title'),
            'gender' => Yii::t('cat', 'Gender'),
            'color_id' => Yii::t('cat', 'Color'),
            'is_owned' => Yii::t('cat', 'Is owned'),
        ];
    }



    public function validateGender($attribute, $params, $validator)
    {
        if (!in_array($this->$attribute, ['m', 'f', 'n'])) {
            $this->addError($attribute, Yii::t('cat', 'The gender must be either "m", "f" or "n".'));
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
