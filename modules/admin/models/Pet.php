<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "pet".
 *
 * @property int $id
 * @property string $name Pet name
 * @property string $gender Gender
 * @property int $birthdate Birthdate
 * @property int $is_owned Is owned
 * @property int $title_id Titles
 * @property int $color_id Color
 * @property int $status_id
 * @property string $imgs JSON list of images
 * @property int $litter_id
 *
 * @property Color $color
 * @property Title $title
 * @property Status $status
 */
class Pet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'gender', 'birthdate', 'is_owned', 'color_id'], 'required'],
            [['is_owned', 'title_id', 'color_id', 'status_id', 'litter_id'], 'integer'],
            [['birthdate'], 'date', 'format' => 'php:d.m.Y'],
            [['imgs'], 'string'],
            [['name'], 'string', 'max' => 255],
            ['gender', 'validateGender'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
            [['title_id'], 'exist', 'skipOnError' => true, 'targetClass' => Title::className(), 'targetAttribute' => ['title_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['litter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Litter::className(), 'targetAttribute' => ['litter_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
            'name' => Yii::t('forms', 'Name'),
            'gender' => Yii::t('forms', 'Gender'),
            'birthdate' => Yii::t('forms', 'Birthdate'),
            'is_owned' => Yii::t('forms', 'Is owned'),
            'title_id' => Yii::t('forms', 'Title'),
            'color_id' => Yii::t('forms', 'Color'),
            'status_id' => Yii::t('forms', 'Status'),
            'imgs' => Yii::t('forms', 'Imgs'),
            'litter_id' => Yii::t('forms', 'Litter'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->birthdate = strtotime($this->birthdate); // форматируем дату из datepecker'a в timestamp

            // получаем URLs для картинок
            $imgsArr = array();
            $n = 0;
            while(Yii::$app->request->post('img'.$n)){
                $imgsArr[$n] = Yii::$app->request->post('img'.$n);
                $n++;
            }
            $this->imgs = Json::encode($imgsArr);
            return true;
        } else {
            return false;
        }
    }

    public function validateGender($attribute, $params, $validator)
    {
        if (!in_array($this->$attribute, ['m', 'f'])) {
            $this->addError($attribute, Yii::t('forms', 'The gender must be either "m" or "f".'));
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
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLitter()
    {
        return $this->hasOne(Litter::className(), ['id' => 'litter_id']);
    }
}
