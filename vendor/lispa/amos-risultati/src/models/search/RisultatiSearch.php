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

use lispa\amos\risultati\models\Risultati;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class RisultatiSearch
 * RisultatiSearch represents the model behind the search form about `lispa\amos\risultati\models\Risultati`.
 * @package lispa\amos\risultati\models\search
 */
class RisultatiSearch extends Risultati
{
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['stato', 'titolo_dellinnovazione', 'sommario', 'e_una_innovazione_prevalenteme', 'sito_web_per_approfondimento_p', 'cosa_ce_oggi_che_prima_non_cer', 'e_importante_sapere_anche_ques', 'qual_e_attualmente_il_mercato_', 'ce_un_mercato_geografico_di_ri', 'in_che_modo_il_lavoro_in_partn', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['coerenza_ads_tag', 'referente', 'qual_e_laziendaorganismo_di_ri'], 'number'],
            ['attrTecnologieRisultatiMm', 'safe'],
            ['attrStadioSviluppoRisultatiMm', 'safe'],
            ['attrProtezioneInnovazioneRisultatiMm', 'safe'],
            ['attrBisognoPerSviluppoRisultatiMm', 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Risultati::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('tecnologieRisultati');
        $query->joinWith('stadioSviluppoRisultati');
        $query->joinWith('protezioneInnovazioneRisultati');
        $query->joinWith('bisognoPerSviluppoRisultati');

        $dataProvider->setSort([
            'attributes' => [
                'stato' => [
                    'asc' => ['risultati.stato' => SORT_ASC],
                    'desc' => ['risultati.stato' => SORT_DESC],
                ],
                'titolo_dellinnovazione' => [
                    'asc' => ['risultati.titolo_dellinnovazione' => SORT_ASC],
                    'desc' => ['risultati.titolo_dellinnovazione' => SORT_DESC],
                ],
                'sommario' => [
                    'asc' => ['risultati.sommario' => SORT_ASC],
                    'desc' => ['risultati.sommario' => SORT_DESC],
                ],
                'e_una_innovazione_prevalenteme' => [
                    'asc' => ['risultati.e_una_innovazione_prevalenteme' => SORT_ASC],
                    'desc' => ['risultati.e_una_innovazione_prevalenteme' => SORT_DESC],
                ],
                'coerenza_ads_tag' => [
                    'asc' => ['risultati.coerenza_ads_tag' => SORT_ASC],
                    'desc' => ['risultati.coerenza_ads_tag' => SORT_DESC],
                ],
                'referente' => [
                    'asc' => ['risultati.referente' => SORT_ASC],
                    'desc' => ['risultati.referente' => SORT_DESC],
                ],
                'sito_web_per_approfondimento_p' => [
                    'asc' => ['risultati.sito_web_per_approfondimento_p' => SORT_ASC],
                    'desc' => ['risultati.sito_web_per_approfondimento_p' => SORT_DESC],
                ],
                'cosa_ce_oggi_che_prima_non_cer' => [
                    'asc' => ['risultati.cosa_ce_oggi_che_prima_non_cer' => SORT_ASC],
                    'desc' => ['risultati.cosa_ce_oggi_che_prima_non_cer' => SORT_DESC],
                ],
                'e_importante_sapere_anche_ques' => [
                    'asc' => ['risultati.e_importante_sapere_anche_ques' => SORT_ASC],
                    'desc' => ['risultati.e_importante_sapere_anche_ques' => SORT_DESC],
                ],
                'qual_e_attualmente_il_mercato_' => [
                    'asc' => ['risultati.qual_e_attualmente_il_mercato_' => SORT_ASC],
                    'desc' => ['risultati.qual_e_attualmente_il_mercato_' => SORT_DESC],
                ],
                'ce_un_mercato_geografico_di_ri' => [
                    'asc' => ['risultati.ce_un_mercato_geografico_di_ri' => SORT_ASC],
                    'desc' => ['risultati.ce_un_mercato_geografico_di_ri' => SORT_DESC],
                ],
                'in_che_modo_il_lavoro_in_partn' => [
                    'asc' => ['risultati.in_che_modo_il_lavoro_in_partn' => SORT_ASC],
                    'desc' => ['risultati.in_che_modo_il_lavoro_in_partn' => SORT_DESC],
                ],
                'qual_e_laziendaorganismo_di_ri' => [
                    'asc' => ['risultati.qual_e_laziendaorganismo_di_ri' => SORT_ASC],
                    'desc' => ['risultati.qual_e_laziendaorganismo_di_ri' => SORT_DESC],
                ],
                'tecnologieRisultati' => [
                    'asc' => ['tecnologie_risultati.denominazione' => SORT_ASC],
                    'desc' => ['tecnologie_risultati.denominazione' => SORT_DESC],
                ], 'stadioSviluppoRisultati' => [
                    'asc' => ['stadio_sviluppo_risultati.denominazione' => SORT_ASC],
                    'desc' => ['stadio_sviluppo_risultati.denominazione' => SORT_DESC],
                ], 'protezioneInnovazioneRisulta' => [
                    'asc' => ['protezione_innovazione_risultati.denominazione' => SORT_ASC],
                    'desc' => ['protezione_innovazione_risultati.denominazione' => SORT_DESC],
                ], 'bisognoPerSviluppoRisultati' => [
                    'asc' => ['bisogno_per_sviluppo_risultati.denominazione' => SORT_ASC],
                    'desc' => ['bisogno_per_sviluppo_risultati.denominazione' => SORT_DESC],
                ],]]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'coerenza_ads_tag' => $this->coerenza_ads_tag,
            'referente' => $this->referente,
            'qual_e_laziendaorganismo_di_ri' => $this->qual_e_laziendaorganismo_di_ri,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'risultati.stato', $this->stato])
            ->andFilterWhere(['like', 'risultati.titolo_dellinnovazione', $this->titolo_dellinnovazione])
            ->andFilterWhere(['like', 'risultati.sommario', $this->sommario])
            ->andFilterWhere(['like', 'risultati.e_una_innovazione_prevalenteme', $this->e_una_innovazione_prevalenteme])
            ->andFilterWhere(['like', 'risultati.sito_web_per_approfondimento_p', $this->sito_web_per_approfondimento_p])
            ->andFilterWhere(['like', 'risultati.cosa_ce_oggi_che_prima_non_cer', $this->cosa_ce_oggi_che_prima_non_cer])
            ->andFilterWhere(['like', 'risultati.e_importante_sapere_anche_ques', $this->e_importante_sapere_anche_ques])
            ->andFilterWhere(['like', 'risultati.qual_e_attualmente_il_mercato_', $this->qual_e_attualmente_il_mercato_])
            ->andFilterWhere(['like', 'risultati.ce_un_mercato_geografico_di_ri', $this->ce_un_mercato_geografico_di_ri])
            ->andFilterWhere(['like', 'risultati.in_che_modo_il_lavoro_in_partn', $this->in_che_modo_il_lavoro_in_partn]);
        $query->andFilterWhere(['like', new \yii\db\Expression('tecnologie_risultati.denominazione'), $this->attrTecnologieRisultatiMm]);
        $query->andFilterWhere(['like', new \yii\db\Expression('stadio_sviluppo_risultati.denominazione'), $this->attrStadioSviluppoRisultatiMm]);
        $query->andFilterWhere(['like', new \yii\db\Expression('protezione_innovazione_risultati.denominazione'), $this->attrProtezioneInnovazioneRisultatiMm]);
        $query->andFilterWhere(['like', new \yii\db\Expression('bisogno_per_sviluppo_risultati.denominazione'), $this->attrBisognoPerSviluppoRisultatiMm]);

        return $dataProvider;
    }
}
