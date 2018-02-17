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
    public $birthMin;
    public $birthMax;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_owned', 'title_id', 'color_id', 'status_id', 'litter_id'], 'integer'],
            [['birthdate', 'name', 'gender', 'imgs'], 'safe'],

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
        if($params[birthMin] && $params[birthMax]) {
            // значения, полученные из datepicker'а в форме фильтра, далее передаются обратно в фильтр в виде
            $this->birthMin = $params[birthMin];
            $this->birthMax = $params[birthMax];
            // переводим полученные из datepicker'a в timestamp, для сравнения со значениями в базе
            $min = ((new DateTime($this->birthMin))->getTimestamp());
            $max = ((new DateTime($this->birthMax))->getTimestamp());
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
            ->andFilterWhere(['between', 'birthdate', $min, $max]);

        return $dataProvider;
    }
}
