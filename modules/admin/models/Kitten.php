<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "kitten".
 *
 * @property integer $id
 * @property string $name
 * @property integer $litter_id
 * @property integer $title_id
 * @property string $gender
 * @property integer $color_id
 * @property integer $status_id
 *
 * @property Color $color
 * @property Status $status
 * @property Title $title
 * @property Litter $litter
 */
class Kitten extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'kitten';
    }

    public function rules()
    {
        return [
            [['name', 'litter_id', 'gender', 'color_id'], 'required'],
            [['litter_id', 'title_id', 'color_id', 'status_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['gender', 'validateGender'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['title_id'], 'exist', 'skipOnError' => true, 'targetClass' => Title::className(), 'targetAttribute' => ['title_id' => 'id']],
            [['litter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Litter::className(), 'targetAttribute' => ['litter_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
            'name' => Yii::t('forms', 'Kitten name'),
            'litter_id' => Yii::t('forms', 'Litter'),
            'title_id' => Yii::t('forms', 'Title'),
            'gender' => Yii::t('forms', 'Gender'),
            'color_id' => Yii::t('forms', 'Color'),
            'status_id' => Yii::t('forms', 'Status'),
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
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
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
    public function getLitter()
    {
        return $this->hasOne(Litter::className(), ['id' => 'litter_id']);
    }
}
