<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\risultati
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

namespace lispa\amos\risultati\models\search;

use lispa\amos\risultati\models\StadioSviluppoRisultati;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class StadioSviluppoRisultatiSearch
 * StadioSviluppoRisultatiSearch represents the model behind the search form about `lispa\amos\risultati\models\StadioSviluppoRisultati`.
 * @package lispa\amos\risultati\models\search
 */
class StadioSviluppoRisultatiSearch extends StadioSviluppoRisultati
{
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['denominazione', 'descrizione', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = StadioSviluppoRisultati::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'denominazione' => [
                    'asc' => ['stadio_sviluppo_risultati.denominazione' => SORT_ASC],
                    'desc' => ['stadio_sviluppo_risultati.denominazione' => SORT_DESC],
                ],
                'descrizione' => [
                    'asc' => ['stadio_sviluppo_risultati.descrizione' => SORT_ASC],
                    'desc' => ['stadio_sviluppo_risultati.descrizione' => SORT_DESC],
                ],
            ]]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'stadio_sviluppo_risultati.denominazione', $this->denominazione])
            ->andFilterWhere(['like', 'stadio_sviluppo_risultati.descrizione', $this->descrizione]);

        return $dataProvider;
    }
}
