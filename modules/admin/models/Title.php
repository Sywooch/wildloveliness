<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "title".
 *
 * @property integer $id
 * @property string $abbr
 * @property string $description
 *
 * @property Cat[] $cats
 * @property Kitten[] $kittens
 */
class Title extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'title';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['abbr'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cat', 'ID'),
            'abbr' => Yii::t('cat', 'Title abbreviation'),
            'description' => Yii::t('cat', 'Title name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCats()
    {
        return $this->hasMany(Cat::className(), ['title_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKittens()
    {
        return $this->hasMany(Kitten::className(), ['title_id' => 'id']);
    }
}
