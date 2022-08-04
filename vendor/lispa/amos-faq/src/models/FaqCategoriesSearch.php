<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\faq
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

namespace lispa\amos\faq\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FaqCategoriesSearch represents the model behind the search form about `lispa\amos\src\models\FaqCategories`.
 */
class FaqCategoriesSearch extends FaqCategories
{
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by', 'version'], 'integer'],
            [['titolo', 'descrizione', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
// bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = FaqCategories::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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
            'version' => $this->version,
        ]);

        $query->andFilterWhere(['like', 'titolo', $this->titolo])
            ->andFilterWhere(['like', 'descrizione', $this->descrizione]);

        return $dataProvider;
    }
}
