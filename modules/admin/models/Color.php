<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "color".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * @property Cat[] $cats
 * @property Kitten[] $kittens
 */
class Color extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'color';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cat', 'ID'),
            'name' => Yii::t('cat', 'Color abbreviation'),
            'description' => Yii::t('cat', 'Color name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCats()
    {
        return $this->hasMany(Cat::className(), ['color_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKittens()
    {
        return $this->hasMany(Kitten::className(), ['color_id' => 'id']);
    }
}
