<?php

namespace app\modules\admin\models;

use app\helpers\DevHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Pet;
use DateTime;

/**
 * PetSearch represents the model behind the search form about `app\models\Pet`.
 */
class PetSearch extends Pet
{
    public $birthRange1;
    public $birthRange2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_owned', 'title_id', 'color_id', 'status_id', 'litter_id'], 'integer'],
            [['birthdate', 'birthRange1','birthdaterange2', 'name', 'gender', 'imgs'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if($params[birthRange1] || $params[birthRange2]) {
            // переводим полученные из datepicker'a в timestamp для сравнения в базе
            $b1 = ((new DateTime($params[birthRange1]))->getTimestamp());
            $b2 = ((new DateTime($params[birthRange2]))->getTimestamp());
        }

        $query = Pet::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_owned' => $this->is_owned,
            'title_id' => $this->title_id,
            'color_id' => $this->color_id,
            'status_id' => $this->status_id,
            'litter_id' => $this->litter_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'imgs', $this->imgs])
            ->andFilterWhere(['between', 'birthdate', $b1, $b2]);

        return $dataProvider;
    }
}
